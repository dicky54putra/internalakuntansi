<?php

namespace backend\controllers;

use Yii;
use backend\models\AktGudang;
use backend\models\AktGudangSearch;
use Error;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * AktGudangController implements the CRUD actions for AktGudang model.
 */
class AktGudangController extends Controller
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
     * Lists all AktGudang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktGudangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktGudang model.
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
     * Creates a new AktGudang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktGudang();

        $total = AktGudang::find()->count();
        $nomor = 'GD' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_gudang]);
        }
        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Updates an existing AktGudang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->kode_gudang;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_gudang]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Deletes an existing AktGudang model.
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
        $columnName = 'id_gudang';
        $thisTable = 'akt_gudang';
        $thisId = $model->id_gudang;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Gudang : <b>' . $model->nama_gudang . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktGudang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktGudang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktGudang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetGudang($sort)
    {
        $data = AktGudang::find()->orderBy([
            'id_gudang' => $sort == 1 ? SORT_DESC : SORT_ASC
        ])->all();
        echo Json::encode($data);
    }

    public function actionGetKodeGudang()
    {
        $total_gudang = AktGudang::find()->count();
        $nomor_gudang = 'GD' . str_pad($total_gudang + 1, 3, "0", STR_PAD_LEFT);

        echo Json::encode($nomor_gudang);
    }
    public function actionCreateGudang()
    {
        $model = new AktGudang();
        $params = Yii::$app->getRequest()->getBodyParams();

        Yii::trace(print_r($params, true), __METHOD__);
        $model->load($params, '');

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            echo Json::encode('Data Gudang Berhasil Ditambahkan');
        } else {
            Yii::error($model->getErrors(), __METHOD__);
            throw new Error("Something wen't wrong");
        }
    }
}
