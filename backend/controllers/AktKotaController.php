<?php

namespace backend\controllers;

use Yii;
use backend\models\AktKota;
use backend\models\AktKotaSearch;
use Error;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * AktKotaController implements the CRUD actions for AktKota model.
 */
class AktKotaController extends Controller
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
     * Lists all AktKota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktKotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktKota model.
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
     * Creates a new AktKota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktKota();

        $total = AktKota::find()->count();
        $nomor = "KT" . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post())) {

            $model->save();
            return $this->redirect(['view', 'id' => $model->id_kota]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Updates an existing AktKota model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->kode_kota;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_kota]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Deletes an existing AktKota model.
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
        $columnName = 'id_kota';
        $thisTable = 'akt_kota';
        $thisId = $model->id_kota;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Kota : <b>' . $model->nama_kota . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktKota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktKota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktKota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetKota($sort)
    {
        $data = AktKota::find()->orderBy([
            'id_kota' => $sort == 1 ? SORT_DESC : SORT_ASC
        ])->all();
        echo Json::encode($data);
    }

    public function actionGetKodeKota()
    {
        $total_kota = AktKota::find()->count();
        $nomor_kota = 'KT' . str_pad($total_kota + 1, 3, "0", STR_PAD_LEFT);

        echo Json::encode($nomor_kota);
    }
    public function actionCreateKota()
    {
        $model = new AktKota();
        $params = Yii::$app->getRequest()->getBodyParams();

        Yii::trace(print_r($params, true), __METHOD__);
        $model->load($params, '');

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            echo Json::encode('Data Kota Berhasil Ditambahkan');
        } else {
            Yii::error($model->getErrors(), __METHOD__);
            throw new Error("Something wen't wrong");
        }
    }
}
