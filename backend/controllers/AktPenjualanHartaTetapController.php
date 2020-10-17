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
<<<<<<< HEAD
                ->andWhere(['=', 'id_kelompok_aset_tetap', ''])
=======
                ->andWhere(['IS NOT', 'akt_pembelian_harta_tetap_detail.id_kelompok_aset_tetap', null])
                ->asArray()
>>>>>>> origin/main
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


            if ($model->uang_muka > 0 && $model->id_kas_bank == '') {
                Yii::$app->session->setFlash('danger', [['Perhatian !', 'Jika ada uang muka, kas bank tidak boleh kosong!']]);
                return $this->redirect(['view', 'id' => $id]);
            }



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
        $akt_jurnal_umum = AktJurnalUmum::find()->select(["no_jurnal_umum"])->orderBy("id_jurnal_umum DESC")->limit(1)->one();
        if (!empty($akt_jurnal_umum->no_jurnal_umum)) {
            # code...
            $no_bulan = substr($akt_jurnal_umum->no_jurnal_umum, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_jurnal_umum->no_jurnal_umum, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_jurnal_umum = 'JU' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_jurnal_umum = 'JU' . date('ym') . '001';
            }
        } else {
            # code...
            $no_jurnal_umum = 'JU' . date('ym') . '001';
        }

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
        $grand_total = $penjualan_barang + $pajak + $model->ongkir + $model->materai;


        if ($model->jenis_bayar == 1) {

            $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Harta Tetap Cash'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();

            foreach ($jurnal_transaksi_detail as $jt) {

                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

                if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $penjualan_barang;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $penjualan_barang;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $penjualan_barang;
                    }
                } else if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $penjualan_barang;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $penjualan_barang;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $penjualan_barang;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $grand_total;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $grand_total;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                    }
                } else if ($akun->nama_akun == 'PPN Keluaran' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $pajak;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $pajak;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $pajak;
                    }
                } else if ($akun->nama_akun == 'PPN Keluaran' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $pajak;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $pajak;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $pajak;
                    }
                } else if ($akun->nama_akun == 'Hutang Pengiriman' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->ongkir;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->ongkir;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $model->ongkir;
                    }
                } else if ($akun->nama_akun == 'Hutang Pengiriman' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->ongkir;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $model->ongkir;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $model->ongkir;
                    }
                } else if ($akun->nama_akun == 'Biaya Admin Kantor' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->materai;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->materai;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $model->materai;
                    }
                } else if ($akun->nama_akun == 'Biaya Admin Kantor' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->materai;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $model->materai;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $model->materai;
                    }
                } else if ($akun->nama_akun == 'Uang Muka Penjualan' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->uang_muka;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $model->uang_muka;
                    }
                } else if ($akun->nama_akun == 'Uang Muka Penjualan' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $model->uang_muka;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $model->uang_muka;
                    }
                } else if ($model->id_kas_bank != null) {
                    $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                    if ($akun->nama_akun == 'kas' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                        }
                    } else if ($akun->nama_akun == 'kas' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                        }
                    }
                    $akt_kas_bank->save(false);
                }
                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Penjualan Harta Tetap : ' .  $model->no_penjualan_harta_tetap;
                $jurnal_umum_detail->save(false);

                if ($akun->nama_akun == 'kas') {
                    $history_transaksi_kas = new AktHistoryTransaksi();
                    $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                    $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                    $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                    $history_transaksi_kas->save(false);
                }
            }
        } else if ($model->jenis_bayar == 2) {

            $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Harta Tetap Kredit'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();

            foreach ($jurnal_transaksi_detail as $jt) {

                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

                if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $penjualan_barang;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $penjualan_barang;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $penjualan_barang;
                    }
                } else if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $penjualan_barang;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $penjualan_barang;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $penjualan_barang;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $grand_total;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $grand_total;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                    }
                } else if ($akun->nama_akun == 'PPN Keluaran' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $pajak;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $pajak;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $pajak;
                    }
                } else if ($akun->nama_akun == 'PPN Keluaran' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $pajak;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $pajak;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $pajak;
                    }
                } else if ($akun->nama_akun == 'Hutang Pengiriman' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->ongkir;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->ongkir;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $model->ongkir;
                    }
                } else if ($akun->nama_akun == 'Hutang Pengiriman' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->ongkir;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $model->ongkir;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $model->ongkir;
                    }
                } else if ($akun->nama_akun == 'Biaya Admin Kantor' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->materai;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->materai;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $model->materai;
                    }
                } else if ($akun->nama_akun == 'Biaya Admin Kantor' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->materai;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $model->materai;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $model->materai;
                    }
                } else if ($akun->nama_akun == 'Uang Muka Penjualan' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->uang_muka;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $model->uang_muka;
                    }
                } else if ($akun->nama_akun == 'Uang Muka Penjualan' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $model->uang_muka;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $model->uang_muka;
                    }
                } else if ($model->id_kas_bank != null) {
                    $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                    if ($akun->nama_akun == 'kas' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                        }
                    } else if ($akun->nama_akun == 'kas' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                        }
                    }
                    $akt_kas_bank->save(false);
                }
                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Penjualan Harta Tetap : ' .  $model->no_penjualan_harta_tetap;
                $jurnal_umum_detail->save(false);

                if ($akun->nama_akun == 'kas') {
                    $history_transaksi_kas = new AktHistoryTransaksi();
                    $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                    $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                    $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                    $history_transaksi_kas->save(false);
                }
            }
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
                    $akt_kas_bank->saldo = $akt_kas_bank->saldo - $ju->debit + $ju->kredit;
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
