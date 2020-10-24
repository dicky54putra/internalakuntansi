<?php

namespace backend\controllers;

use Yii;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktMitraBisnisAlamatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktKota;

/**
 * AktMitraBisnisAlamatController implements the CRUD actions for AktMitraBisnisAlamat model.
 */
class AktMitraBisnisAlamatController extends Controller
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
     * Lists all AktMitraBisnisAlamat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktMitraBisnisAlamatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktMitraBisnisAlamat model.
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
     * Creates a new AktMitraBisnisAlamat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktMitraBisnisAlamat();
        $model->id_mitra_bisnis = $_GET['id'];

        $model_kota = new AktKota();

        $total_kota = AktKota::find()->count();
        $nomor_kota = "KT" . str_pad($total_kota + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis, '#' => 'alamat']);
        }

        return $this->render('create', [
            'model' => $model,
            'model_kota' => $model_kota,
            'nomor_kota' => $nomor_kota
        ]);
    }

    /**
     * Updates an existing AktMitraBisnisAlamat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_kota = new AktKota();

        $total_kota = AktKota::find()->count();
        $nomor_kota = "KT" . str_pad($total_kota + 1, 3, "0", STR_PAD_LEFT);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis, '#' => 'alamat']);
        }

        return $this->render('update', [
            'model' => $model,
            'model_kota' => $model_kota,
            'nomor_kota' => $nomor_kota
        ]);
    }

    /**
     * Deletes an existing AktMitraBisnisAlamat model.
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
        $columnName = 'id_mitra_bisnis_alamat';
        $thisTable = 'akt_mitra_bisnis_alamat';
        $thisId = $model->id_mitra_bisnis_alamat;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Alamat : <b>' . $model->keterangan_alamat . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis, '#' => 'alamat']);
    }

    /**
     * Finds the AktMitraBisnisAlamat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktMitraBisnisAlamat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktMitraBisnisAlamat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
