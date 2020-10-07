<?php

namespace backend\controllers;

use Yii;
use backend\models\AktKasBank;
use backend\models\AktKasBankSearch;
use backend\models\AktMataUang;
use backend\models\AktAkun;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktKasBankController implements the CRUD actions for AktKasBank model.
 */
class AktKasBankController extends Controller
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
     * Lists all AktKasBank models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktKasBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktKasBank model.
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
     * Creates a new AktKasBank model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktKasBank();
        $model->id_mata_uang = 1;
        // $uang = AktKasBank::find()
        //     ->andWhere(['id_kas_bank' => $model->id_kas_bank])
        //     ->count();

        $total = AktKasBank::find()->count();


        $nomor = "KB".str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_kas_bank]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Updates an existing AktKasBank model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_kas_bank]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $model->kode_kas_bank,
        ]);
    }

    /**
     * Deletes an existing AktKasBank model.
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
     * Finds the AktKasBank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktKasBank the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktKasBank::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
