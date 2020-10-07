<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPermintaanBarangPegawai;
use backend\models\AktPermintaanBarangPegawaiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktPegawai;
use yii\helpers\ArrayHelper;

/**
 * AktPermintaanBarangPegawaiController implements the CRUD actions for AktPermintaanBarangPegawai model.
 */
class AktPermintaanBarangPegawaiController extends Controller
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
     * Lists all AktPermintaanBarangPegawai models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPermintaanBarangPegawaiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPermintaanBarangPegawai model.
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
     * Creates a new AktPermintaanBarangPegawai model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPermintaanBarangPegawai();
        $model->id_permintaan_barang = $_GET['id'];

        $data_pegawai = ArrayHelper::map(AktPegawai::find()->all(), 'id_pegawai','nama_pegawai');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_pegawai' => $data_pegawai,
        ]);
    }

    /**
     * Updates an existing AktPermintaanBarangPegawai model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data_pegawai = ArrayHelper::map(AktPegawai::find()->all(), 'id_pegawai','nama_pegawai');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_pegawai' => $data_pegawai,
        ]);
    }

    /**
     * Deletes an existing AktPermintaanBarangPegawai model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]);
    }

    /**
     * Finds the AktPermintaanBarangPegawai model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPermintaanBarangPegawai the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPermintaanBarangPegawai::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
