<?php

namespace backend\controllers;

use Yii;
use backend\models\AktItemStok;
use backend\models\AktItemStokSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AktGudang;

/**
 * AktItemStokController implements the CRUD actions for AktItemStok model.
 */
class AktItemStokController extends Controller
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
     * Lists all AktItemStok models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktItemStokSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktItemStok model.
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
     * Creates a new AktItemStok model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktItemStok();
        $model->id_item = $_GET['id'];
        $model->qty = 0;
        $model->hpp = 0;
        $model->min = 0;

        $data_gudang = ArrayHelper::map(AktGudang::find()->all(), 'id_gudang', 'nama_gudang');

        $model_gudang = new AktGudang();
        $total_gudang = AktGudang::find()->count();
        $nomor_gudang = 'GD' . str_pad($total_gudang + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_gudang' => $data_gudang,
            'model_gudang' => $model_gudang,
            'nomor_gudang' => $nomor_gudang
        ]);
    }

    /**
     * Updates an existing AktItemStok model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data_gudang = ArrayHelper::map(AktGudang::find()->all(), 'id_gudang', 'nama_gudang');

        $model_gudang = new AktGudang();
        $total_gudang = AktGudang::find()->count();
        $nomor_gudang = 'GD' . str_pad($total_gudang + 1, 3, "0", STR_PAD_LEFT);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_gudang' => $data_gudang,
            'model_gudang' => $model_gudang,
            'nomor_gudang' => $nomor_gudang
        ]);
    }

    /**
     * Deletes an existing AktItemStok model.
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
     * Finds the AktItemStok model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktItemStok the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktItemStok::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
