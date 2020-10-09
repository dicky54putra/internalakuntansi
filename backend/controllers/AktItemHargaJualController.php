<?php

namespace backend\controllers;

use Yii;
use backend\models\AktItemHargaJual;
use backend\models\AktItemHargaJualSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AktLevelHarga;
use backend\models\AktMataUang;

/**
 * AktItemHargaJualController implements the CRUD actions for AktItemHargaJual model.
 */
class AktItemHargaJualController extends Controller
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
     * Lists all AktItemHargaJual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktItemHargaJualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktItemHargaJual model.
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
     * Creates a new AktItemHargaJual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktItemHargaJual();
        $id_item = $model->id_item = $_GET['id'];
        // $model->id_item = $_GET['id'];
        $model->harga_satuan = 0;


        $model->id_mata_uang = 1;

        $data_mata_uang = ArrayHelper::map(AktMataUang::find()->all(), 'id_mata_uang', 'mata_uang');
        $data_level_harga = ArrayHelper::map(AktLevelHarga::find()->all(), 'id_level_harga', 'keterangan');

        $model_level_harga = new AktLevelHarga();
        $total_level_harga = AktLevelHarga::find()->count();
        $nomor_level_harga = 'LH' . str_pad($total_level_harga + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item, '#' => 'harga-jual']);
        }

        return $this->render('create', [
            'model' => $model,
            'id_item' => $id_item,
            'data_mata_uang' => $data_mata_uang,
            'data_level_harga' => $data_level_harga,
            'nomor_level_harga' => $nomor_level_harga,
            'model_level_harga' => $model_level_harga
        ]);
    }

    /**
     * Updates an existing AktItemHargaJual model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $id_item = $model->id_item;
        $data_mata_uang = ArrayHelper::map(AktMataUang::find()->all(), 'id_mata_uang', 'mata_uang');
        $data_level_harga = ArrayHelper::map(AktLevelHarga::find()->all(), 'id_level_harga', 'keterangan');

        $model_level_harga = new AktLevelHarga();
        $total_level_harga = AktLevelHarga::find()->count();
        $nomor_level_harga = 'LH' . str_pad($total_level_harga + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-item/view', 'id' => $model->id_item, '#' => 'harga-jual']);
        }

        return $this->render('update', [
            'model' => $model,
            'data_mata_uang' => $data_mata_uang,
            'data_level_harga' => $data_level_harga,
            'nomor_level_harga' => $nomor_level_harga,
            'model_level_harga' => $model_level_harga,
            'id_item' => $id_item,
        ]);
    }

    /**
     * Deletes an existing AktItemHargaJual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model_level_harga = AktLevelHarga::findOne($model->id_level_harga);

        $db = Yii::$app->getDb();
        $dbname = 'dbname';
        $dsn = $db->dsn;
        $dbName = getDsnAttribute($dbname, $dsn);
        $columnName = 'id_item_harga_jual';
        $thisTable = 'akt_item_harga_jual';
        $thisId = $model->id_item_harga_jual;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data : ' . $model_level_harga->keterangan . ' Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['akt-item/view', 'id' => $model->id_item, '#' => 'harga-jual']);
    }

    /**
     * Finds the AktItemHargaJual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktItemHargaJual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktItemHargaJual::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
