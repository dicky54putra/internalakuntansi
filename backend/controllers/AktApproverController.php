<?php

namespace backend\controllers;

use Yii;
use backend\models\AktApprover;
use backend\models\AktApproverSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\Login;
use yii\helpers\ArrayHelper;

/**
 * AktApproverController implements the CRUD actions for AktApprover model.
 */
class AktApproverController extends Controller
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
     * Lists all AktApprover models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktApproverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktApprover model.
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
     * Creates a new AktApprover model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktApprover();

        // $data_login = ArrayHelper::map(Login::find()->leftJoin("user_role", "user_role.id_login = login.id_login")->where(['!=', 'user_role.id_system_role', 1])->orderBy("nama")->all(), 'id_login', 'nama');
        $data_login = ArrayHelper::map(Login::find()->orderBy("nama")->all(), 'id_login', 'nama');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id_approver]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_login' => $data_login,
        ]);
    }

    /**
     * Updates an existing AktApprover model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // $data_login = ArrayHelper::map(Login::find()->leftJoin("user_role", "user_role.id_login = login.id_login")->where(['!=', 'user_role.id_system_role', 1])->orderBy("nama")->all(), 'id_login', 'nama');

        $data_login = ArrayHelper::map(Login::find()->leftJoin("user_role", "user_role.id_login = login.id_login")->orderBy("nama")->all(), 'id_login', 'nama');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id_approver]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_login' => $data_login,
        ]);
    }

    /**
     * Deletes an existing AktApprover model.
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
     * Finds the AktApprover model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktApprover the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktApprover::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
