<?php

namespace backend\controllers;

use Yii;
use backend\models\AktItemStok;
use backend\models\AktItemStokSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AktGudang;

/**
 * AktItemStokController implements the CRUD actions for AktItemStok model.
 */
class AktItemStokController extends Controller
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
     * Lists all AktItemStok models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktItemStokSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktItemStok model.
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
     * Creates a new AktItemStok model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktItemStok();
        $model->id_item = $_GET['id'];
        $model->qty = 0;
        $model->hpp = 0;
        $model->min = 0;


        $model_gudang = new AktGudang();
        $data_gudang = AktItemStok::getKodeGudang($model_gudang);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_gudang' => $data_gudang,
            'model_gudang' => $model_gudang,
        ]);
    }

    /**
     * Updates an existing AktItemStok model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model_gudang = new AktGudang();
        $data_gudang = AktItemStok::getKodeGudang($model_gudang);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_gudang' => $data_gudang,
            'model_gudang' => $model_gudang,
        ]);
    }

    /**
     * Deletes an existing AktItemStok model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model_gudang = AktGudang::findOne($model->id_gudang);

        $db = Yii::$app->getDb();
        $dbname = 'dbname';
        $dsn = $db->dsn;
        $dbName = getDsnAttribute($dbname, $dsn);
        $columnName = 'id_item_stok';
        $thisTable = 'akt_item_stok';
        $thisId = $model->id_item_stok;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Stok Gudang : <b>' . $model_gudang->nama_gudang . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['akt-item/view', 'id' => $model->id_item]);
    }

    /**
     * Finds the AktItemStok model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktItemStok the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktItemStok::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
