<?php

namespace backend\controllers;

use backend\models\AktKota;
use Yii;
use backend\models\AktPegawai;
use backend\models\AktPegawaiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AktPegawaiController implements the CRUD actions for AktPegawai model.
 */
class AktPegawaiController extends Controller
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
     * Lists all AktPegawai models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPegawaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPegawai model.
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
     * Creates a new AktPegawai model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPegawai();

        $total = AktPegawai::find()->count();
        $nomor = 'PG' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $model_kota = new AktKota();
        $total_kota = AktKota::find()->count();
        $nomor_kota = "KT" . str_pad($total_kota + 1, 3, "0", STR_PAD_LEFT);
        $data_kota =  ArrayHelper::map(AktKota::find()->all(), 'id_kota', 'nama_kota');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pegawai]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
            'data_kota' => $data_kota,
            'nomor_kota' => $nomor_kota,
            'model_kota' => $model_kota 
        ]);
    }

    /**
     * Updates an existing AktPegawai model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->kode_pegawai;
        $model_kota = new AktKota();
        $total_kota = AktKota::find()->count();
        $nomor_kota = "KT" . str_pad($total_kota + 1, 3, "0", STR_PAD_LEFT);
        $data_kota =  ArrayHelper::map(AktKota::find()->all(), 'id_kota', 'nama_kota');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pegawai]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'data_kota' => $data_kota,
            'nomor_kota' => $nomor_kota,
            'model_kota' => $model_kota 
        ]);
    }

    /**
     * Deletes an existing AktPegawai model.
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
     * Finds the AktPegawai model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPegawai the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPegawai::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
