<?php

namespace backend\controllers;

use Yii;
use backend\models\AktProduksiBomDetailHp;
use backend\models\AktItemStok;
use backend\models\AktProduksiBomDetailHpSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktProduksiBomDetailHpController implements the CRUD actions for AktProduksiBomDetailHp model.
 */
class AktProduksiBomDetailHpController extends Controller
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
     * Lists all AktProduksiBomDetailHp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktProduksiBomDetailHpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktProduksiBomDetailHp model.
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
     * Creates a new AktProduksiBomDetailHp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktProduksiBomDetailHp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_produksi_bom_detail_hp]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktProduksiBomDetailHp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_item = new AktItemStok;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-produksi-bom/view', 'id' => $model->id_produksi_bom]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_item' => $model_item
        ]);
    }

    /**
     * Deletes an existing AktProduksiBomDetailHp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['akt-produksi-bom/view', 'id' => $model->id_produksi_bom]);
    }

    /**
     * Finds the AktProduksiBomDetailHp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktProduksiBomDetailHp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktProduksiBomDetailHp::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
