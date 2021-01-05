<?php

namespace backend\controllers;

use Yii;
use backend\models\AktStokMasukDetail;
use backend\models\AktStokMasukDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktStokMasuk;
use backend\models\AktItem;
use yii\helpers\ArrayHelper;
use backend\models\AktItemStok;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktHistoryTransaksi;
use backend\models\AktAkun;

/**
 * AktStokMasukDetailController implements the CRUD actions for AktStokMasukDetail model.
 */
class AktStokMasukDetailController extends Controller
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AktStokMasukDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktStokMasukDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktStokMasukDetail model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AktStokMasukDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktStokMasukDetail();
        $model->id_stok_masuk = $_GET['id'];
        $model->qty = 0;

        $akt_stok_masuk = AktStokMasuk::findOne($_GET['id']);


        $total_hpp = 0;

        if ($model->load(Yii::$app->request->post())) {

            $update_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
            $update_stok->qty = $update_stok->qty + $model->qty;
            
            // data for debit kredit jurnal umum detail
            $hpp = $update_stok->hpp * $model->qty; 
            $total_hpp += $hpp;


            $update_stok->save(FALSE);
            $model->save();


            $stok_masuk = JurnalTransaksi::find()->where(['nama_transaksi' => 'Stok Masuk'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $stok_masuk['id_jurnal_transaksi']])->all();


            $akt_history_transaksi = AktHistoryTransaksi::find()->where(['nama_tabel' => 'akt_stok_masuk'])->andWhere(['id_tabel' => $akt_stok_masuk->id_stok_masuk])->one();


            foreach ($jurnal_transaksi_detail as $jt) {
                $jurnal_umum_detail = AktJurnalUmumDetail::find()
                                    ->where(['id_akun' => $jt->id_akun])
                                    ->andWhere(['id_jurnal_umum' => $akt_history_transaksi['id_jurnal_umum']])
                                    ->one();
                
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

                if ($akun->saldo_normal == 1 && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $jurnal_umum_detail->debit + $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun + $total_hpp;
                } else if ($akun->saldo_normal == 1 && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $jurnal_umum_detail->kredit + $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun - $total_hpp;
                } else if ($akun->saldo_normal == 2 && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $jurnal_umum_detail->debit + $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun - $total_hpp;
                } else if ($akun->saldo_normal == 2 && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $jurnal_umum_detail->kredit + $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun + $total_hpp;
                } 

                $akun->save(false);
                $jurnal_umum_detail->save(false);
            }

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
            return $this->redirect(['akt-stok-masuk/view', 'id' => $model->id_stok_masuk]);
        }

        return $this->render('create', [
            'model' => $model,
            'akt_stok_masuk' => $akt_stok_masuk,
        ]);
    }

    /**
     * Updates an existing AktStokMasukDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $akt_stok_masuk = AktStokMasuk::findOne($model->id_stok_masuk);
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok","akt_item_stok.qty", "akt_item.nama_item", "akt_gudang.nama_gudang"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return $model['nama_item'] . ' - Gudang : ' . $model['nama_gudang'] . ' - Stok : ' . $model['qty'];
            }
        );

        
        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                if ($model->qty == $model_sebelumnya->qty) {
                    $model->save();
                } else {
                    $update_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
                    $update_stok->qty = ($update_stok->qty - $model_sebelumnya->qty) + $model->qty;
                    $update_stok->save(FALSE);
                    $model->save();
                }
            } else {
                $update_stok = AktItemStok::find()->where(['id_item_stok' => $model_sebelumnya->id_item_stok])->one();
                $update_stok->qty = $update_stok->qty - $model_sebelumnya->qty;
                $update_stok->save(FALSE);
                
                $update_stok_item_baru = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
                $update_stok_item_baru->qty = $update_stok_item_baru->qty + $model->qty;
                $update_stok_item_baru->save(FALSE);
                
                $model->save();
            }
            

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
            return $this->redirect(['akt-stok-masuk/view', 'id' => $model->id_stok_masuk]);
        }

        return $this->render('update', [
            'model' => $model,
            'akt_stok_masuk' => $akt_stok_masuk,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    /**
     * Deletes an existing AktStokMasukDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $update_stok = AktItemStok::find()
        ->where(['id_item_stok' => $model->id_item_stok])
        ->one();
        
        $update_stok->qty = $update_stok->qty - $model->qty;
        $update_stok->save(FALSE);

        $hpp = $model->qty * $update_stok->hpp;

        $akt_history_transaksi = AktHistoryTransaksi::find()
        ->where(['id_tabel' => $model->id_stok_masuk])
        ->andWhere(['nama_tabel' => 'akt_stok_masuk'])
        ->one();

        
        $jurnal_umum_detail = AktJurnalUmumDetail::find()
        ->where(['id_jurnal_umum' => $akt_history_transaksi['id_jurnal_umum']])
        ->all();

        foreach($jurnal_umum_detail as $ju) {
            $akun = AktAkun::find()->where(['id_akun' => $ju->id_akun])->one();
            
            if($ju->debit > 0 ) {
                $ju->debit = $ju->debit - $hpp;
            } elseif ($ju->kredit > 0 ) {
                $ju->kredit = $ju->kredit - $hpp;
            }

            $akun->saldo_akun = $akun->saldo_akun - $hpp;

            $akun->save(false);
            $ju->save(false);
        }



        $model->delete();

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Dihapus']]);
        return $this->redirect(['akt-stok-masuk/view', 'id' => $model->id_stok_masuk]);
    }

    /**
     * Finds the AktStokMasukDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktStokMasukDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktStokMasukDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
