<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualan;
use backend\models\AktPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktMitraBisnis;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktMitraBisnisBankPajak;
use backend\models\AktSales;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use backend\models\AktItemStok;
use backend\models\AktSatuan;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\models\Foto;
use backend\models\AktPenjualanDetail;
use backend\models\Setting;

use backend\models\AktHistoryTransaksi;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksiDetail;
use backend\models\JurnalTransaksi;


use backend\models\AktAkun;
use backend\models\AktPenjualanPengiriman;
use yii\helpers\Utils;

/**
 * AktPenjualanController implements the CRUD actions for AktPenjualan model.
 */
class AktPenjualanPenjualanController extends Controller
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
     * Lists all AktPenjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenjualanSearch();
        $dataProvider = $searchModel->searchPenjualan(Yii::$app->request->queryParams);
        $is_penjualan = AktPenjualan::cekButtonPenjualan();
        return $this->render('index', [
            'is_penjualan' => $is_penjualan,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenjualan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $model->id_penjualan, "nama_tabel" => "penjualan"])->all();

        # form modal input barang
        $model_penjualan_detail_baru = new AktPenjualanDetail();
        $model_penjualan_detail_baru->id_penjualan = $model->id_penjualan;
        $model_penjualan_detail_baru->diskon = 0;

        $data_item_stok = AktPenjualan::data_item_stok($model);

        # untuk tombol pengiriman klo data penjualan belom di update belom bisa melakukan pengiriman
        $count_model_no_penjualan = ($model->no_penjualan == NULL) ? 1 : 0;
        $count_model_tanggal_penjualan = ($model->tanggal_penjualan == NULL) ? 1 : 0;
        if ($model->jenis_bayar == 1) {
            $count_model_jenis_bayar = 0;
        } else {
            if ($model->tanggal_tempo == null || $model->jumlah_tempo == null) {
                $count_model_jenis_bayar = 1;
            } else {
                $count_model_jenis_bayar = 0;
            }
        }


        $count_data_penjualan_count = $count_model_no_penjualan + $count_model_tanggal_penjualan +  $count_model_jenis_bayar;
        $is_penjualan = AktPenjualan::cekButtonPenjualan();

        $data_customer = AktPenjualan::dataCustomer();
        $data_mata_uang = AktPenjualan::dataMataUang();
        $data_sales = AktPenjualan::dataSales();
        $data_kas_bank = AktPenjualan::dataKasNank();
        $model_new_customer = new AktMitraBisnis();
        $model_new_sales = new AktSales();

        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $total_penjualan_detail = $query->sum('total');

        return $this->render('view', [
            'data_sales' => $data_sales,
            'data_customer' => $data_customer,
            'data_mata_uang' => $data_mata_uang,
            'model_new_customer' => $model_new_customer,
            'model_new_sales' => $model_new_sales,
            'is_penjualan' => $is_penjualan,
            'data_kas_bank' => $data_kas_bank,
            'model' => $model,
            'foto' => $foto,
            'total_penjualan_detail' => $total_penjualan_detail,
            'model_penjualan_detail_baru' => $model_penjualan_detail_baru,
            'data_item_stok' => $data_item_stok,
            'count_data_penjualan_count' => $count_data_penjualan_count,
        ]);
    }


    public function actionFaktur()
    {
        $akt_penjualan_faktur = AktPenjualan::find()->where(['id_penjualan' => Yii::$app->request->get('id')])->one();
        $akt_penjualan_faktur->no_faktur_penjualan = Yii::$app->request->post('no_faktur_penjualan');
        $akt_penjualan_faktur->tanggal_faktur_penjualan = Yii::$app->request->post('tanggal_faktur_penjualan');
        $akt_penjualan_faktur->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'No. Faktur Berhasil Di Simpan']]);
        return $this->redirect(['view', 'id' => Yii::$app->request->get('id')]);
    }

    public function actionLevelHarga()
    {
        $country_id = $_POST['depdrop_parents'][0];
        $state = Yii::$app->db->createCommand("
        SELECT akt_item_harga_jual.id_item_harga_jual, akt_item_harga_jual.harga_satuan, akt_level_harga.keterangan FROM akt_item_stok 
        LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item 
        LEFT JOIN akt_item_harga_jual ON akt_item_harga_jual.id_item = akt_item.id_item
        Left JOIN akt_level_harga ON akt_level_harga.id_level_harga = akt_item_harga_jual.id_level_harga
        WHERE id_item_stok = '$country_id'")->query();
        $all_state = array();
        $i = 0;
        foreach ($state as $value) {
            $all_state[$i]['id'] =  $value['id_item_harga_jual'];
            $all_state[$i]['name'] =  $value['keterangan'];
            $i++;
        }

        echo Json::encode(['output' => $all_state, 'selected' => '']);
        return;
    }

    public function actionUpload()
    {
        $model = new Foto();

        if (Yii::$app->request->isPost) {

            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');

            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        } else {
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        }
    }


    protected function findModel($id)
    {
        if (($model = AktPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateFromModal($id)
    {
        $model = $this->findModel($id);
        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $count_penjualan_detail = $query->count();



        if ($model->load(Yii::$app->request->post())) {

            if ($count_penjualan_detail >  0) {
                $post_total_penjualan_detail = Yii::$app->request->post('total_penjualan_detail');
                $total_penjualan_detail = preg_replace('/\D/', '', $post_total_penjualan_detail);

                $model_ongkir = preg_replace("/[^0-9,]+/", "", Yii::$app->request->post('AktPenjualan')['ongkir']);
                $model_materai = preg_replace("/[^0-9,]+/", "", Yii::$app->request->post('AktPenjualan')['materai']);
                $model_uang_muka = preg_replace("/[^0-9,]+/", "", Yii::$app->request->post('AktPenjualan')['uang_muka']);

                $diskon = ($model->diskon > 0) ? ($model->diskon * $total_penjualan_detail) / 100 : 0;
                $pajak = ($model->pajak == 1) ? (($total_penjualan_detail - $diskon) * 10) / 100 : 0;
                $model_total_sementara = (($total_penjualan_detail - $diskon) + $pajak) + $model_ongkir;
                $model_total = $model_total_sementara - $model_uang_muka;

                $model->total = $model_total;
                $model->ongkir = $model_ongkir;
                $model->materai = $model_materai;
                $model->uang_muka = $model_uang_muka;
                if ($model->uang_muka > 0 && $model->id_kas_bank == '') {
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Jika ada uang muka, kas bank tidak boleh kosong!']]);
                    return $this->redirect(['view', 'id' => $model->id_penjualan]);
                }
                if ($model->jenis_bayar == 1) {
                    # code...
                    $model->jenis_bayar = 1;
                    $model->jumlah_tempo = NULL;
                    $model->tanggal_tempo = NULL;
                } elseif ($model->jenis_bayar == 2) {
                    # code...
                    $model->jenis_bayar = 2;
                    $model->jumlah_tempo = $model->jumlah_tempo;

                    $model->tanggal_tempo = date('Y-m-d', strtotime('+' . $model->jumlah_tempo . ' days', strtotime($model->tanggal_penjualan)));
                }
            }

            $model->save(FALSE);

            if ($count_penjualan_detail > 0) {

                // Create Jurnal Umum
                $jurnal_umum = new AktJurnalUmum();
                $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();
                $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
                $jurnal_umum->tipe = 1;
                $jurnal_umum->tanggal = date('Y-m-d');
                $jurnal_umum->keterangan = 'Penjualan : ' .  $model->no_penjualan;
                $jurnal_umum->save(false);

                // End Create Jurnal Umum
                $penjualan_detail = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_penjualan_detail WHERE id_penjualan = '$model->id_penjualan'")->queryScalar();
                $pajak = 0;
                $diskon = $model->diskon / 100 * $penjualan_detail;
                if ($model->pajak == 1) {
                    $total_pembelian = $penjualan_detail - $diskon;
                    $pajak = 0.1 * $total_pembelian;
                } else if ($model->pajak == 0) {
                    $pajak = 0;
                }
                $penjualan_barang = $penjualan_detail - $diskon;
                $grand_total = $penjualan_barang + $pajak + $model->ongkir - $model->materai;

                $piutang_usaha = $grand_total - $model->uang_muka;

                $data_jurnal_umum = array(
                    'piutang_usaha' => $piutang_usaha,
                    'total_penjualan' => $penjualan_barang,
                    'pajak' => $pajak,
                    'uang_muka' => $model->uang_muka,
                    'materai' => $model->materai,
                    'ongkir' => $model->ongkir
                );

                if ($model->jenis_bayar == 2) {
                    // Data for debit or credit in jurnal transaksi
                    $penjualanKredit = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Kredit'])->one();
                    $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $penjualanKredit['id_jurnal_transaksi']])->all();
                    AktPenjualan::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum, 'penjualan');
                } elseif ($model->jenis_bayar == 1) {
                    // Data for debit or credit in jurnal transaksi
                    $penjualan_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Cash'])->one();
                    $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $penjualan_cash['id_jurnal_transaksi']])->all();
                    AktPenjualan::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum, 'penjualan');
                }


                $history_transaksi = new AktHistoryTransaksi();
                $history_transaksi->nama_tabel = 'akt_penjualan';
                $history_transaksi->id_tabel = $model->id_penjualan;
                $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $history_transaksi->save(false);
            }

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Perubahan Data Berhasil Disimpan']]);

            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionHapusDataPenjualan($id)
    {
        $model = $this->findModel($id);
        $model->jenis_bayar = null;
        $model->ongkir = 0;
        $model->diskon = 0;
        $model->pajak = 0;
        $model->uang_muka = 0;
        $model->materai = 0;
        $model->the_approver = NULL;
        $model->the_approver_date = NULL;
        $model->tanggal_tempo = NULL;
        $model->jumlah_tempo = NULL;

        $model->save(FALSE);

        // Delete history transaksi, jurnal umum, jurnal umum detail, and update saldo.
        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penjualan'])->count();

        if ($history_transaksi_count > 0) {
            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penjualan'])->one();
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi->id_jurnal_umum])->one();
            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum->id_jurnal_umum])->all();
            foreach ($jurnal_umum_detail as $ju) {
                $akun = AktAkun::find()->where(['id_akun' => $ju->id_akun])->one();
                if ($akun->id_akun == 1 && $model->id_kas_bank != null) {
                    $history_transaksi_kas = AktHistoryTransaksi::find()
                        ->where(['id_tabel' => $model->id_kas_bank])
                        ->andWhere(['nama_tabel' => 'akt_kas_bank'])
                        ->andWhere(['id_jurnal_umum' => $ju->id_jurnal_umum_detail])->one();
                    $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();
                    $akt_kas_bank->saldo = $akt_kas_bank->saldo - $ju->debit + $ju->kredit;
                    $akt_kas_bank->save(false);
                    $history_transaksi_kas->delete();
                    $model->id_kas_bank = null;
                    $model->save(false);
                } else {

                    if ($akun->saldo_normal == 1 && $ju->debit > 0 || $ju->debit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun - $ju->debit;
                    } else if ($akun->saldo_normal == 1 && $ju->kredit > 0 || $ju->kredit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun + $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->kredit > 0 || $ju->kredit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun - $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->debit > 0 || $ju->debit < 0) {
                        $akun->saldo_akun = $akun->saldo_akun + $ju->debit;
                    }
                }
                $akun->save(false);
                $ju->delete();
            }
            $jurnal_umum->delete();
            $history_transaksi->delete();
        }


        // End

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Order Penjualan : ' . $model->no_order_penjualan . ' Berhasil dikembalikan seperti semula']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan]);
    }

    public function actionGetTanggal($id)
    {
        $h = AktPenjualan::find()->where(['id_penjualan' => $id])->asArray()->one();
        return json_encode($h);
    }

    public function actionPengiriman($id)
    {
        $model = $this->findModel($id);
        $model->status = 3;
        $model->save(FALSE);

        return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $model->id_penjualan]);

        // return $this->redirect(['akt-penjualan-pengiriman-parent/update-data-penjualan-pengiriman', 'id' => $model->id_penjualan]);
    }

    public function actionCetakInvoice($id)
    {
        $model = $this->findModel($id);

        $data_setting = Setting::find()->one();

        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $total_penjualan_barang = $query->sum('total');

        return $this->renderPartial('cetak_invoice', [
            'model' => $model,
            'data_setting' => $data_setting,
            'total_penjualan_barang' => $total_penjualan_barang,
        ]);
    }

    public function actionCetakSuratPesanan($id)
    {
        $model = $this->findModel($id);

        $model_customer = AktMitraBisnis::findOne($model->id_customer);

        $model_customer_alamat = AktMitraBisnisAlamat::findAll(['id_mitra_bisnis' => $model_customer->id_mitra_bisnis]);
        $model_customer_bank_pajak = AktMitraBisnisBankPajak::findAll(['id_mitra_bisnis' => $model_customer->id_mitra_bisnis]);

        $model_penjualan_pengiriman = AktPenjualanPengiriman::find()->where(['id_penjualan' => $model->id_penjualan])->groupBy("id_mitra_bisnis_alamat")->all();

        $data_setting = Setting::find()->one();

        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $total_penjualan_barang = $query->sum('total');

        return $this->renderPartial('cetak_surat_pesanan', [
            'model' => $model,
            'data_setting' => $data_setting,
            'total_penjualan_barang' => $total_penjualan_barang,
            'model_customer' => $model_customer,
            'model_customer_alamat' => $model_customer_alamat,
            'model_penjualan_pengiriman' => $model_penjualan_pengiriman,
            'model_customer_bank_pajak' => $model_customer_bank_pajak,
        ]);
    }

    public function actionCreate()
    {

        $model = new AktPenjualan();

        $model->tanggal_penjualan = date('Y-m-d');
        $kode =  Utils::getNomorTransaksi($model, 'PJ', 'no_penjualan', 'no_penjualan');

        $model->no_penjualan = $kode;

        $data_customer = AktPenjualan::dataCustomer();
        $data_mata_uang = AktPenjualan::dataMataUang();
        $data_sales = AktPenjualan::dataSales();
        $model_new_customer = new AktMitraBisnis();
        $model_new_sales = new AktSales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penjualan]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $kode,
            'data_sales' => $data_sales,
            'data_customer' => $data_customer,
            'data_mata_uang' => $data_mata_uang,
            'model_new_customer' => $model_new_customer,
            'model_new_sales' => $model_new_sales,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $cek_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $id])->count();

        if ($cek_detail > 0) {
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Silahkan hapus data detail penjualan terlebih dahulu']]);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $model->delete();
            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Order Penjualan ' . $model->no_order_penjualan . ' Berhasil Dihapus']]);
            return $this->redirect(['index']);
        }
    }
}
