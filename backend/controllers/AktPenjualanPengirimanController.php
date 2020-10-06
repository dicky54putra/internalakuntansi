<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualanPengiriman;
use backend\models\AktPenjualanPengirimanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktPenjualan;
use yii\helpers\ArrayHelper;
use backend\models\AktPenjualanPengirimanDetail;
use yii\web\UploadedFile;
use backend\models\Setting;

/**
 * AktPenjualanPengirimanController implements the CRUD actions for AktPenjualanPengiriman model.
 */
class AktPenjualanPengirimanController extends Controller
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
     * Lists all AktPenjualanPengiriman models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenjualanPengirimanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenjualanPengiriman model.
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
     * Creates a new AktPenjualanPengiriman model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenjualanPengiriman();
        $model_penjualan = AktPenjualan::findOne($_GET['id']);

        $model_mitra_bisnis_alamat = new AktMitraBisnisAlamat();

        $akt_penjualan_pengiriman = AktPenjualanPengiriman::find()->select(["no_pengiriman"])->orderBy("id_penjualan_pengiriman DESC")->limit(1)->one();
        if (!empty($akt_penjualan_pengiriman->no_pengiriman)) {
            # code...
            $no_bulan = substr($akt_penjualan_pengiriman->no_pengiriman, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_penjualan_pengiriman->no_pengiriman, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_pengiriman = 'PG' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_pengiriman = 'PG' . date('ym') . '001';
            }
        } else {
            # code...
            $no_pengiriman = 'PG' . date('ym') . '001';
        }

        $model->no_pengiriman = $no_pengiriman;
        $model->tanggal_pengiriman = date('Y-m-d');
        $model->id_penjualan = $model_penjualan->id_penjualan;

        if ($model->load(Yii::$app->request->post())) {

            $model->foto_resi = UploadedFile::getInstance($model, 'foto_resi');
            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_pengiriman . ' Berhasil di Tambahkan']]);

            return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $model->id_penjualan, '#' => 'data-pengiriman']);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'model_penjualan' => $model_penjualan,
            'model_mitra_bisnis_alamat' => $model_mitra_bisnis_alamat,
        ]);
    }

    /**
     * Updates an existing AktPenjualanPengiriman model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_penjualan = AktPenjualan::findOne($model->id_penjualan);

        if ($model->load(Yii::$app->request->post())) {

            $model->foto_resi = UploadedFile::getInstance($model, 'foto_resi');
            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_pengiriman . ' Berhasil di Ubahkan']]);

            return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $model->id_penjualan, '#' => 'data-pengiriman']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'model_penjualan' => $model_penjualan,
        ]);
    }

    /**
     * Deletes an existing AktPenjualanPengiriman model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $cek_detail = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_pengiriman' => $model->id_penjualan_pengiriman])->count();

        if ($cek_detail == 0) {
            # code...
            $model->delete();

            AktPenjualanPengirimanDetail::deleteAll(["id_penjualan_pengiriman" => $model->id_penjualan_pengiriman]);

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_pengiriman . ' Berhasil di Hapus']]);
        } else {
            # code...
            Yii::$app->session->setFlash('danger', [['Perhatian !', 'Belum Dapat Menghapus ' . $model->no_pengiriman . ' Karena Masih Terdapat Data Barang Pengirimannya, Silahkan Hapus Terlebih Dahulu Data Barang Pengiriman']]);
        }

        return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $model->id_penjualan, '#' => 'data-pengiriman']);
    }

    /**
     * Finds the AktPenjualanPengiriman model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenjualanPengiriman the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenjualanPengiriman::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTambahDataAlamatPengiriman()
    {
        $id = Yii::$app->request->get('id');
        $model = AktPenjualan::findOne($id);

        $model_alamat_customer = new AktMitraBisnisAlamat();

        if ($model_alamat_customer->load(Yii::$app->request->post())) {
            # code...
            $model_alamat_customer->id_mitra_bisnis = $model->id_customer;
            $model_alamat_customer->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Alamat Berhasil di Tambahkan']]);
        }

        return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $model->id_penjualan, '#' => 'data-pengiriman']);
    }

    public function actionTerkirim($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_penerimaan = date('Y-m-d');
        $model_sebelumnya = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->foto_resi = UploadedFile::getInstance($model, 'foto_resi');
            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_pengiriman . ' Berhasil Diterma Oleh ' . $model->penerima . '']]);

            return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $model->id_penjualan, '#' => 'data-pengiriman']);
        }

        return $this->renderAjax('terkirim', [
            'model' => $model,
        ]);
    }

    public function actionCetakSuratPengantar($id)
    {
        $model = $this->findModel($id);
        $model_penjualan = AktPenjualan::findOne($model->id_penjualan);
        $data_setting = Setting::find()->one();

        return $this->renderPartial('cetak_surat_pengantar', [
            'model' => $model,
            'model_penjualan' => $model_penjualan,
            'data_setting' => $data_setting,
        ]);
    }

    public function actionCetakLabelBarang($id)
    {
        $model = $this->findModel($id);
        $model_penjualan = AktPenjualan::findOne($model->id_penjualan);
        $data_setting = Setting::find()->one();

        return $this->renderPartial('cetak_label_barang', [
            'model' => $model,
            'model_penjualan' => $model_penjualan,
            'data_setting' => $data_setting,
        ]);
    }
}
