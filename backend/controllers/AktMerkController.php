<?php

namespace backend\controllers;

use Yii;
use backend\models\AktMerk;
use backend\models\AktMerkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktMerkController implements the CRUD actions for AktMerk model.
 */
class AktMerkController extends Controller
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
     * Lists all AktMerk models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktMerkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktMerk model.
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
     * Creates a new AktMerk model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktMerk();

        $total = AktMerk::find()->count();
        $nomor = 'MI' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        
        if ($model->load(Yii::$app->request->post())) {
            $create_in_item =  Yii::$app->request->post('create-in-item');
            $update_in_item =  Yii::$app->request->post('update-in-item');
            $id =  Yii::$app->request->post('id');
            if( isset($create_in_item)) {
                $model->save();
                return $this->redirect(['akt-item/create']);
            } else if(isset($update_in_item)) {
                $model->save();
                return $this->redirect(['akt-item/update', 'id' => $id]);
            } else  {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id_merk]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor
        ]);
    }

    /**
     * Updates an existing AktMerk model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nomor = $model->kode_merk;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_merk]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor
        ]);
    }

    /**
     * Deletes an existing AktMerk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktMerk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktMerk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktMerk::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
