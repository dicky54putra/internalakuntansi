<?php

namespace backend\controllers;

use backend\models\AktItem;
use Yii;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktPenjualanPengirimanDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktPenjualanPengirimanDetailController implements the CRUD actions for AktPenjualanPengirimanDetail model.
 */
class AktPenjualanPengirimanDetailController extends Controller
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
     * Lists all AktPenjualanPengirimanDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenjualanPengirimanDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenjualanPengirimanDetail model.
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
     * Creates a new AktPenjualanPengirimanDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenjualanPengirimanDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penjualan_pengiriman_detail]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPenjualanPengirimanDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penjualan_pengiriman_detail]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPenjualanPengirimanDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        $penjualan_detail = AktPenjualanDetail::findOne($model->id_penjualan_detail);
        $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
        $item_stok->qty = $item_stok->qty + $model->qty_dikirim;
        $item_stok->save(FALSE);

        $item = AktItem::findOne($item_stok->id_item);

        Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil di Hapus Dari Data Barang Pengiriman']]);

        return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $penjualan_detail->id_penjualan, '#' => 'data-pengiriman']);
    }

    /**
     * Finds the AktPenjualanPengirimanDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenjualanPengirimanDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenjualanPengirimanDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
