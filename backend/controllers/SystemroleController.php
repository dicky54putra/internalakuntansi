<?php

namespace backend\controllers;

use Yii;
use backend\models\Systemrole;
use backend\models\Userrole;
use backend\models\SystemroleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SystemroleController implements the CRUD actions for Systemrole model.
 */
class SystemroleController extends Controller
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
     * Lists all Systemrole models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) { 
            header("Location: index.php");
            exit;
        }
        
        $searchModel = new SystemroleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Systemrole model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) { 
            header("Location: index.php");
            exit;
        }
		
		$userrole = Userrole::find()
			->joinWith("login")
			->where(["id_system_role"=>$id])
			->orderBy("login.nama")->all();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'userrole' => $userrole,
        ]);
    }

    /**
     * Creates a new Systemrole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) { 
            header("Location: index.php");
            exit;
        }
        
        $model = new Systemrole();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_system_role]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Systemrole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) { 
            header("Location: index.php");
            exit;
        }
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_system_role]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Systemrole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		if (Yii::$app->user->isGuest) {
			header("Location: index.php");
			exit();
		}

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Systemrole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Systemrole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Systemrole::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
