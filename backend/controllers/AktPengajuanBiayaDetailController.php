<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPengajuanBiayaDetail;
use backend\models\AktPengajuanBiayaDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktPengajuanBiaya;
use yii\helpers\ArrayHelper;
use backend\models\AktAkun;
use backend\models\AktKasBank;
use backend\models\AktHistoryTransaksi;

/**
 * AktPengajuanBiayaDetailController implements the CRUD actions for AktPengajuanBiayaDetail model.
 */
class AktPengajuanBiayaDetailController extends Controller
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
     * Lists all AktPengajuanBiayaDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPengajuanBiayaDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPengajuanBiayaDetail model.
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
     * Creates a new AktPengajuanBiayaDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPengajuanBiayaDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pengajuan_biaya_detail]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPengajuanBiayaDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateFromPengajuanBiaya($id)
    {
        $model = $this->findModel($id);

        $pengajuan_biaya = AktPengajuanBiaya::findOne($model->id_pengajuan_biaya);

        $data_akun = ArrayHelper::map(
            AktAkun::find()
                ->orderBy("nama_akun")
                ->all(),
            'id_akun',
            function ($model) {
                return $model['kode_akun'] . ' - ' . $model['nama_akun'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Berhasil Di Simpan Ke Data List Pengajuan']]);
            return $this->redirect(['akt-pengajuan-biaya/view', 'id' => $model->id_pengajuan_biaya]);
        }

        return $this->render('update', [
            'model' => $model,
            'pengajuan_biaya' => $pengajuan_biaya,
            'data_akun' => $data_akun,
        ]);
    }

    /**
     * Deletes an existing AktPengajuanBiayaDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteFromPengajuanBiaya($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktPengajuanBiayaDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPengajuanBiayaDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPengajuanBiayaDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreateFromPengajuanBiaya()
    {
        #get data
        $model_id_pengajuan_biaya = Yii::$app->request->post('AktPengajuanBiayaDetail')['id_pengajuan_biaya'];
        $model_id_akun = Yii::$app->request->post('AktPengajuanBiayaDetail')['id_akun'];
        $model_kode_rekening = Yii::$app->request->post('AktPengajuanBiayaDetail')['kode_rekening'];
        $model_nama_pengajuan = Yii::$app->request->post('AktPengajuanBiayaDetail')['nama_pengajuan'];
        $model_debit = Yii::$app->request->post('AktPengajuanBiayaDetail')['debit'];
        $model_kredit = Yii::$app->request->post('AktPengajuanBiayaDetail')['kredit'];

        $post_kas_bank = Yii::$app->request->post('detail-kas');
        if($post_kas_bank != null ) {
            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_kas_bank';
            $history_transaksi->id_tabel = $post_kas_bank;
            $history_transaksi->id_jurnal_umum = 0;
            $history_transaksi->save(false);
        }

        $model = new AktPengajuanBiayaDetail();
        $model->id_pengajuan_biaya = $model_id_pengajuan_biaya;
        $model->id_akun = $model_id_akun;
        $model->kode_rekening = $model_kode_rekening;
        $model->nama_pengajuan = $model_nama_pengajuan;
        $model->debit = $model_debit;
        $model->kredit = $model_kredit;
        $model->save();

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Ditambahkan Ke Data List Pengajuan']]);
        return $this->redirect(['akt-pengajuan-biaya/view', 'id' => $model->id_pengajuan_biaya]);
    }
}
