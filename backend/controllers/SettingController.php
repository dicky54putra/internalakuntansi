<?php

namespace backend\controllers;

use backend\models\AktKota;
use Yii;
use backend\models\Setting;
use backend\models\SettingSearch;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Arrayhelper;
use backend\models\AktPenjualan;
use yii\helpers\Json;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
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
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Setting model.
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
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();

        $data_kota = ArrayHelper::map(AktKota::find()->all(), 'id_sales', 'nama_kota');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_setting]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_kota' => $data_kota,
        ]);
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data_kota = ArrayHelper::map(AktKota::find()->all(), 'id_kota', 'nama_kota');

        if ($model->load(Yii::$app->request->post())) {
            $model->foto = UploadedFile::getInstance($model, 'foto');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_setting]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_kota' => $data_kota,
        ]);
    }



    /**
     * Deletes an existing Setting model.
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
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetDataPerHari($select, $tabel)
    {

        $tanggal = Setting::getTanggal($select, $tabel);
        $data = array();

        foreach ($tanggal as $t) {

            $data_count = Yii::$app->db->createCommand("SELECT COUNT($select) as penjualan FROM $tabel WHERE $select = '$t[$select]' AND status >= 3")->query();

            foreach ($data_count as $g) {
                array_push($data, $g['penjualan']);
            }
        }

        echo Json::encode($data);
    }

    public function actionGetDataPerBulan($select, $tabel, $type)
    {
        if ($type == 1) { // Tahun Ini 
            $year = date('Y');
        } else if ($type == 0) { // Tahun Sebelumnya
            $year = date('Y') - 1;
        }

        $bulan = AktPenjualan::getBulan();
        $data = array();
        foreach ($bulan as $b) {

            $data_count = Yii::$app->db->createCommand("SELECT COUNT($select) as penjualan FROM $tabel WHERE MONTH($select) = '$b' AND YEAR($select) = '$year' AND status >= 3")->query();
            foreach ($data_count as $g) {
                array_push($data, $g['penjualan']);
            }
        }

        echo Json::encode($data);
    }

    public function actionGetDataPerBulanRupiah($select, $tabel, $type)
    {
        if ($type == 1) { // Tahun Ini 
            $year = date('Y');
        } else if ($type == 0) { // Tahun Sebelumnya
            $year = date('Y') - 1;
        }

        $bulan = AktPenjualan::getBulan();
        $data = array();
        foreach ($bulan as $b) {
            $data_count = Yii::$app->db->createCommand("SELECT SUM(total) as penjualan FROM $tabel WHERE MONTH($select) = '$b' AND YEAR($select) = '$year' AND status >= 3")->query();

            foreach ($data_count as $g) {
                array_push($data, $g['penjualan']);
            }
        }

        echo Json::encode($data);
    }
}
