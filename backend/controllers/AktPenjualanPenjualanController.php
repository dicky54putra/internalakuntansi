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
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktAkun;
use backend\models\AktPenjualanPengiriman;

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

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $model->id_penjualan, "nama_tabel" => "penjualan"])->all();

        # form modal input barang
        $model_penjualan_detail_baru = new AktPenjualanDetail();
        $model_penjualan_detail_baru->id_penjualan = $model->id_penjualan;
        $model_penjualan_detail_baru->diskon = 0;

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

        # untuk tombol pengiriman klo data penjualan belom di update belom bisa melakukan pengiriman
        $count_model_no_penjualan = ($model->no_penjualan == NULL) ? 1 : 0;
        $count_model_tanggal_penjualan = ($model->tanggal_penjualan == NULL) ? 1 : 0;
        $count_model_total = ($model->total == NULL) ? 1 : 0;
        $count_model_jenis_bayar = ($model->jenis_bayar == 1) ? 0 : $retVal = ($model->jenis_bayar == 2 && $model->tanggal_tempo != NULL && $model->jumlah_tempo != NULL) ? 0 : 1;
        $count_data_penjualan_count = $count_model_no_penjualan + $count_model_tanggal_penjualan + $count_model_total + $count_model_jenis_bayar;

        return $this->render('view', [
            'model' => $model,
            'foto' => $foto,
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

    public function actionSimpanGrandTotal($id, $grand_total)
    {
        $model = $this->findModel($id);
        $model->total = $grand_total;
        $model->kekurangan = $model->bayar - $model->total;
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Di Simpan']]);
        return $this->redirect(['akt-penjualan-penjualan/view', 'id' => $model->id_penjualan]);
    }

    protected function findModel($id)
    {
        if (($model = AktPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateDataPenjualan($id)
    {
        $model = $this->findModel($id);
        $model->ongkir = ($model->ongkir == NULL) ? 0 : $model->ongkir;
        $model->diskon = ($model->diskon == NULL) ? 0 : $model->diskon;
        $model->materai = ($model->materai == NULL) ? 0 : $model->materai;

        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $model_penjualan_detail = $query->sum('total');

        $model->total = ($model->total == NULL) ? $model_penjualan_detail : $model->total;

        if ($model->load(Yii::$app->request->post())) {

            #perhitungan untuk grand total
            $model_ongkir = Yii::$app->request->post('AktPenjualan')['ongkir'];
            $model_materai = Yii::$app->request->post('AktPenjualan')['materai'];
            // $model_total = Yii::$app->request->post('AktPenjualan')['total'];

            $diskon = ($model->diskon > 0) ? ($model->diskon * $model_penjualan_detail) / 100 : 0;
            $pajak = ($model->pajak == 1) ? (($model_penjualan_detail - $diskon) * 10) / 100 : 0;
            $model_total = (($model_penjualan_detail - $diskon) + $pajak) + $model_ongkir + $model_materai;

            $model->ongkir = $model_ongkir;
            $model->total = $model_total;

            if ($model->jenis_bayar == 1) {
                # code...
                $model->jumlah_tempo = NULL;
                $model->tanggal_tempo = NULL;
            } elseif ($model->jenis_bayar == 2 && $model->jumlah_tempo != NULL) {
                # code...
                $tanggal_tempo = date('Y-m-d', strtotime('+' . $model->jumlah_tempo . ' days', strtotime($model->tanggal_penjualan)));
                $model->tanggal_tempo = $tanggal_tempo;
            } elseif ($model->jenis_bayar == 2 && $model->jumlah_tempo == NULL) {
                # code...
                $model->tanggal_tempo = NULL;
            }

            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Penjualan Berhasil Di Simpan']]);
            return $this->redirect(['view', 'id' => $model->id_penjualan]);
        }

        return $this->render('update_data_penjualan', [
            'model' => $model,
            'model_penjualan_detail' => $model_penjualan_detail,
        ]);
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

        if ($model->jenis_bayar == 2) {

            // membuat jurnal umum
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
            $jurnal_umum->tanggal = date('Y-m-d');
            $jurnal_umum->tipe = 1;

            $jurnal_umum->save(false);

            // Create Jurnal Umum detail
            $jurnal_transaksi = JurnalTransaksiDetail::find()->innerJoin('jurnal_transaksi', 'jurnal_transaksi_detail.id_jurnal_transaksi = jurnal_transaksi.id_jurnal_transaksi')->where(['nama_transaksi' => 'Penjualan Kredit'])->all();
            // var_dump($jurnal_transaksi);

            foreach ($jurnal_transaksi as $k) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $akun = AktAkun::findOne($k->id_akun);
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $k->id_akun;

                // var_dump($k->tipe);
                // var_dump($k->id_akun);
                if ($k->tipe == 'K') {
                    if ($akun->saldo_normal == 1) {
                        if ($akun->saldo_akun < $model->total) {
                            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak bisa menambah jurnal umum, karena saldo tidak mencukupi.']]);
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model->total;
                            $jurnal_umum_detail->kredit =  $model->total;
                            $jurnal_umum_detail->debit =  0;
                        }
                    } else if ($akun->saldo_normal == 2) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->total;
                        $jurnal_umum_detail->kredit =  $model->total;
                        $jurnal_umum_detail->debit =  0;
                    }
                } else if ($k->tipe == 'D') {
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->total;
                        $jurnal_umum_detail->debit =  $model->total;
                        $jurnal_umum_detail->kredit =  0;
                    } else if ($akun->saldo_normal == 2) {
                        if ($akun->saldo_akun < $model->total) {
                            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak bisa menambah jurnal umum, karena saldo tidak mencukupi.']]);
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model->total;
                            $jurnal_umum_detail->debit =  $model->total;
                            $jurnal_umum_detail->kredit =  0;
                        }
                    }
                }
                $akun->save(false);
                $jurnal_umum_detail->save(false);
            }
        }

        // die;
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Data Berhasil di Simpan, Silahkan Menuju Menu Pengiriman']]);

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
}
