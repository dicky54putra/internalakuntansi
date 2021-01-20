<?php

namespace backend\controllers;

use Yii;
use backend\models\RequestFitur;
use backend\models\RequestFiturSearch;
use backend\models\Foto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RequestFiturController implements the CRUD actions for RequestFitur model.
 */
class RequestFiturController extends Controller
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
     * Lists all RequestFitur models.
     * @return mixed
     */
    public function actionIndex()
    {
		if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit();
        }
		
        $searchModel = new RequestFiturSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RequestFitur model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit();
        }

        if (!empty(Yii::$app->request->get('id_hapus')))
        {
            Foto::deleteAll(["id_foto"=>Yii::$app->request->get('id_hapus')]);        
        }

        $foto = Foto::find()->where(["id_tabel"=>$id, "nama_tabel"=>"request_fitur"])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'foto' => $foto,
        ]);
    }

    public function actionUpload()
    {
       
        if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit();
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id_ba_perbaikan]);
        // }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);
        $model = new Foto();

        
 
        if (Yii::$app->request->isPost) {

            
            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');
            
            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        } else {
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        }
    }

    /**
     * Creates a new RequestFitur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit();
        }
		
        $model = new RequestFitur();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_request_fitur]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RequestFitur model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		if (Yii::$app->user->isGuest) {
            header("Location: index.php");
            exit();
        }
		
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_request_fitur]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RequestFitur model.
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
     * Finds the RequestFitur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RequestFitur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequestFitur::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
