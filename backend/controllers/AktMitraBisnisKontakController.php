<?php

namespace backend\controllers;

use Yii;
use backend\models\AktMitraBisnisKontak;
use backend\models\AktMitraBisnisKontakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktMitraBisnisKontakController implements the CRUD actions for AktMitraBisnisKontak model.
 */
class AktMitraBisnisKontakController extends Controller
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
     * Lists all AktMitraBisnisKontak models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktMitraBisnisKontakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktMitraBisnisKontak model.
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
     * Creates a new AktMitraBisnisKontak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktMitraBisnisKontak();
        $model->id_mitra_bisnis = $_GET['id'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis,'#' => 'kontak']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktMitraBisnisKontak model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis,'#' => 'kontak']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktMitraBisnisKontak model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis,'#' => 'kontak']);
    }

    /**
     * Finds the AktMitraBisnisKontak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktMitraBisnisKontak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktMitraBisnisKontak::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
