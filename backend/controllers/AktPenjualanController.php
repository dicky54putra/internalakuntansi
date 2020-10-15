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

        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty", "akt_satuan.nama_satuan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
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
        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
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

        $akt_order_penjualan = AktPenjualan::find()->select(["no_order_penjualan"])->orderBy("id_penjualan DESC")->limit(1)->one();
        if (!empty($akt_order_penjualan->no_order_penjualan)) {
            # code...
            $no_bulan = substr($akt_order_penjualan->no_order_penjualan, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_order_penjualan->no_order_penjualan, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_order_penjualan = 'OP' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_order_penjualan = 'OP' . date('ym') . '001';
            }
        } else {
            # code...
            $no_order_penjualan = 'OP' . date('ym') . '001';
        }

        $model->no_order_penjualan = $no_order_penjualan;

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

        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
            }
        );

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

    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     $model_new_customer = new AktMitraBisnis();
    //     $model_new_sales = new AktSales();

    //     $data_customer = ArrayHelper::map(
    //         AktMitraBisnis::find()
    //             ->where(["!=", 'tipe_mitra_bisnis', 2])
    //             ->all(),
    //         'id_mitra_bisnis',
    //         function ($model) {
    //             return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
    //         }
    //     );
    //     $data_sales = ArrayHelper::map(
    //         AktSales::find()
    //             ->where(["=", 'status_aktif', 1])
    //             ->all(),
    //         'id_sales',
    //         function ($model) {
    //             return $model['kode_sales'] . ' - ' . $model['nama_sales'];
    //         }
    //     );
    //     $data_mata_uang = ArrayHelper::map(
    //         AktMataUang::find()
    //             ->where(["=", 'status_default', 1])
    //             ->all(),
    //         'id_mata_uang',
    //         function ($model) {
    //             return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
    //         }
    //     );

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {

    //         Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Order Penjualan Berhasil Disimpan']]);
    //         return $this->redirect(['view', 'id' => $model->id_penjualan]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //         'data_customer' => $data_customer,
    //         'data_sales' => $data_sales,
    //         'data_mata_uang' => $data_mata_uang,
    //         'model_new_customer' => $model_new_customer,
    //         'model_new_sales' => $model_new_sales,
    //     ]);
    // }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        AktPenjualanDetail::deleteAll(['id_penjualan' => $model->id_penjualan]);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Order Penjualan ' . $model->no_order_penjualan . ' Berhasil Dihapus']]);

        return $this->redirect(['index']);
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
        if ($model->jenis_bayar == 1) {
            # code...
            $model->jumlah_tempo = NULL;
            $model->tanggal_tempo = NULL;
        } elseif ($model->jenis_bayar == 2) {
            # code...
            $tanggal_tempo = date('Y-m-d', strtotime('+' . $model->jumlah_tempo . ' days', strtotime($model->tanggal_penjualan)));
            $model->tanggal_tempo = $tanggal_tempo;
        }
        $model->save(FALSE);

        // Wisnu - Autocreate jurnal umum

        // Create Jurnal Umum
        $jurnal_umum = new AktJurnalUmum();
        $akt_jurnal_umum = AktJurnalUmum::find()->select(["no_jurnal_umum"])->orderBy("id_jurnal_umum DESC")->limit(1)->one();
        if (!empty($akt_jurnal_umum->no_jurnal_umum)) {

            $no_bulan = substr($akt_jurnal_umum->no_jurnal_umum, 2, 4);

            if ($no_bulan == date('ym')) {

                $noUrut = substr($akt_jurnal_umum->no_jurnal_umum, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_jurnal_umum = 'JU' . date('ym') . $noUrut_2;
            } else {

                $no_jurnal_umum = 'JU' . date('ym') . '001';
            }
        } else {

            $no_jurnal_umum = 'JU' . date('ym') . '001';
        }

        $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
        $jurnal_umum->tipe = 1;
        $jurnal_umum->tanggal = date('Y-m-d');
        $jurnal_umum->keterangan = 'Order Penjualan : ' .  $model->no_order_penjualan;
        $jurnal_umum->save(false);

        // End Create Jurnal Umum
        $_grandTotal = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_penjualan_detail WHERE id_penjualan = '$model->id_penjualan'")->queryScalar();

        $diskon = $model->diskon / 100 * $_grandTotal;

        $pajak = 0;
        $diskon = $model->diskon / 100 * $_grandTotal;
        $total_penjualan = $_grandTotal - $diskon;
        if ($model->pajak == 1) {
            $pajak = 0.1 * $total_penjualan;
        } else {
            $pajak = 0;
        }
        $grandTotal = $total_penjualan + $model->materai + $pajak + $model->materai  + $model->ongkir;

        if ($model->jenis_bayar == 2) {
            // Data for debit or credit in jurnal transaksi
            $penjualanKredit = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Kredit'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $penjualanKredit['id_jurnal_transaksi']])->all();
            foreach ($jurnal_transaksi_detail as $jt) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
                if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $total_penjualan;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $total_penjualan;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $total_penjualan;
                    }
                } else if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $total_penjualan;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $total_penjualan;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $total_penjualan;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $grandTotal;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $grandTotal;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $grandTotal;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $grandTotal;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $grandTotal;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $grandTotal;
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
                        $akt_kas_bank->save(false);
                    } else if ($akun->nama_akun == 'kas' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                        }
                        $akt_kas_bank->save(false);
                    }
                }
                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Order Penjualan : ' .  $model->no_order_penjualan;
                $jurnal_umum_detail->save(false);

                if ($akun->nama_akun == 'kas') {
                    $history_transaksi_kas = new AktHistoryTransaksi();
                    $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                    $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                    $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                    $history_transaksi_kas->save(false);
                }
            }
        } elseif ($model->jenis_bayar == 1) {
            // Data for debit or credit in jurnal transaksi
            $penjualan_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penjualan Cash'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $penjualan_cash['id_jurnal_transaksi']])->all();
            foreach ($jurnal_transaksi_detail as $jt) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
                if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $total_penjualan;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $total_penjualan;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $total_penjualan;
                    }
                } else if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $total_penjualan;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $total_penjualan;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $total_penjualan;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $grandTotal;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $grandTotal;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $grandTotal;
                    }
                } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $grandTotal;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $grandTotal;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $grandTotal;
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
                        $akt_kas_bank->save(false);
                    } else if ($akun->nama_akun == 'kas' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $model->uang_muka;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                        }
                        $akt_kas_bank->save(false);
                    }
                }
                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Order Penjualan : ' .  $model->no_order_penjualan;
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
        $model->tanggal_tempo = NULL;
        $model->save(FALSE);

        // Delete history transaksi, jurnal umum, jurnal umum detail, and update saldo.
        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penjualan'])->count();

        if ($history_transaksi_count > 0) {
            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penjualan'])->one();
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi->id_jurnal_umum])->one();
            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum->id_jurnal_umum])->all();
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

        if (!empty($id)) {
            # code...
            return $this->redirect(['view', 'id' => $id]);
        } else {
            # code...
            return $this->redirect(['create']);
        }
    }

    public function actionUpdateFromModal($id)
    {
        $post_total_penjualan_detail = Yii::$app->request->post('total_penjualan_detail');
        $total_penjualan_detail = preg_replace('/\D/', '', $post_total_penjualan_detail);
        $model_no_order_penjualan = Yii::$app->request->post('AktPenjualan')['no_order_penjualan'];
        $model_tanggal_order_penjualan = Yii::$app->request->post('AktPenjualan')['tanggal_order_penjualan'];
        $model_id_customer = Yii::$app->request->post('AktPenjualan')['id_customer'];
        $model_id_sales = Yii::$app->request->post('AktPenjualan')['id_sales'];
        $model_id_mata_uang = Yii::$app->request->post('AktPenjualan')['id_mata_uang'];
        $model_ongkir = Yii::$app->request->post('AktPenjualan')['ongkir'];
        $model_materai = Yii::$app->request->post('AktPenjualan')['materai'];
        $model_pajak = Yii::$app->request->post('AktPenjualan')['pajak'];
        $model_diskon = Yii::$app->request->post('AktPenjualan')['diskon'];
        $model_jenis_bayar = Yii::$app->request->post('AktPenjualan')['jenis_bayar'];
        $model_jumlah_tempo = Yii::$app->request->post('AktPenjualan')['jumlah_tempo'];
        $model_uang_muka = preg_replace("/[^a-zA-Z0-9]/", "", Yii::$app->request->post('AktPenjualan')['uang_muka']);
        $model_id_kas_bank = Yii::$app->request->post('AktPenjualan')['id_kas_bank'];
        $model_tanggal_estimasi = Yii::$app->request->post('AktPenjualan')['tanggal_estimasi'];

        // var_d

        $diskon = ($model_diskon > 0) ? ($model_diskon * $total_penjualan_detail) / 100 : 0;
        $pajak = ($model_pajak == 1) ? (($total_penjualan_detail - $diskon) * 10) / 100 : 0;
        $model_total_sementara = (($total_penjualan_detail - $diskon) + $pajak) + $model_ongkir + $model_materai;
        $model_total = $model_total_sementara - $model_uang_muka;

        $model = $this->findModel($id);
        $model->no_order_penjualan = $model_no_order_penjualan;
        $model->tanggal_order_penjualan = $model_tanggal_order_penjualan;
        $model->id_customer = $model_id_customer;
        $model->id_sales = $model_id_sales;
        $model->id_mata_uang = $model_id_mata_uang;
        $model->ongkir = $model_ongkir;
        $model->materai = $model_materai;
        $model->pajak = $model_pajak;
        $model->diskon = $model_diskon;
        $model->uang_muka = $model_uang_muka;
        $model->id_kas_bank = $model_id_kas_bank;
        $model->tanggal_estimasi = $model_tanggal_estimasi;
        $model->total = $model_total;

        if ($model_jenis_bayar == 1) {
            # code...
            $model->jenis_bayar = 1;
            $model->jumlah_tempo = NULL;
            $model->tanggal_tempo = NULL;
        } elseif ($model_jenis_bayar == 2) {
            # code...
            $model->jenis_bayar = 2;
            $model->jumlah_tempo = $model_jumlah_tempo;
        }

        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Berhasil Di Simpan']]);

        return $this->redirect(['view', 'id' => $id]);
    }
}
