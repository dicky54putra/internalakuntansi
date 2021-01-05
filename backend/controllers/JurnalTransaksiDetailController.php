<?php

namespace backend\controllers;

use Yii;
use backend\models\JurnalTransaksiDetail;
use backend\models\JurnalTransaksiDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktAkun;

/**
 * JurnalTransaksiDetailController implements the CRUD actions for JurnalTransaksiDetail model.
 */
class JurnalTransaksiDetailController extends Controller
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
     * Lists all JurnalTransaksiDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JurnalTransaksiDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JurnalTransaksiDetail model.
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
     * Creates a new JurnalTransaksiDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JurnalTransaksiDetail();
        $id_jurnal_transaksi = $_GET['id'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['jurnal-transaksi/view', 'id' => $model->id_jurnal_transaksi]);
        }

        return $this->render('create', [
            'model' => $model,
            'id_jurnal_transaksi' => $id_jurnal_transaksi
        ]);
    }

    /**
     * Updates an existing JurnalTransaksiDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $id_jurnal_transaksi = $model->id_jurnal_transaksi;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['jurnal-transaksi/view', 'id' => $id_jurnal_transaksi]);
        }

        return $this->render('update', [
            'model' => $model,
            'id_jurnal_transaksi' => $id_jurnal_transaksi
        ]);
    }

    /**
     * Deletes an existing JurnalTransaksiDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model_akun = AktAkun::findOne($model->id_akun);

        $db = Yii::$app->getDb();
        $dbname = 'dbname';
        $dsn = $db->dsn;
        $dbName = getDsnAttribute($dbname, $dsn);
        $columnName = 'id_jurnal_transaksi_detail';
        $thisTable = 'jurnal_transaksi_detail';
        $thisId = $model->id_jurnal_transaksi_detail;
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
            // $model->delete();
        } else {
            # code...
            Yii::$app->session->setFlash('warning', [['Perhatian!', '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Data Akun : <b>' . $model_akun->nama_akun . '</b> Tidak Dapat Di Hapus, Dikarenakan Data Masih Digunakan!']]);
        }

        return $this->redirect(['jurnal-transaksi/view', 'id' => $model->id_jurnal_transaksi]);
    }

    /**
     * Finds the JurnalTransaksiDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JurnalTransaksiDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JurnalTransaksiDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
