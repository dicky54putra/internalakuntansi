<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualan;
use backend\models\AktPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use backend\models\AktItemStok;
use yii\helpers\ArrayHelper;
use backend\models\Foto;
use backend\models\AktPenjualanDetail;
use backend\models\AktJurnalUmum;
use backend\models\AktHistoryTransaksi;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\JurnalUmumDetail;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\Setting;
use yii\helpers\Json;
use yii\helpers\Utils;

/**
 * AktPenjualanController implements the CRUD actions for AktPenjualan model.
 */
class AktPenjualanController extends Controller
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
        $model->ongkir = ($model->ongkir == NULL) ? 0 : $model->ongkir;
        $model->diskon = ($model->diskon == NULL) ? 0 : $model->diskon;
        $model->materai = ($model->materai == NULL) ? 0 : $model->materai;
        $model->uang_muka = ($model->uang_muka == NULL) ? 0 : $model->uang_muka;

        #pengecekan
        $cek_update_jenis_bayar = ($model->jenis_bayar == 1) ? 0 : $retVal = ($model->jenis_bayar == 2 && $model->jumlah_tempo != NULL) ? 0 : 1;
        $cek_update_kas_bank = ($model->id_kas_bank == NULL) ? 1 : 0;
        $total_cek = $cek_update_jenis_bayar + $cek_update_kas_bank;

        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $total_penjualan_detail = $query->sum('total');

        $model->total = ($model->total == NULL) ? $total_penjualan_detail : $model->total;

        $data_item_stok = AktPenjualan::data_item_stok($model);

        #hapus foto
        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $model->id_penjualan, "nama_tabel" => "penjualan"])->all();

        # form modal input barang
        $model_penjualan_detail_baru = new AktPenjualanDetail();
        $model_penjualan_detail_baru->id_penjualan = $model->id_penjualan;
        $model_penjualan_detail_baru->diskon = 0;

        $data_customer = AktPenjualan::dataCustomer();
        $data_sales = AktPenjualan::dataSales();
        $data_mata_uang = AktPenjualan::dataMataUang();
        $data_kas_bank = AktPenjualan::dataKasNank();

        $model_new_customer = new AktMitraBisnis();
        $model_new_sales = new AktSales();

        return $this->render('view', [
            'model' => $model,
            'total_penjualan_detail' => $total_penjualan_detail,
            'data_item_stok' => $data_item_stok,
            'foto' => $foto,
            'model_penjualan_detail_baru' => $model_penjualan_detail_baru,
            'data_customer' => $data_customer,
            'data_sales' => $data_sales,
            'data_mata_uang' => $data_mata_uang,
            'model_new_customer' => $model_new_customer,
            'model_new_sales' => $model_new_sales,
            'total_cek' => $total_cek,
            'data_kas_bank' => $data_kas_bank,
        ]);
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
            $all_state[$i]['id'] = empty($value['id_item_harga_jual']) ? 0 : $value['id_item_harga_jual'];
            $all_state[$i]['name'] = empty($value['keterangan']) ? 'Data Kosong' : $value['keterangan'];
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

    /**
     * Creates a new AktPenjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenjualan();
        $model->tanggal_order_penjualan = date('Y-m-d');
        $model->id_mata_uang = 1;

        $no_order_penjualan = Utils::getNomorTransaksi($model, 'OP', 'no_order_penjualan', 'no_order_penjualan');

        $model->no_order_penjualan = $no_order_penjualan;
        $data_customer =  AktPenjualan::dataCustomer();
        $data_sales = AktPenjualan::dataSales();
        $data_mata_uang = AktPenjualan::dataMataUang();
        $model_new_customer = new AktMitraBisnis();
        $model_new_sales = new AktSales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Data Order Penjualan Berhasil Disimpan']]);
            return $this->redirect(['view', 'id' => $model->id_penjualan]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_customer' => $data_customer,
            'data_sales' => $data_sales,
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

    protected function findModel($id)
    {
        if (($model = AktPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApproved($id, $id_login)
    {
        $model = $this->findModel($id);

        $akt_penjualan = AktPenjualan::find()->select(["no_penjualan"])->where(['IS NOT', 'no_penjualan', NULL])->orderBy("id_penjualan DESC")->limit(1)->one();
        if (!empty($akt_penjualan->no_penjualan)) {
            # code...
            $no_bulan = substr($akt_penjualan->no_penjualan, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_penjualan->no_penjualan, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_penjualan = 'PJ' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_penjualan = 'PJ' . date('ym') . '001';
            }
        } else {
            # code...
            $no_penjualan = 'PJ' . date('ym') . '001';
        }
        $model->status = 2;
        $model->the_approver = $id_login;
        $model->the_approver_date = date('Y-m-d H:i:s');
        $model->no_penjualan = $no_penjualan;
        $model->tanggal_penjualan = date('Y-m-d');
        $model->save(FALSE);

        // Create Jurnal Umum
        $jurnal_umum = new AktJurnalUmum();
        $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();
        $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
        $jurnal_umum->tipe = 1;
        $jurnal_umum->tanggal = date('Y-m-d');
        $jurnal_umum->keterangan = 'Order Penjualan : ' .  $model->no_order_penjualan;
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
            AktPenjualan::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum, 'order_penjualan');
        } elseif ($model->jenis_bayar == 1) {
            // Data for debit or credit in jurnal transaksi
            $penjualan_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Cash'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $penjualan_cash['id_jurnal_transaksi']])->all();
            AktPenjualan::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum, 'order_penjualan');
        }


        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_penjualan';
        $history_transaksi->id_tabel = $model->id_penjualan;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan]);
    }

    public function actionCetakOrder($id)
    {
        $model = $this->findModel($id);

        $data_setting = Setting::find()->one();

        return $this->renderPartial('cetak_order', [
            'model' => $model,
            'data_setting' => $data_setting,
        ]);
    }

    public function actionReject($id, $id_login)
    {
        $model = $this->findModel($id);
        $model->status = 5;
        $model->the_approver = $id_login;
        $model->the_approver_date = date('Y-m-d H:i:s');
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Order Penjualan : ' . $model->no_order_penjualan . ' Berhasil Ditolak']]);

        return $this->redirect(['view', 'id' => $model->id_penjualan]);
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;
        $model->the_approver = NULL;
        $model->the_approver_date = NULL;
        $model->no_penjualan = NULL;
        $model->tanggal_penjualan = NULL;
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

    public function actionAddNewCustomer()
    {
        $total = AktMitraBisnis::find()->count();
        $kode_mitra_bisnis = 'MB' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $model_add_new_customer = new AktMitraBisnis();

        if ($model_add_new_customer->load(Yii::$app->request->post())) {
            # code...
            $model_add_new_customer->kode_mitra_bisnis = $kode_mitra_bisnis;
            $model_add_new_customer->status_mitra_bisnis = 1;
            $model_add_new_customer->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Customer : ' . $model_add_new_customer->nama_mitra_bisnis . ' Berhasil Ditambahkan']]);
        }

        $id = Yii::$app->request->get('id');
        $type = Yii::$app->request->get('type');

        if ($type == 'order_penjualan') {

            if (!empty($id)) {
                # code...
                return $this->redirect(['view', 'id' => $id]);
            } else {
                # code...
                return $this->redirect(['create']);
            }
        } else if ($type == 'penjualan_langsung') {
            if (!empty($id)) {
                # code...
                return $this->redirect(['akt-penjualan-penjualan/view', 'id' => $id]);
            } else {
                # code...
                return $this->redirect(['akt-penjualan-penjualan/create']);
            }
        }
    }

    public function actionAddNewSales()
    {
        $nama_sales = Yii::$app->request->post('AktSales')['nama_sales'];
        $telepon = Yii::$app->request->post('AktSales')['telepon'];
        $email = Yii::$app->request->post('AktSales')['email'];
        $alamat = Yii::$app->request->post('AktSales')['alamat'];

        $total = AktSales::find()->count();
        $kode_sales = 'SL' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $model_add_new_sales = new AktSales();
        $model_add_new_sales->kode_sales = $kode_sales;
        $model_add_new_sales->nama_sales = $nama_sales;
        $model_add_new_sales->telepon = $telepon;
        $model_add_new_sales->email = $email;
        $model_add_new_sales->alamat = $alamat;
        $model_add_new_sales->status_aktif = 1;
        $model_add_new_sales->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Sales : ' . $model_add_new_sales->nama_sales . ' Berhasil Ditambahkan']]);

        $id = Yii::$app->request->get('id');

        $type = Yii::$app->request->get('type');

        if ($type == 'order_penjualan') {

            if (!empty($id)) {
                # code...
                return $this->redirect(['view', 'id' => $id]);
            } else {
                # code...
                return $this->redirect(['create']);
            }
        } else if ($type == 'penjualan_langsung') {
            if (!empty($id)) {
                # code...
                return $this->redirect(['akt-penjualan-penjualan/view', 'id' => $id]);
            } else {
                # code...
                return $this->redirect(['akt-penjualan-penjualan/create']);
            }
        }
    }


    public function actionUpdateFromModal($id)
    {
        $model = $this->findModel($id);
        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $model_penjualan_detail = $query->sum('total');
        $count_penjualan_detail = $query->count();

        if ($model->load(Yii::$app->request->post())) {



            if ($model->uang_muka > 0 && $model->id_kas_bank == '') {
                Yii::$app->session->setFlash('danger', [['Perhatian !', 'Jika ada uang muka, kas bank tidak boleh kosong!']]);
                return $this->redirect(['view', 'id' => $model->id_penjualan]);
            }

            if ($count_penjualan_detail > 0) {

                // $post_total_penjualan_detail = Yii::$app->request->post('total_penjualan_detail');
                // $total_penjualan_detail = preg_replace('/\D/', '', $post_total_penjualan_detail);

                $model_ongkir = preg_replace("/[^0-9,]+/", "", Yii::$app->request->post('AktPenjualan')['ongkir']);
                $model_materai = preg_replace("/[^0-9,]+/", "", Yii::$app->request->post('AktPenjualan')['materai']);
                $model_uang_muka = preg_replace("/[^a-zA-Z0-9]/", "", Yii::$app->request->post('AktPenjualan')['uang_muka']);

                $diskon = ($model->diskon > 0) ? ($model->diskon * $model_penjualan_detail) / 100 : 0;
                $pajak = ($model->pajak == 1) ? (($model_penjualan_detail - $diskon) * 10) / 100 : 0;
                $model_total_sementara = (($model_penjualan_detail - $diskon) + $pajak) + $model_ongkir;
                $model_total = $model_total_sementara - $model_uang_muka;

                $model->ongkir = $model_ongkir;
                $model->materai = $model_materai;
                $model->uang_muka = $model_uang_muka;
                $model->total = $model_total;

                if ($model->jenis_bayar == 1) {
                    # code...
                    $model->jumlah_tempo = NULL;
                    $model->tanggal_tempo = NULL;
                } else {
                    $model->tanggal_tempo = date('Y-m-d', strtotime('+' . $model->jumlah_tempo . ' days', strtotime($model->tanggal_order_penjualan)));
                }
            }

            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Penjualan Berhasil Disimpan']]);
            return $this->redirect(['view', 'id' => $model->id_penjualan]);
        }
    }
}
