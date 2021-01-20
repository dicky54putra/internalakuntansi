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

use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktAkun;
use backend\models\AktHistoryTransaksi;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;


use backend\models\AktPenjualanHartaTetapDetail;
use backend\models\AktPembelianHartaTetapDetail;
use backend\models\AktDepresiasiHartaTetap;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktItemStok;
use backend\models\AktKasBank;
use yii\helpers\Utils;

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
        $total_cek = $cek_update_jenis_bayar +  $cek_detail;

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
                ->andWhere(['IS NOT', 'akt_pembelian_harta_tetap_detail.id_kelompok_aset_tetap', null])
                ->asArray()
                ->all(),
            'id_pembelian_harta_tetap_detail',
            function ($model) {
                return 'Kode Pembelian : ' . $model['kode_pembelian'] . ', Nama Barang : ' . $model['nama_barang'];
            }
        );

        $data_mata_uang = AktPenjualanHartaTetap::dataMataUang($model);
        $data_customer = AktPenjualanHartaTetap::dataCustomer($model);
        $data_sales = AktPenjualanHartaTetap::dataSales($model);
        $data_kas_bank = AktPembelianHartaTetap::dataKasBank($model);
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
        $no_penjualan_harta_tetap = Utils::getNomorTransaksi($model, 'PH', 'no_penjualan_harta_tetap', 'id_penjualan_harta_tetap');

        $model->no_penjualan_harta_tetap = $no_penjualan_harta_tetap;
        $model->tanggal_penjualan_harta_tetap = date('Y-m-d');
        $model->id_mata_uang = 1;

        $data_mata_uang = AktPenjualanHartaTetap::dataMataUang($model);
        $data_customer = AktPenjualanHartaTetap::dataCustomer($model);
        $data_sales = AktPenjualanHartaTetap::dataSales($model);

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
        $query = AktPenjualanHartaTetapDetail::find()
            ->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
        $cek_detail = $query->count();
        $sum_detail = $query->sum('total');

        if ($model->load(Yii::$app->request->post())) {


            if ($cek_detail > 0) {
                $model_ongkir = Yii::$app->request->post('AktPenjualanHartaTetap')['ongkir'];
                $model_materai = Yii::$app->request->post('AktPenjualanHartaTetap')['materai'];
                $model_uang_muka = Yii::$app->request->post('AktPenjualanHartaTetap')['uang_muka'];

                $model->ongkir = empty($model_ongkir) ? '0' :  preg_replace("/[^0-9,]+/", "", $model_ongkir);
                $model->materai = empty($model_materai) ? '0' : preg_replace("/[^0-9,]+/", "", $model_materai);
                $model->uang_muka = empty($model_uang_muka) ? '0' : preg_replace("/[^0-9,]+/", "", $model_uang_muka);

                if ($model->uang_muka > 0 && $model->id_kas_bank == '') {
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Jika ada uang muka, kas bank tidak boleh kosong!']]);
                    return $this->redirect(['view', 'id' => $id]);
                }

                $diskon = ($model->diskon > 0) ? ($model->diskon * $sum_detail) / 100 : 0;
                $pajak = ($model->pajak == 1) ? (($sum_detail - $diskon) * 10) / 100 : 0;

                $model_total_sementara = (($sum_detail - $diskon) + $pajak) + $model->ongkir;
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
        $model =   $this->findModel($id);

        $query_detail = AktPenjualanHartaTetapDetail::find()->where(['id_penjualan_harta_tetap' => $id]);

        if ($query_detail->count() > 0) {
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Hapus data detail penjualan terlebih dahulu.']]);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $model->delete();
            return $this->redirect(['index']);
        }
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
        $model->the_approver_date = date('Y-m-d');


        $penjualan_harta_tetap_detail = AktPenjualanHartaTetapDetail::find()
            ->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap])
            ->all();

        foreach ($penjualan_harta_tetap_detail as $data) {

            $pembelian_harta_tetap_detail = AktPembelianHartaTetapDetail::findOne($data['id_pembelian_harta_tetap_detail']);

            $tanggal_ekonomis = date("Y-m-t", strtotime("$pembelian_harta_tetap_detail->tanggal_pakai +$pembelian_harta_tetap_detail->umur_ekonomis year"));
            $start = $model->tanggal_penjualan_harta_tetap;

            $depresiasi_harta_tetap =  AktDepresiasiHartaTetap::find()
                ->where(['>=', 'tanggal', $start])
                ->andWhere(['<=', 'tanggal', $tanggal_ekonomis])
                ->andWhere(['=', 'id_pembelian_harta_tetap_detail', $data['id_pembelian_harta_tetap_detail']])
                ->all();


            foreach ($depresiasi_harta_tetap as $d) {
                $d->delete();
            }

            $pembelian_harta_tetap_detail->status = 2;

            $pembelian_harta_tetap_detail->save();
        }


        // Create Jurnal Umum
        $jurnal_umum = new AktJurnalUmum();
        $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();
        $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
        $jurnal_umum->tipe = 1;
        $jurnal_umum->tanggal = date('Y-m-d');
        $jurnal_umum->keterangan = 'Penjualan Harta Tetap : ' .  $model->no_penjualan_harta_tetap;
        $jurnal_umum->save(false);

        // End Create Jurnal Umum


        $penjualan_detail = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_penjualan_harta_tetap_detail WHERE id_penjualan_harta_tetap = '$model->id_penjualan_harta_tetap'")->queryScalar();


        $pajak = 0;
        $diskon = $model->diskon / 100 * $penjualan_detail;
        if ($model->pajak == 1) {
            $total_penjualan = $penjualan_detail - $diskon;
            $pajak = 0.1 * $total_penjualan;
        } else if ($model->pajak == 0) {
            $pajak = 0;
        }
        $penjualan_barang = $penjualan_detail - $diskon;
        $grand_total = $penjualan_barang + $pajak + $model->ongkir - $model->materai;
        $piutang_usaha = $grand_total - $model->uang_muka;
        $data_jurnal_umum = array(
            'grand_total' => $piutang_usaha,
            'penjualan_barang' => $penjualan_barang,
            'pajak' => $pajak,
            'uang_muka' => $model->uang_muka,
            'materai' => $model->materai,
            'ongkir' => $model->ongkir
        );

        if ($model->jenis_bayar == 1) {

            $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Harta Tetap Cash'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();

            AktPenjualanHartaTetap::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum);
        } else if ($model->jenis_bayar == 2) {

            $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Harta Tetap Kredit'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();
            AktPenjualanHartaTetap::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum);
        }


        $model->save(FALSE);
        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_penjualan_harta_tetap';
        $history_transaksi->id_tabel = $model->id_penjualan_harta_tetap;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Penjualan Harta Tetap : ' . $model->no_faktur_penjualan_harta_tetap . ' Berhasil Disetujui']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan_harta_tetap]);
    }

    public function actionRejected($id, $id_login)
    {
        $model = $this->findModel($id);
        $model->status = 3;
        $model->the_approver = $id_login;
        $model->the_approver_date = date('Y-m-d');
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
        // $data_penjualan_harta_tetap_detail = AktPenjualanHartaTetapDetail::findAll(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
        // foreach ($data_penjualan_harta_tetap_detail as $key => $value) {
        //     # code...
        //     $data_pembelian_harta_tetap_detail = AktPembelianHartaTetapDetail::findOne($value->id_pembelian_harta_tetap_detail);
        //     $data_pembelian_harta_tetap_detail->status = 1;
        //     $data_pembelian_harta_tetap_detail->save(FALSE);
        // }

        $penjualan_harta_tetap_detail = AktPenjualanHartaTetapDetail::find()
            ->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap])
            ->all();

        foreach ($penjualan_harta_tetap_detail as $data) {

            $pembelian_harta_tetap_detail = AktPembelianHartaTetapDetail::findOne($data['id_pembelian_harta_tetap_detail']);

            $beban_per_bulan = $pembelian_harta_tetap_detail->beban_per_bulan;
            $tanggal_ekonomis = date("Y-m-d", strtotime("$pembelian_harta_tetap_detail->tanggal_pakai +$pembelian_harta_tetap_detail->umur_ekonomis year"));

            $month = strtotime($pembelian_harta_tetap_detail->tanggal_pakai);
            $end = strtotime($tanggal_ekonomis);
            while ($month <= $end) {
                $tanggal =  date('Y-m-t', $month);
                $depresiasi_harta_tetap = new AktDepresiasiHartaTetap();
                $akt_depresiasi_harta_tetap = AktDepresiasiHartaTetap::find()->select(["kode_depresiasi"])->orderBy("id_depresiasi_harta_tetap DESC")->limit(1)->one();
                if (!empty($akt_depresiasi_harta_tetap->kode_depresiasi)) {
                    # code...
                    $no_bulan = substr($akt_depresiasi_harta_tetap->kode_depresiasi, 2, 4);
                    if ($no_bulan == date('ym')) {
                        # code...
                        $noUrut = substr($akt_depresiasi_harta_tetap->kode_depresiasi, -3);
                        $noUrut++;
                        $noUrut_2 = sprintf("%03s", $noUrut);
                        $kode_depresiasi = 'FD' . date('ym') . $noUrut_2;
                    } else {
                        # code...
                        $kode_depresiasi = 'FD' . date('ym') . '001';
                    }
                } else {
                    # code...
                    $kode_depresiasi = 'FD' . date('ym') . '001';
                }

                $depresiasi_harta_tetap->id_pembelian_harta_tetap_detail = $pembelian_harta_tetap_detail->id_pembelian_harta_tetap_detail;
                $depresiasi_harta_tetap->tanggal = $tanggal;
                $depresiasi_harta_tetap->nilai = $beban_per_bulan;
                $depresiasi_harta_tetap->kode_depresiasi = $kode_depresiasi;
                $depresiasi_harta_tetap->save(false);

                $month = strtotime("+1 month", $month);
            }

            $pembelian_harta_tetap_detail->status = 1;

            $pembelian_harta_tetap_detail->save(false);
        }

        $model->save(FALSE);

        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penjualan_harta_tetap'])->count();

        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penjualan_harta_tetap'])->one();
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi['id_jurnal_umum']])->one();
            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum['id_jurnal_umum']])->all();
            foreach ($jurnal_umum_detail as $ju) {
                $akun = AktAkun::find()->where(['id_akun' => $ju->id_akun])->one();
                if ($akun->nama_akun != 'kas') {
                    if ($akun->saldo_normal == 1 && $ju->debit > 0 || $ju->debit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun - $ju->debit;
                    } else if ($akun->saldo_normal == 1 && $ju->kredit > 0 || $ju->kredit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun + $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->kredit > 0 || $ju->kredit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun - $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->debit > 0 || $ju->debit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun + $ju->debit;
                    }
                } else if ($akun->nama_akun == 'kas' && $model->id_kas_bank != null) {
                    $history_transaksi_kas = AktHistoryTransaksi::find()
                        ->where(['id_tabel' => $model->id_kas_bank])
                        ->andWhere(['nama_tabel' => 'akt_kas_bank'])
                        ->andWhere(['id_jurnal_umum' => $ju->id_jurnal_umum_detail])->one();
                    $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();
                    if ($akun->saldo_normal == 1 && $ju->debit > 0 || $ju->debit < 0) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $ju->debit;
                    } else if ($akun->saldo_normal == 1 && $ju->kredit > 0 || $ju->kredit < 0) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->kredit > 0 || $ju->kredit < 0) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->debit > 0 || $ju->debit < 0) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $ju->debit;
                    }
                    $akt_kas_bank->save(false);
                    $history_transaksi_kas->delete();
                }
                $akun->save(false);
                $ju->delete();
            }

            $jurnal_umum->delete();
            $history_transaksi->delete();
        }




        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Penjualan Harta Tetap : ' . $model->no_faktur_penjualan_harta_tetap . ' Berhasil Dipending']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan_harta_tetap]);
    }
}
