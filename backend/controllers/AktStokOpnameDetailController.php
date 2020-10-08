<?php

namespace backend\controllers;

use Yii;
use backend\models\AktStokOpnameDetail;
use backend\models\AktStokOpnameDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktStokOpname;
use yii\helpers\ArrayHelper;
use backend\models\AktItemStok;
use yii\helpers\Json;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktHistoryTransaksi;
use backend\models\AktAkun;

/**
 * AktStokOpnameDetailController implements the CRUD actions for AktStokOpnameDetail model.
 */
class AktStokOpnameDetailController extends Controller
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
     * Lists all AktStokOpnameDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktStokOpnameDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktStokOpnameDetail model.
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
     * Creates a new AktStokOpnameDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktStokOpnameDetail();
        $model->id_stok_opname = $_GET['id'];
        // $model->qty_opname = 0;

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
                return $model['nama_item'] . ' - Gudang : ' . $model['nama_gudang'] . ' - Stok : ' . $model['qty'];
            }
        );

        $akt_stok_opname = AktStokOpname::findOne($model->id_stok_opname);
        $total_hpp = 0;

        if ($model->load(Yii::$app->request->post())) {

            $update_item_stok = $model->getDataTable("AktItemStok", 'id_item_stok', $model->id_item_stok);

            $update_item_stok->qty = $model->qty_opname;
            $update_item_stok->save(FALSE);

            $model->save();

             // data for debit kredit jurnal umum detail
            $hpp = $update_item_stok->hpp * $model->qty_opname; 
            $total_hpp += $hpp;

            $jurnal_transaksi_detail = AktStokOpname::getJurnalTransaksi();
            $akt_history_transaksi = AktStokOpnameDetail::getHistoryTransaksi($akt_stok_opname->id_stok_opname);


            foreach ($jurnal_transaksi_detail as $jt) {

                $jurnal_umum_detail = AktStokOpnameDetail::getJurnalUmumDetail($jt->id_akun,$akt_history_transaksi['id_jurnal_umum']);
                $akun = $model->getDataTable("AktAkun", 'id_akun', $jt->id_akun);

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
            return $this->redirect(['akt-stok-opname/view', 'id' => $model->id_stok_opname]);
        }

        return $this->render('create', [
            'model' => $model,
            'akt_stok_opname' => $akt_stok_opname,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    public function actionGetQtyItem($id)
    {
        $item_stok = AktItemStok::find()->where(['id_item_stok' => $id])->one();
        echo Json::encode($item_stok);
    }

    /**
     * Updates an existing AktStokOpnameDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

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
                return $model['nama_item'] . ' - Gudang : ' . $model['nama_gudang'] . ' - Stok : ' . $model['qty'];
            }
        );

        $akt_stok_opname = AktStokOpname::findOne($model->id_stok_opname);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $update_item_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
                $update_item_stok->qty = $model->qty_opname;
                $update_item_stok->save(FALSE);

                $model->save();
            } else {
                # code...
                $update_item_stok_sebelumnya = AktItemStok::find()->where(['id_item_stok' => $model_sebelumnya->id_item_stok])->one();
                $update_item_stok_sebelumnya->qty = $model_sebelumnya->qty_program;
                $update_item_stok_sebelumnya->save(FALSE);

                $update_item_stok_baru = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
                $update_item_stok_baru->qty = $model->qty_opname;
                $update_item_stok_baru->save(FALSE);

                $model->save();
            }


            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Diubah']]);
            return $this->redirect(['akt-stok-opname/view', 'id' => $model->id_stok_opname]);
        }

        return $this->render('update', [
            'model' => $model,
            'akt_stok_opname' => $akt_stok_opname,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    /**
     * Deletes an existing AktStokOpnameDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $modelName = new AktStokOpnameDetail;
        $model = $this->findModel($id);

        // $update_item_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
        $update_item_stok = $modelName->getDataTable('AktItemStok', 'id_item_stok', $model->id_item_stok, 'one');
        $update_item_stok->qty = $model->qty_program;
        $update_item_stok->save(FALSE);


        $hpp = $model->qty_opname * $update_item_stok->hpp;
        $akt_history_transaksi = AktStokOpnameDetail::getHistoryTransaksi($model->id_stok_opname);
        $jurnal_umum_detail = $modelName->getDataTable('AktJurnalUmumDetail', 'id_jurnal_umum', $akt_history_transaksi['id_jurnal_umum'], 'all');


        foreach($jurnal_umum_detail as $ju) {
            $akun = $modelName->getDataTable('AktAkun', 'id_akun', $ju->id_akun);
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
        return $this->redirect(['akt-stok-opname/view', 'id' => $model->id_stok_opname]);

    }

    /**
     * Finds the AktStokOpnameDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktStokOpnameDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktStokOpnameDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
