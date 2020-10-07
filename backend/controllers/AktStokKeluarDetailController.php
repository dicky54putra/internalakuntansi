<?php

namespace backend\controllers;

use Yii;
use backend\models\AktStokKeluarDetail;
use backend\models\AktStokKeluarDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktStokKeluar;
use backend\models\AktItem;
use yii\helpers\ArrayHelper;
use backend\models\AktItemStok;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktHistoryTransaksi;
use backend\models\AktAkun;

/**
 * AktStokKeluarDetailController implements the CRUD actions for AktStokKeluarDetail model.
 */
class AktStokKeluarDetailController extends Controller
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
     * Lists all AktStokKeluarDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktStokKeluarDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktStokKeluarDetail model.
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
     * Creates a new AktStokKeluarDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktStokKeluarDetail();
        $model->id_stok_keluar = $_GET['id'];
        $model->qty = 0;

        $akt_stok_keluar = AktStokKeluar::findOne($_GET['id']);

        $total_hpp = 0;

        if ($model->load(Yii::$app->request->post())) {

            $item_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();

            if ($model->qty > $item_stok->qty) {
                # code...
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Quantity Yang Di Inputkan Melebihi Stok']]);
            } else {
                # code...
                $item_stok->qty = $item_stok->qty - $model->qty;
                $item_stok->save(FALSE);


                // data for debit kredit jurnal umum detail
                $hpp = $item_stok->hpp * $model->qty; 
                $total_hpp += $hpp;

                $model->save();

                $stok_keluar = JurnalTransaksi::find()->where(['nama_transaksi' => 'Stok Keluar'])->one();
                $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $stok_keluar['id_jurnal_transaksi']])->all();
    
    
                $akt_history_transaksi = AktHistoryTransaksi::find()->where(['nama_tabel' => 'akt_stok_keluar'])->andWhere(['id_tabel' => $akt_stok_keluar->id_stok_keluar])->one();
    
    
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
            }

            return $this->redirect(['akt-stok-keluar/view', 'id' => $model->id_stok_keluar]);
        }

        return $this->render('create', [
            'model' => $model,
            'akt_stok_keluar' => $akt_stok_keluar,
            // 'data_item_stok' => $data_item_stok,
        ]);
    }

    /**
     * Updates an existing AktStokKeluarDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $akt_stok_keluar = AktStokKeluar::findOne($model->id_stok_keluar);
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        if ($model->load(Yii::$app->request->post())) {

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $item_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();

                if ($model->qty == $model_sebelumnya->qty) {
                    # code...
                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Diubah']]);
                } else {
                    # code...
                    $qty_gabungan = $item_stok->qty + $model_sebelumnya->qty;
                    if ($model->qty > $qty_gabungan) {
                        # code...
                        Yii::$app->session->setFlash('danger', [['Perhatian!', 'Quantity Yang Di Inputkan Melebihi Stok']]);
                    } else {
                        # code...
                        $item_stok->qty = ($item_stok->qty + $model_sebelumnya->qty) - $model->qty;
                        $item_stok->save(FALSE);

                        $model->save();
                        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Diubah']]);
                    }
                }
            } else {
                # code...
                $item_stok_baru = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();

                if ($model->qty > $item_stok_baru->qty) {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Quantity Yang Di Inputkan Melebihi Stok']]);
                } else {
                    # code...
                    $item_stok = AktItemStok::find()->where(['id_item_stok' => $model_sebelumnya->id_item_stok])->one();
                    $item_stok->qty = $item_stok->qty + $model_sebelumnya->qty;
                    $item_stok->save(FALSE);

                    $item_stok_baru->qty = $item_stok_baru->qty - $model->qty;
                    $item_stok_baru->save(FALSE);

                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Diubah']]);
                }
            }

            return $this->redirect(['akt-stok-keluar/view', 'id' => $model->id_stok_keluar]);
        }

        return $this->render('update', [
            'model' => $model,
            'akt_stok_keluar' => $akt_stok_keluar,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    /**
     * Deletes an existing AktStokKeluarDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $item_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
        $item_stok->qty = $item_stok->qty + $model->qty;
        $item_stok->save(FALSE);

        $hpp = $model->qty * $item_stok->hpp;

        $akt_history_transaksi = AktHistoryTransaksi::find()
        ->where(['id_tabel' => $model->id_stok_keluar])
        ->andWhere(['nama_tabel' => 'akt_stok_keluar'])
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

            $akun->saldo_akun = $akun->saldo_akun + $hpp;

            $akun->save(false);
            $ju->save(false);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Dihapus']]);
        return $this->redirect(['akt-stok-keluar/view', 'id' => $model->id_stok_keluar]);
    }

    /**
     * Finds the AktStokKeluarDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktStokKeluarDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktStokKeluarDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
