<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualanHartaTetap;
use backend\models\AktPenjualanHartaTetapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AktMataUang;
use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktPenjualanHartaTetapDetail;
use backend\models\AktPembelianHartaTetapDetail;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktItemStok;
use backend\models\AktKasBank;

/**
 * AktPenjualanHartaTetapController implements the CRUD actions for AktPenjualanHartaTetap model.
 */
class AktPenjualanHartaTetapController extends Controller
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
     * Lists all AktPenjualanHartaTetap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenjualanHartaTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenjualanHartaTetap model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->ongkir = ($model->ongkir == NULL) ? 0 : $model->ongkir;
        $model->diskon = ($model->diskon == NULL) ? 0 : $model->diskon;
        $model->materai = ($model->materai == NULL) ? 0 : $model->materai;
        $model->uang_muka = ($model->uang_muka == NULL) ? 0 : $model->uang_muka;

        #pengecekan
        $count_detail = AktPenjualanHartaTetapDetail::find()->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap])->count();
        $cek_detail = ($count_detail > 0) ? 0 : 1;
        $cek_update_jenis_bayar = ($model->jenis_bayar == 1) ? 0 : $retVal = ($model->jenis_bayar == 2 && $model->jumlah_tempo != NULL) ? 0 : 1;
        $cek_update_kas_bank = ($model->id_kas_bank == NULL) ? 1 : 0;
        $total_cek = $cek_update_jenis_bayar + $cek_update_kas_bank + $cek_detail;

        #model untuk penjualan harta tetap detail
        $model_penjualan_harta_tetap_detail_baru = new AktPenjualanHartaTetapDetail();
        $model_penjualan_harta_tetap_detail_baru->id_penjualan_harta_tetap = $model->id_penjualan_harta_tetap;
        $model_penjualan_harta_tetap_detail_baru->qty = 1;
        $model_penjualan_harta_tetap_detail_baru->diskon = 0;

        #barang yang sudah di input ke penjualan harta tetap detail
        $query_penjualan_harta_tetap_detail = AktPenjualanHartaTetapDetail::find()->all();
        $array_id_pembelian_harta_tetap_detail = array();
        foreach ($query_penjualan_harta_tetap_detail as $key => $value) {
            # code...
            $array_id_pembelian_harta_tetap_detail[] = $value['id_pembelian_harta_tetap_detail'];
        }
        $hasil_array_id_pembelian_harta_tetap_detail_ = implode(', ', $array_id_pembelian_harta_tetap_detail);
        $hasil_array_id_pembelian_harta_tetap_detail = explode(', ', $hasil_array_id_pembelian_harta_tetap_detail_);

        #data pembelian harta tetap detail
        $data_pembelian_harta_tetap_detail = ArrayHelper::map(
            AktPembelianHartaTetapDetail::find()
                ->leftJoin("akt_pembelian_harta_tetap", "akt_pembelian_harta_tetap.id_pembelian_harta_tetap = akt_pembelian_harta_tetap_detail.id_pembelian_harta_tetap")
                ->where(['akt_pembelian_harta_tetap_detail.status' => 1])
                ->andWhere(['NOT IN', 'id_pembelian_harta_tetap_detail', $hasil_array_id_pembelian_harta_tetap_detail])
                ->andWhere(['akt_pembelian_harta_tetap.status' => 2])
                ->all(),
            'id_pembelian_harta_tetap_detail',
            function ($model) {
                return 'Kode Pembelian : ' . $model['kode_pembelian'] . ', Nama Barang : ' . $model['nama_barang'];
            }
        );

        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
            }
        );

        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 2])
                ->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
            }
        );

        $data_sales = ArrayHelper::map(
            AktSales::find()
                ->where(["=", 'status_aktif', 1])
                ->all(),
            'id_sales',
            function ($model) {
                return $model['kode_sales'] . ' - ' . $model['nama_sales'];
            }
        );

        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()
                ->where(["=", 'status_aktif', 1])
                ->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'] . ' : ' . ribuan($model['saldo']);
            }
        );

        $new_customer = new AktMitraBisnis();
        $new_sales = new AktSales();

        # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
        $query = (new \yii\db\Query())->from('akt_penjualan_harta_tetap_detail')->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
        $total_penjualan_harta_tetap_detail = $query->sum('total');

        return $this->render('view', [
            'model' => $model,
            'model_penjualan_harta_tetap_detail_baru' => $model_penjualan_harta_tetap_detail_baru,
            'data_pembelian_harta_tetap_detail' => $data_pembelian_harta_tetap_detail,
            'data_mata_uang' => $data_mata_uang,
            'data_customer' => $data_customer,
            'data_sales' => $data_sales,
            'data_kas_bank' => $data_kas_bank,
            'new_customer' => $new_customer,
            'new_sales' => $new_sales,
            'total_penjualan_harta_tetap_detail' => $total_penjualan_harta_tetap_detail,
            'total_cek' => $total_cek,
        ]);
    }

    /**
     * Creates a new AktPenjualanHartaTetap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenjualanHartaTetap();

        $akt_penjualan_harta_tetap = AktPenjualanHartaTetap::find()->select(["no_penjualan_harta_tetap"])->orderBy("id_penjualan_harta_tetap DESC")->limit(1)->one();
        if (!empty($akt_penjualan_harta_tetap->no_penjualan_harta_tetap)) {
            # code...
            $no_bulan = substr($akt_penjualan_harta_tetap->no_penjualan_harta_tetap, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_penjualan_harta_tetap->no_penjualan_harta_tetap, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_penjualan_harta_tetap = 'PH' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_penjualan_harta_tetap = 'PH' . date('ym') . '001';
            }
        } else {
            # code...
            $no_penjualan_harta_tetap = 'PH' . date('ym') . '001';
        }

        $model->no_penjualan_harta_tetap = $no_penjualan_harta_tetap;
        $model->tanggal_penjualan_harta_tetap = date('Y-m-d');
        $model->id_mata_uang = 1;

        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
            }
        );

        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 2])
                ->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
            }
        );

        $data_sales = ArrayHelper::map(
            AktSales::find()
                ->where(["=", 'status_aktif', 1])
                ->all(),
            'id_sales',
            function ($model) {
                return $model['kode_sales'] . ' - ' . $model['nama_sales'];
            }
        );

        $new_customer = new AktMitraBisnis();
        $new_sales = new AktSales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penjualan_harta_tetap]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_mata_uang' => $data_mata_uang,
            'data_customer' => $data_customer,
            'data_sales' => $data_sales,
            'new_customer' => $new_customer,
            'new_sales' => $new_sales,
        ]);
    }

    public function actionAddNewCustomer()
    {
        $total = AktMitraBisnis::find()->count();
        $kode_mitra_bisnis = 'MB' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $add_new_customer = new AktMitraBisnis();

        if ($add_new_customer->load(Yii::$app->request->post())) {
            # code...
            $add_new_customer->kode_mitra_bisnis = $kode_mitra_bisnis;
            $add_new_customer->status_mitra_bisnis = 1;
            $add_new_customer->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Customer : ' . $add_new_customer->nama_mitra_bisnis . ' Berhasil Ditambahkan']]);
        }

        $id = Yii::$app->request->get('id');

        if (!empty($id)) {
            # code...
            return $this->redirect(['view', 'id' => $id]);
        } else {
            # code...
            return $this->redirect(['create']);
        }
    }

    public function actionAddNewSales()
    {
        $total = AktSales::find()->count();
        $kode_sales = 'SL' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $add_new_sales = new AktSales();

        if ($add_new_sales->load(Yii::$app->request->post())) {
            # code...
            $add_new_sales->kode_sales = $kode_sales;
            $add_new_sales->status_aktif = 1;
            $add_new_sales->id_kota = 0;
            $add_new_sales->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Sales : ' . $add_new_sales->nama_sales . ' Berhasil Ditambahkan']]);
        }


        $id = Yii::$app->request->get('id');

        if (!empty($id)) {
            # code...
            return $this->redirect(['view', 'id' => $id]);
        } else {
            # code...
            return $this->redirect(['create']);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->ongkir = Yii::$app->request->post('AktPenjualanHartaTetap')['ongkir'];
            $model->uang_muka = Yii::$app->request->post('AktPenjualanHartaTetap')['uang_muka'];
            $model->materai = Yii::$app->request->post('AktPenjualanHartaTetap')['materai'];

            $total_penjualan_harta_tetap_detail_post = Yii::$app->request->post('total_penjualan_harta_tetap_detail');
            $total_penjualan_harta_tetap_detail = preg_replace('/\D/', '', $total_penjualan_harta_tetap_detail_post);

            $diskon = ($model->diskon > 0) ? ($model->diskon * $total_penjualan_harta_tetap_detail) / 100 : 0;
            $pajak = ($model->pajak == 1) ? (($total_penjualan_harta_tetap_detail - $diskon) * 10) / 100 : 0;
            $model_total_sementara = (($total_penjualan_harta_tetap_detail - $diskon) + $pajak) + $model->ongkir + $model->materai;
            $model->total = $model_total_sementara - $model->uang_muka;
            if ($model->jenis_bayar == 1) {
                # code...
                $model->jenis_bayar = 1;
                $model->jumlah_tempo = NULL;
                $model->tanggal_tempo = NULL;
            } elseif ($model->jenis_bayar == 2) {
                # code...
                $model->jenis_bayar = 2;
                $model->jumlah_tempo = $model->jumlah_tempo;
                $tanggal_tempo = date('Y-m-d', strtotime('+' . $model->jumlah_tempo . ' days', strtotime($model->tanggal_penjualan_harta_tetap)));
                $model->tanggal_tempo = $tanggal_tempo;
            }

            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Berhasil Di Simpan']]);

            return $this->redirect(['view', 'id' => $model->id_penjualan_harta_tetap]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPenjualanHartaTetap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktPenjualanHartaTetap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenjualanHartaTetap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenjualanHartaTetap::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApproved($id, $id_login)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->the_approver = $id_login;
        $model->the_approver_date = date('Y-m-d H:i:s');

        #pengecekan apakah data pembelian harta tetap ny dari sudah di setujui kemudian di pending
        $data_penjualan_harta_tetap_detail = AktPenjualanHartaTetapDetail::findAll(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
        foreach ($data_penjualan_harta_tetap_detail as $key => $value) {
            # code...
            $data_pembelian_harta_tetap_detail = AktPembelianHartaTetapDetail::findOne($value->id_pembelian_harta_tetap_detail);
            $data_pembelian_harta_tetap_detail->status = 2;
            $data_pembelian_harta_tetap_detail->save(FALSE);
        }

        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Penjualan Harta Tetap : ' . $model->no_faktur_penjualan_harta_tetap . ' Berhasil Disetujui']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan_harta_tetap]);
    }

    public function actionRejected($id, $id_login)
    {
        $model = $this->findModel($id);
        $model->status = 3;
        $model->the_approver = $id_login;
        $model->the_approver_date = date('Y-m-d H:i:s');
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Penjualan Harta Tetap : ' . $model->no_faktur_penjualan_harta_tetap . ' Berhasil Ditolak']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan_harta_tetap]);
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->the_approver = NULL;
        $model->the_approver_date = NULL;

        #pengecekan apakah data pembelian harta tetap ny dari sudah di setujui kemudian di pending
        $data_penjualan_harta_tetap_detail = AktPenjualanHartaTetapDetail::findAll(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
        foreach ($data_penjualan_harta_tetap_detail as $key => $value) {
            # code...
            $data_pembelian_harta_tetap_detail = AktPembelianHartaTetapDetail::findOne($value->id_pembelian_harta_tetap_detail);
            $data_pembelian_harta_tetap_detail->status = 1;
            $data_pembelian_harta_tetap_detail->save(FALSE);
        }

        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Penjualan Harta Tetap : ' . $model->no_faktur_penjualan_harta_tetap . ' Berhasil Dipending']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan_harta_tetap]);
    }
}
