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

        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 1])
                ->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
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

        if (Yii::$app->request->get('aksi') == "ubah_data_pembelian") {

            $model->ongkir = $model->ongkir == NULL ? 0 : $model->ongkir;
            $model->diskon = $model->diskon == NULL ? 0 : $model->diskon;
            $model->materai = $model->materai == NULL ? 0 : $model->materai;

            $model->total = $model->total == NULL ? $model_pembelian_detail : $model->total;

            if ($model->load(Yii::$app->request->post())) {

                $model_ongkir = Yii::$app->request->post('AktPembelian')['ongkir'];
                // $_b = Yii::$app->request->post('beban_per_bulan');
                $model->uang_muka = preg_replace("/[^0-9,]+/", "", $model->uang_muka);


                if ($model->uang_muka > 0 && $model->id_kas_bank == '') {
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Jika ada uang muka, kas bank tidak boleh kosong!']]);
                    return $this->redirect(['view', 'id' => $model->id_pembelian]);
                }

                $diskon = ($model->diskon > 0) ? ($model->diskon * $model_pembelian_detail) / 100 : 0;
                $pajak = ($model->pajak == 1) ? (($model_pembelian_detail - $diskon) * 10) / 100 : 0;
                $model_total = (($model_pembelian_detail - $diskon) + $pajak) + $model_ongkir + $model->materai - $model->uang_muka;

                $model->ongkir = $model_ongkir;
                $model->total = $model_total;

                if ($model->jenis_bayar == 1) {
                    # code...
                    $model->jatuh_tempo = NULL;
                    $model->tanggal_tempo = NULL;
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

        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty", "akt_satuan.nama_satuan", "akt_item_harga_jual.harga_satuan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_item_harga_jual", "akt_item_harga_jual.id_item = akt_item.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->leftJoin("akt_satuan", "akt_satuan.id_satuan = akt_item.id_satuan")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Satuan : ' . $model['nama_satuan'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );


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

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_order_pembelian FROM `akt_pembelian` ORDER by no_order_pembelian DESC LIMIT 1")->queryScalar();
        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            // echo $noUrut; die;
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'PO' . date('ym') . '001';
            } else {
                // echo $noUrut; die;
                if ($noUrut <= 999) {
                    $noUrut++;
                    $noUrut_2 = sprintf("%03s", $noUrut);
                } elseif ($noUrut <= 9999) {
                    $noUrut++;
                    $noUrut_2 = sprintf("%04s", $noUrut);
                } elseif ($noUrut <= 99999) {
                    $noUrut++;
                    $noUrut_2 = sprintf("%05s", $noUrut);
                }

                $no_order_pembelian = "PO" . date('ym') . $noUrut_2;
                $kode = $no_order_pembelian;
            }
        } else {
            # code...
            $kode = 'PO' . date('ym') . '001';
        }

        $model->no_order_pembelian = $kode;
        $model->no_pembelian = substr_replace($kode, "PE", 0, 2);
        $model->no_penerimaan = substr_replace($kode, "PQ", 0, 2);

        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 1])
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
        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('create', [
            'model' => $model,
            // 'nomor' => $nomor,
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

        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 1])
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
        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
            }
        );

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
        Yii::$app->db->createCommand("DELETE FROM `akt_pembelian_detail` WHERE `akt_pembelian_detail`.`id_pembelian` = " . $id . "")->execute();
        $model->delete();

        return $this->redirect(['index']);
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
        $model->tanggal_pembelian = date("Y-m-d");
        $model->tanggal_tempo = date('Y-m-d', strtotime('+' . $model->jatuh_tempo . ' days', strtotime($model->tanggal_pembelian)));
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
            $jurnal_umum->keterangan = 'Order Pembelian : ' .  $model->no_order_pembelian;
            $jurnal_umum->save(false);

            // End Create Jurnal Umum

            if ($model->jenis_bayar == 2) {
                $pembelian_kredit = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembelian Kredit'])->one();
                $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_kredit['id_jurnal_transaksi']])->all();

                foreach ($jurnal_transaksi_detail as $jt) {
                    $jurnal_umum_detail = new AktJurnalUmumDetail();
                    $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                    $jurnal_umum_detail->id_akun = $jt->id_akun;
                    $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
                    if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $pembelian_barang;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $pembelian_barang;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $pembelian_barang;
                        }
                    } else if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $pembelian_barang;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun - $pembelian_barang;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun + $pembelian_barang;
                        }
                    } else if ($jt->id_akun == 64 && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $grand_total;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                        }
                    } else if ($jt->id_akun == 64 && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $grand_total;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                        }
                    } else if ($akun->nama_akun == 'PPN Masukan' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $pajak;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $pajak;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $pajak;
                        }
                    } else if ($akun->nama_akun == 'PPN Masukan' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $pajak;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun - $pajak;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun + $pajak;
                        }
                    } else if ($akun->nama_akun == 'Piutang Pengiriman' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model->ongkir;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $model->ongkir;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model->ongkir;
                        }
                    } else if ($akun->nama_akun == 'Piutang Pengiriman' && $jt->tipe == 'K') {
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
                    } else if ($akun->nama_akun == 'Uang Muka Pembelian' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $model->uang_muka;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model->uang_muka;
                        }
                    } else if ($akun->nama_akun == 'Uang Muka Pembelian' && $jt->tipe == 'K') {
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
                    $jurnal_umum_detail->keterangan = 'Order Pembelian : ' .  $model->no_order_pembelian;
                    $jurnal_umum_detail->save(false);

                    if ($akun->nama_akun == 'kas') {
                        $history_transaksi_kas = new AktHistoryTransaksi();
                        $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                        $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                        $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                        $history_transaksi_kas->save(false);
                    }
                }
            } else if ($model->jenis_bayar == 1) {
                $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembelian Cash'])->one();
                $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();

                foreach ($jurnal_transaksi_detail as $jt) {
                    $jurnal_umum_detail = new AktJurnalUmumDetail();
                    $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                    $jurnal_umum_detail->id_akun = $jt->id_akun;
                    $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
                    if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $pembelian_barang;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $pembelian_barang;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $pembelian_barang;
                        }
                    } else if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $pembelian_barang;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun - $pembelian_barang;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun + $pembelian_barang;
                        }
                    } else if ($jt->id_akun == 64 && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $grand_total;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                        }
                    } else if ($jt->id_akun == 64 && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $grand_total;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun - $grand_total;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun + $grand_total;
                        }
                    } else if ($akun->nama_akun == 'PPN Masukan' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $pajak;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $pajak;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $pajak;
                        }
                    } else if ($akun->nama_akun == 'PPN Masukan' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $pajak;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun - $pajak;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun + $pajak;
                        }
                    } else if ($akun->nama_akun == 'Piutang Pengiriman' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model->ongkir;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $model->ongkir;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model->ongkir;
                        }
                    } else if ($akun->nama_akun == 'Piutang Pengiriman' && $jt->tipe == 'K') {
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
                    } else if ($akun->nama_akun == 'Uang Muka Pembelian' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $model->uang_muka;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model->uang_muka;
                        }
                    } else  if ($akun->nama_akun == 'Uang Muka Pembelian' && $jt->tipe == 'K') {
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
                    $jurnal_umum_detail->keterangan = 'Order Pembelian : ' .  $model->no_order_pembelian;
                    $jurnal_umum_detail->save(false);

                    if ($akun->nama_akun == 'kas' && $model->id_kas_bank != null) {
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

    public function createJurnalUmum()
    {
    }
}
