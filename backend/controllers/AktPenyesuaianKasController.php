<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenyesuaianKas;
use backend\models\AktPenyesuaianKasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKasBank;
use backend\models\AktHistoryTransaksi;
use yii\helpers\ArrayHelper;
use yii\helpers\Utils;

/**
 * AktPenyesuaianKasController implements the CRUD actions for AktPenyesuaianKas model.
 */
class AktPenyesuaianKasController extends Controller
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
     * Lists all AktPenyesuaianKas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenyesuaianKasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenyesuaianKas model.
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
     * Creates a new AktPenyesuaianKas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenyesuaianKas();

        $no_transaksi = Utils::getNomorTransaksi($model, 'PK', 'no_transaksi', 'id_penyesuaian_kas');

        $model->no_transaksi = $no_transaksi;

        $model->tanggal = date('Y-m-d');
        $model->id_mata_uang = 1;

        $model_akun = new AktAkun();

        $data_akun = ArrayHelper::map(AktAkun::find()->where(['id_akun'  => 134])->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });


        if ($model->load(Yii::$app->request->post())) {

            $model->save(false);
            AktPenyesuaianKas::createJurnalUmum($model, $no_transaksi);
            return $this->redirect(['view', 'id' => $model->id_penyesuaian_kas]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_akun' => $data_akun
        ]);
    }

    /**
     * Updates an existing AktPenyesuaianKas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model_sebelumnya = $this->findModel($id);
        $model = $this->findModel($id);
        $nomor = $model->no_transaksi;
        $model_akun = new AktAkun();

        $data_akun = ArrayHelper::map(AktAkun::find()->where(['id_akun'  => 134])->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });

        if ($model->load(Yii::$app->request->post())) {

            AktPenyesuaianKas::deleteJurnalUmum($model_sebelumnya, $id);

            $model->save(false);
            AktPenyesuaianKas::createJurnalUmum($model, $model->no_transaksi);


            return $this->redirect(['view', 'id' => $model->id_penyesuaian_kas]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'data_akun' => $data_akun
        ]);
    }

    /**
     * Deletes an existing AktPenyesuaianKas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);
        AktPenyesuaianKas::deleteJurnalUmum($model, $id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktPenyesuaianKas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenyesuaianKas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenyesuaianKas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
