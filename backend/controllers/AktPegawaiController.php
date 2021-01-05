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
        $data_kota = AktPegawai::getArrayKota($model_kota);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pegawai]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
            'data_kota' => $data_kota,
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
        $data_kota = AktPegawai::getArrayKota($model_kota);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pegawai]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'data_kota' => $data_kota,
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
        $model = $this->findModel($id);

        $db = Yii::$app->getDb();
        $dbname = 'dbname';
        $dsn = $db->dsn;
        $dbName = getDsnAttribute($dbname, $dsn);
        $columnName = 'id_pegawai';
        $thisTable = 'akt_pegawai';
        $thisId = $model->id_pegawai;
        $rows = (new \yii\db\Query())
            ->select(['TABLE_NAME'])
            ->from('INFORMATION_SCHEMA.COLUMNS')
            ->where(['TABLE_SCHEMA' => $dbName])
            ->andWhere(['COLUMN_NAME' => $columnName])
            ->andWhere(['!=', 'TABLE_NAME', $thisTable])
            ->all();
        $array_table_name = array();
        $totalan_countData = 0;
        foreach ($rows as $key => $value) {
            # code...
            $rows2 = (new \yii\db\Query())
                ->select(['COUNT(*) as countData'])
                ->from($value['TABLE_NAME'])
                ->where([$columnName => $thisId])
                ->one();
            $array_table_name[] = $value['TABLE_NAME'] . ' - ' . $rows2['countData'];
            $totalan_countData += $rows2['countData'];
        }

        if ($totalan_countData == 0) {
            # code...
            $model->delete();
        } else {
            # code...
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Pegawai : <b>' . $model->nama_pegawai . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

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
