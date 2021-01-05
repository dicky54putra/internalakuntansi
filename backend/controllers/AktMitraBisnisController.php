<?php

namespace backend\controllers;


use Yii;
use backend\models\AktMitraBisnis;
use backend\models\AktMitraBisnisSearch;
use Error;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * AktMitraBisnisController implements the CRUD actions for AktMitraBisnis model.
 */
class AktMitraBisnisController extends Controller
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
     * Lists all AktMitraBisnis models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktMitraBisnisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktMitraBisnis model.
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
     * Creates a new AktMitraBisnis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktMitraBisnis();
        $total = AktMitraBisnis::find()->count();
        $nomor = 'MB' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $model->id_level_harga = 0;
        $model->id_sales = 0;



        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_mitra_bisnis]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,

        ]);
    }

    /**
     * Updates an existing AktMitraBisnis model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nomor = $model->kode_mitra_bisnis;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_mitra_bisnis]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor
        ]);
    }

    /**
     * Deletes an existing AktMitraBisnis model.
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
        $columnName = 'id_mitra_bisnis';
        $thisTable = 'akt_mitra_bisnis';
        $thisId = $model->id_mitra_bisnis;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Mitra Bisnis : <b>' . $model->nama_mitra_bisnis . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktMitraBisnis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktMitraBisnis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktMitraBisnis::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetMitraBisnis($sort)
    {
        $data = AktMitraBisnis::find()->select(['id_mitra_bisnis', 'kode_mitra_bisnis', 'nama_mitra_bisnis'])->orderBy([
            'id_mitra_bisnis' => $sort == 1 ? SORT_DESC : SORT_ASC
        ])->all();
        echo Json::encode($data);
    }

    public function actionGetKodeMitraBisnis()
    {
        $total_mitra_bisnis = AktMitraBisnis::find()->count();
        $nomor_mitra_bisnis = 'MB' . str_pad($total_mitra_bisnis + 1, 3, "0", STR_PAD_LEFT);

        echo Json::encode($nomor_mitra_bisnis);
    }
    public function actionCreateMitraBisnis()
    {
        $model = new AktMitraBisnis();
        $params = Yii::$app->getRequest()->getBodyParams();
        Yii::trace(print_r($params, true), __METHOD__);
        $model->load($params, '');

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            echo Json::encode('Data Mitra Bisnis Berhasil Ditambahkan');
        } else {
            Yii::error($model->getErrors(), __METHOD__);
            throw new Error("Something wen't wrong");
        }
    }
}
