<?php

namespace backend\controllers;

use Yii;
use backend\models\AktItem;
use backend\models\AktItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktMerk;
use backend\models\AktItemTipe;
use backend\models\AktMitraBisnis;
use backend\models\AktSatuan;

/**
 * AktItemController implements the CRUD actions for AktItem model.
 */
class AktItemController extends Controller
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
     * Lists all AktItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktItem model.
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
     * Creates a new AktItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktItem();
        # code
        $total = AktItem::find()->count();
        $nomor = 'AI' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $model_tipe = new AktItemTipe();
        $model_merk = new AktMerk();

        $total_merk = AktMerk::find()->count();
        $nomor_merk = 'MI' . str_pad($total_merk + 1, 3, "0", STR_PAD_LEFT);

        $model_satuan = new AktSatuan();

        $model_mitra_bisnis = new AktMitraBisnis();
        $total_mitra_bisnis = AktMitraBisnis::find()->count();
        $nomor_mitra_bisnis = 'MB' . str_pad($total_mitra_bisnis + 1, 3, "0", STR_PAD_LEFT);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_item]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
            'model_merk' => $model_merk,
            'nomor_merk' => $nomor_merk,
            'model_tipe' => $model_tipe,
            'model_satuan' => $model_satuan,
            'model_mitra_bisnis' => $model_mitra_bisnis,
            'nomor_mitra_bisnis' => $nomor_mitra_bisnis
        ]);
    }

    /**
     * Updates an existing AktItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nomor = $model->kode_item;

        $model_tipe = new AktItemTipe();

        $model_merk = new AktMerk();

        $total_merk = AktMerk::find()->count();
        $nomor_merk = 'MI' . str_pad($total_merk + 1, 3, "0", STR_PAD_LEFT);

        $model_satuan = new AktSatuan();

        $model_mitra_bisnis = new AktMitraBisnis();
        $total_mitra_bisnis = AktMitraBisnis::find()->count();
        $nomor_mitra_bisnis = 'MB' . str_pad($total_mitra_bisnis + 1, 3, "0", STR_PAD_LEFT);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_item]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'model_merk' => $model_merk,
            'nomor_merk' => $nomor_merk,
            'model_tipe' => $model_tipe,
            'model_satuan' => $model_satuan,
            'model_mitra_bisnis' => $model_mitra_bisnis,
            'nomor_mitra_bisnis' => $nomor_mitra_bisnis
        ]);
    }

    /**
     * Deletes an existing AktItem model.
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
        $columnName = 'id_item';
        $thisTable = 'akt_item';
        $thisId = $model->id_item;
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
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Barang : <b>' . $model->nama_item . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
