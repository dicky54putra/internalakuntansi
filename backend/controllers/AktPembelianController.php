<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelian;
use backend\models\AktPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktAkun;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use backend\models\AktItemStok;
use backend\models\Foto;
use backend\models\Setting;
use backend\models\AktPembelianDetail;
use backend\models\AktJurnalUmum;
use backend\models\AktHistoryTransaksi;
use backend\models\AktPembelianPenerimaan;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktJurnalUmumDetail;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Utils;

/**
 * AktPembelianController implements the CRUD actions for AktPembelian model.
 */
class AktPembelianController extends Controller
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
     * Lists all AktPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPembelian model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
        $model_pembelian_detail = $query->sum('total');

        $data_customer = AktPembelian::dataCustomer();
        $data_mata_uang = AktPembelian::dataMataUang();

        if (Yii::$app->request->get('aksi') == "ubah_data_pembelian") {

            $model->ongkir = $model->ongkir == NULL ? 0 : $model->ongkir;
            $model->diskon = $model->diskon == NULL ? 0 : $model->diskon;
            $model->materai = $model->materai == NULL ? 0 : $model->materai;

            $model->total = $model->total == NULL ? $model_pembelian_detail : $model->total;

            if ($model->load(Yii::$app->request->post())) {

                // $model_ongkir = Yii::$app->request->post('AktPembelian')['ongkir'];
                $model->uang_muka = preg_replace("/[^0-9,]+/", "", $model->uang_muka);
                $model->ongkir = preg_replace("/[^0-9,]+/", "", $model->ongkir);
                $model->materai = preg_replace("/[^0-9,]+/", "", $model->materai);

                if ($model->uang_muka > 0 && $model->id_kas_bank == '') {
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Jika ada uang muka, kas bank tidak boleh kosong!']]);
                    return $this->redirect(['view', 'id' => $model->id_pembelian]);
                }

                $diskon = ($model->diskon > 0) ? ($model->diskon * $model_pembelian_detail) / 100 : 0;
                $pajak = ($model->pajak == 1) ? (($model_pembelian_detail - $diskon) * 10) / 100 : 0;
                $model_total = (($model_pembelian_detail - $diskon) + $pajak) + $model->ongkir + $model->materai - $model->uang_muka;

                $model->total = $model_total;

                if ($model->jenis_bayar == 1) {
                    # code...
                    $model->jatuh_tempo = NULL;
                    $model->tanggal_tempo = NULL;
                } else {
                    $model->tanggal_tempo = date('Y-m-d', strtotime('+' . $model->jatuh_tempo . ' days', strtotime($model->tanggal_order_pembelian)));
                }

                $model->save(FALSE);

                Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Pembelian Berhasil Di Simpan']]);
                return $this->redirect(['view', 'id' => $model->id_pembelian]);
            }
        } elseif (Yii::$app->request->get('aksi') == "supplier") {

            $supplier = new AktMitraBisnis();
            $total = AktMitraBisnis::find()->count();
            $nomor = 'MB' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);
            $supplier->kode_mitra_bisnis = $nomor;
            $supplier->nama_mitra_bisnis = Yii::$app->request->post('nama_mitra_bisnis');
            $supplier->deskripsi_mitra_bisnis = Yii::$app->request->post('deskripsi_mitra_bisnis');
            $supplier->tipe_mitra_bisnis = 2;
            $supplier->status_mitra_bisnis = 1;
            $supplier->id_level_harga = Yii::$app->request->post('id_level_harga');
            $supplier->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Supplier baru Berhasil Di Tambahkan']]);

            $tipe = Yii::$app->request->get('tipe');

            if ($tipe == 'order_pembelian') {
                $url = 'view';
            } else if ($tipe == 'pembelian_langsung') {
                $url = 'akt-pembelian-pembelian/view';
            }

            return $this->redirect([$url, 'id' => $model->id_pembelian]);
        }

        $data_item_stok = AktPembelian::dataItemStok($model);


        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $model->id_pembelian, "nama_tabel" => "pembelian"])->all();

        # form modal input barang
        $model_pembelian_detail_baru = new AktPembelianDetail();
        $model_pembelian_detail_baru->id_pembelian = $model->id_pembelian;
        $model_pembelian_detail_baru->diskon = 0;

        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'] . ' : ' . ribuan($model['saldo']);
            }
        );




        $data_penagih = ArrayHelper::map(AktMitraBisnis::find()->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis');
        $data_pengirim = ArrayHelper::map(AktMitraBisnis::find()->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis');
        return $this->render('view', [
            'model' => $model,
            'data_item_stok' => $data_item_stok,
            'foto' => $foto,
            'model_pembelian_detail_baru' => $model_pembelian_detail_baru,
            'model_pembelian_detail' => $model_pembelian_detail,
            'data_kas_bank' => $data_kas_bank,
            'data_penagih' => $data_penagih,
            'data_pengirim' => $data_pengirim,
            'data_customer' => $data_customer,
            'data_mata_uang' => $data_mata_uang,

        ]);
    }

    /**
     * Creates a new AktPembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPembelian();

        $kode =  Utils::getNomorTransaksi($model, 'PO', 'no_order_pembelian', 'no_order_pembelian');
        $model->no_order_pembelian = $kode;
        $model->no_pembelian = substr_replace($kode, "PE", 0, 2);
        $model->no_penerimaan = substr_replace($kode, "PQ", 0, 2);

        $data_customer = AktPembelian::dataCustomer();
        $data_mata_uang = AktPembelian::dataMataUang();
        $data_sales = AktPembelian::dataSales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_customer' => $data_customer,
            'data_sales' => $data_sales,
            'data_mata_uang' => $data_mata_uang,
        ]);
    }

    public function actionCreateSupplier()
    {
        if (Yii::$app->request->get('aksi') == "supplier") {

            $supplier = new AktMitraBisnis();
            $total = AktMitraBisnis::find()->count();
            $nomor = 'MB' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);
            $supplier->kode_mitra_bisnis = $nomor;
            $supplier->nama_mitra_bisnis = Yii::$app->request->post('nama_mitra_bisnis');
            $supplier->deskripsi_mitra_bisnis = Yii::$app->request->post('deskripsi_mitra_bisnis');
            $supplier->tipe_mitra_bisnis = 2;
            $supplier->status_mitra_bisnis = 1;
            // $supplier->id_level_harga = Yii::$app->request->post('id_level_harga');
            $supplier->tipe_mitra_bisnis = Yii::$app->request->post('tipe_mitra_bisnis');
            $supplier->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Supplier baru Berhasil Di Tambahkan']]);
            return $this->redirect(['create']);
        }
    }

    public function actionUpload()
    {
        $model = new Foto();

        if (Yii::$app->request->isPost) {

            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');

            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        }
    }

    /**
     * Updates an existing AktPembelian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $nomor = $model->no_order_pembelian;

        $data_customer = AktPembelian::dataCustomer();
        $data_mata_uang = AktPembelian::dataMataUang();
        $data_sales = AktPembelian::dataSales();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'data_customer' => $data_customer,
            'data_sales' => $data_sales,
            'data_mata_uang' => $data_mata_uang,
        ]);
    }

    /**
     * Deletes an existing AktPembelian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);
        $cek_detail = AKtPembelianDetail::find()->where(['id_pembelian' => $id])->count();

        if ($cek_detail > 0) {
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Silahkan hapus detail pembelian terlebih dahulu!']]);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $model->delete();
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the AktPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionApproved($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->tanggal_approve = date("Y-m-d h:i:s");

        $model->id_login = Yii::$app->user->identity->id_login;

        $pembelian_detail = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_pembelian_detail WHERE id_pembelian = '$model->id_pembelian'")->queryScalar();
        $pajak = 0;
        $diskon = $model->diskon / 100 * $pembelian_detail;
        if ($model->pajak == 1) {
            $total_pembelian = $pembelian_detail - $diskon;
            $pajak = 0.1 * $total_pembelian;
        } else if ($model->pajak == 0) {
            $pajak = 0;
        }
        $pembelian_barang = $pembelian_detail - $diskon;
        $grand_total = $pembelian_barang + $pajak + $model->ongkir + $model->materai;

        $hutang_usaha = $grand_total - $model->uang_muka;

        $data_jurnal_umum = array(
            'hutang_usaha' => $hutang_usaha,
            'pembelian_barang' => $pembelian_barang,
            'pajak' => $pajak,
            'uang_muka' => $model->uang_muka,
            'materai' => $model->materai,
            'ongkir' => $model->ongkir
        );


        # checking 2x
        $show_hide = 0;
        $query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
        $count_query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->count();

        foreach ($query_detail as $key => $data) {
            # code...
            $item_stok = AktItemStok::findOne($data['id_item_stok']);

            $a = ($data['qty'] > $item_stok->qty) ? 1 : 0;

            $show_hide += $a;
        }
        if ($count_query_detail != 0) {

            // Create Jurnal Umum
            $jurnal_umum = new AktJurnalUmum();
            $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();
            $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
            $jurnal_umum->tipe = 1;
            $jurnal_umum->tanggal = $model->tanggal_pembelian;
            $jurnal_umum->keterangan = 'Order Pembelian : ' .  $model->no_order_pembelian;
            $jurnal_umum->save(false);

            // End Create Jurnal Umum


            if ($model->jenis_bayar == 2) {
                $pembelian_kredit = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembelian Kredit'])->one();
                $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_kredit['id_jurnal_transaksi']])->all();
                AktPembelian::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum, 'order_pembelian');
            } else if ($model->jenis_bayar == 1) {
                $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembelian Cash'])->one();
                $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();
                AktPembelian::setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum, 'order_pembelian');
            }
            $model->save(FALSE);
            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_pembelian';
            $history_transaksi->id_tabel = $model->id_pembelian;
            $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $history_transaksi->save(false);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
        } else {
            # code...
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Terdapat Quantity Data Yang Melebihi Stok']]);
        }

        return $this->redirect(['view', 'id' => $model->id_pembelian]);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date("Y-m-d h:i:s");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status = 6;
        $model->save(false);
        Yii::$app->session->setFlash('success', [['Berhasil !', 'Berhasil Ditolak!']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian]);
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date("Y-m-d h:i:s");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status = 1;
        $model->save(false);
        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembelian'])->count();

        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembelian'])->one();
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



        Yii::$app->session->setFlash('success', [['Berhasil !', 'Berhasil Dipending!']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian]);
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
}
