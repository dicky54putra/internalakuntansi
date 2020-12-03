<?php

namespace backend\controllers;

use Yii;
use backend\models\AktReturPenjualanDetail;
use backend\models\AktReturPenjualanDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktPenjualanDetail;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\AktReturPenjualan;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\models\AktItemStok;
use backend\models\AktItem;

/**
 * AktReturPenjualanDetailController implements the CRUD actions for AktReturPenjualanDetail model.
 */
class AktReturPenjualanDetailController extends Controller
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
     * Lists all AktReturPenjualanDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktReturPenjualanDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktReturPenjualanDetail model.
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
     * Creates a new AktReturPenjualanDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktReturPenjualanDetail();




        if ($model->load(Yii::$app->request->post())) {

            $model_id_retur_penjualan = Yii::$app->request->post('AktReturPenjualanDetail')['id_retur_penjualan'];
            $model_id_penjualan_detail = Yii::$app->request->post('AktReturPenjualanDetail')['id_penjualan_detail'];
            // $model_qty = Yii::$app->request->post('AktReturPenjualanDetail')['qty'];
            $model_retur = Yii::$app->request->post('AktReturPenjualanDetail')['retur'];
            $model_keterangan = Yii::$app->request->post('AktReturPenjualanDetail')['keterangan'];

            $model->id_retur_penjualan = $model_id_retur_penjualan;
            $model->id_penjualan_detail = $model_id_penjualan_detail;

            $model->retur = $model_retur;
            $model->keterangan = $model_keterangan;

            $count_retur_penjualan_detail = AktReturPenjualanDetail::find()->where(['id_retur_penjualan' => $model_id_retur_penjualan])->andWhere(['id_penjualan_detail' => $model_id_penjualan_detail])->count();

            $penjualan_detail = AktPenjualanDetail::findOne($model_id_penjualan_detail);
            $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);
            $model->qty = $penjualan_detail['qty'];

            if ($model_retur > $penjualan_detail['qty']) {
                Yii::$app->session->setFlash('danger', [['Perhatian !', ' Jumlah retur tidak boleh melebihi qty penjualan!']]);
            } else {
                if ($count_retur_penjualan_detail == 0) {
                    # code...
                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil Tersimpan di Data Retur Barang Penjualan']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian !', '' . $item->nama_item . ' Sudah Terdaftar di Data Retur Barang Penjualan']]);
                }
            }

            return $this->redirect(['akt-retur-penjualan/view', 'id' => $model->id_retur_penjualan]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionGetQtyPenjualanDetail($id)
    {
        $penjualan_detail = AktPenjualanDetail::find()->where(['id_penjualan_detail' => $id])->one();
        echo Json::encode($penjualan_detail);
    }

    /**
     * Updates an existing AktReturPenjualanDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $akt_retur_penjualan = AktReturPenjualan::findOne($model->id_retur_penjualan);

        $data_penjualan_pengiriman_detail = ArrayHelper::map(
            AktPenjualanPengirimanDetail::find()
                ->select(["akt_penjualan_pengiriman_detail.id_penjualan_pengiriman_detail", "akt_item.nama_item", "akt_penjualan_pengiriman_detail.qty_dikirim"])
                ->leftJoin("akt_penjualan_detail", "akt_penjualan_detail.id_penjualan_detail = akt_penjualan_pengiriman_detail.id_penjualan_detail")
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item_stok = akt_penjualan_detail.id_item_stok")
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->where(['id_penjualan_pengiriman' => $akt_retur_penjualan->id_penjualan_pengiriman])
                ->asArray()
                ->all(),
            'id_penjualan_pengiriman_detail',
            function ($model) {
                return $model['nama_item'] . ', Qty Dikirim : ' . $model['qty_dikirim'];
            }
        );

        if ($model->load(Yii::$app->request->post())) {

            $akt_penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::findOne($model->id_penjualan_pengiriman_detail);

            $model->qty = $akt_penjualan_pengiriman_detail->qty_dikirim;

            $count_retur_penjualan_detail = AktReturPenjualanDetail::find()->where(['id_retur_penjualan' => $model->id_retur_penjualan])->andWhere(['id_penjualan_pengiriman_detail' => $model->id_penjualan_pengiriman_detail])->count();

            if ($model->id_penjualan_pengiriman_detail == $model_sebelumnya->id_penjualan_pengiriman_detail) {
                # code...
                $model->save();
                Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Berhasil Tersimpan di Data Retur Barang Penjualan']]);
            } else {
                # code...
                if ($count_retur_penjualan_detail == 0) {
                    # code...
                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Tersimpan di Data Retur Barang Penjualan']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Sudah Terdaftar di Data Retur Barang Penjualan']]);
                }
            }


            return $this->redirect(['akt-retur-penjualan/view', 'id' => $model->id_retur_penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
            'akt_retur_penjualan' => $akt_retur_penjualan,
            'data_penjualan_pengiriman_detail' => $data_penjualan_pengiriman_detail,
        ]);
    }

    /**
     * Deletes an existing AktReturPenjualanDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Terhapus dari Data Retur Barang Penjualan']]);
        return $this->redirect(['akt-retur-penjualan/view', 'id' => $model->id_retur_penjualan]);
    }

    /**
     * Finds the AktReturPenjualanDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktReturPenjualanDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktReturPenjualanDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
