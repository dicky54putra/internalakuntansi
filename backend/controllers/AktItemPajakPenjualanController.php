<?php

namespace backend\controllers;

use Yii;
use backend\models\AktItemPajakPenjualan;
use backend\models\AktItemPajakPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktPajak;

/**
 * AktItemPajakPenjualanController implements the CRUD actions for AktItemPajakPenjualan model.
 */
class AktItemPajakPenjualanController extends Controller
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
     * Lists all AktItemPajakPenjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktItemPajakPenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktItemPajakPenjualan model.
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
     * Creates a new AktItemPajakPenjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktItemPajakPenjualan();
        $id_item = $model->id_item = $_GET['id'];

        $array_pajak = AktPajak::find()
            ->select(['nama_pajak as value', 'id_pajak as id'])
            ->asArray()
            ->all();

        $selected_pajak = "";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
        }

        return $this->render('create', [
            'model' => $model,
            'array_pajak' => $array_pajak,
            'selected_pajak' => $selected_pajak,
            'id_item' => $id_item,
        ]);
    }

    /**
     * Updates an existing AktItemPajakPenjualan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $id_item = $model->id_item;

        $array_pajak = AktPajak::find()
            ->select(['nama_pajak as value', 'id_pajak as id'])
            ->asArray()
            ->all();

        $selected_pajak = AktPajak::findOne($model->id_pajak);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
        }

        return $this->render('update', [
            'model' => $model,
            'array_pajak' => $array_pajak,
            'selected_pajak' => $selected_pajak,
            'id_item' => $id_item,
        ]);
    }

    /**
     * Deletes an existing AktItemPajakPenjualan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
    }

    /**
     * Finds the AktItemPajakPenjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktItemPajakPenjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktItemPajakPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
