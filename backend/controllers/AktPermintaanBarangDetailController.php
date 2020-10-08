<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPermintaanBarangDetail;
use backend\models\AktPermintaanBarangDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktItem;
use yii\helpers\ArrayHelper;

/**
 * AktPermintaanBarangDetailController implements the CRUD actions for AktPermintaanBarangDetail model.
 */
class AktPermintaanBarangDetailController extends Controller
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
     * Lists all AktPermintaanBarangDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPermintaanBarangDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPermintaanBarangDetail model.
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
     * Creates a new AktPermintaanBarangDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPermintaanBarangDetail();
        $model->qty = 0;
        $model->qty_ordered = 0;
        $model->qty_rejected = 0;

        $data_item = ArrayHelper::map(AktItem::find()->all(), 'id_item','nama_item');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_item' => $data_item,
        ]);
    }

    /**
     * Updates an existing AktPermintaanBarangDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data_item = ArrayHelper::map(AktItem::find()->all(), 'id_item','nama_item');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_item' => $data_item,
        ]);
    }

    /**
     * Deletes an existing AktPermintaanBarangDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]);
    }

    /**
     * Finds the AktPermintaanBarangDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPermintaanBarangDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPermintaanBarangDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
