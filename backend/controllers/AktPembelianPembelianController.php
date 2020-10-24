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
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use backend\models\AktItemStok;
use backend\models\AktSatuan;
use yii\helpers\ArrayHelper;

use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktHistoryTransaksi;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktJurnalUmumDetail;

use backend\models\ItemPembelian;
use backend\models\Foto;
use backend\models\AktPembelianDetail;
use backend\models\Setting;

/**
 * AktpembelianController implements the CRUD actions for Aktpembelian model.
 */
class AktPembelianPembelianController extends Controller
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
     * Lists all Aktpembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianSearch();
        $dataProvider = $searchModel->searchPembelian(Yii::$app->request->queryParams);
        $is_pembelian = AktPembelian::cekButtonPembelian();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'is_pembelian' => $is_pembelian

        ]);
    }

    /**
     * Displays a single Aktpembelian model
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

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
        $model_pembelian_detail = $query->sum('total');
        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id'), '#' => 'unggah-dokumen']);
        }

        $foto = Foto::find()->where(["id_tabel" => $model->id_pembelian, "nama_tabel" => "pembelian"])->all();

        if (Yii::$app->request->get('aksi') == "faktur") {

            $akt_pembelian_faktur = AktPembelian::find()->where(['id_pembelian' => Yii::$app->request->get('id')])->one();
            $akt_pembelian_faktur->no_faktur_pembelian = Yii::$app->request->post('no_faktur_pembelian');
            $akt_pembelian_faktur->tanggal_faktur_pembelian = Yii::$app->request->post('tanggal_faktur_pembelian');
            $akt_pembelian_faktur->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'No. Faktur Berhasil Di Simpan']]);
            return $this->redirect(['view', 'id' => $id, '#' => 'faktur']);
        }

        # form modal input barang
        $model_pembelian_detail_baru = new AktPembelianDetail();
        $model_pembelian_detail_baru->id_pembelian = $model->id_pembelian;
        $model_pembelian_detail_baru->diskon = 0;

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

        # untuk tombol penerimaan klo data pembelian belom di update belom bisa melakukan penerimaan
        $count_model_no_pembelian = ($model->no_pembelian == NULL) ? 1 : 0;
        $count_model_tanggal_pembelian = ($model->tanggal_pembelian == NULL) ? 1 : 0;
        // $count_model_ongkir = ($model->ongkir == NULL) ? 1 : 0 ;
        // $count_model_pajak = ($model->pajak == NULL) ? 1 : 0 ;
        $count_model_total = ($model->total == NULL) ? 1 : 0;
        // $count_model_diskon = ($model->diskon == NULL) ? 1 : 0 ;
        $count_model_jenis_bayar = ($model->jenis_bayar == 1) ? 0 : $retVal = ($model->jenis_bayar == 2 && $model->tanggal_tempo != NULL && $model->jatuh_tempo != NULL) ? 0 : 1;
        // $count_model_materai = ($model->materai == NULL) ? 1 : 0 ;
        $count_model_id_penagih = ($model->id_penagih == NULL) ? 1 : 0;
        $count_model_no_faktur_pembelian = ($model->no_faktur_pembelian == NULL) ? 1 : 0;
        $count_model_tanggal_faktur_pembelian = ($model->tanggal_faktur_pembelian == NULL) ? 1 : 0;
        $count_data_pembelian_count = $count_model_no_pembelian + $count_model_tanggal_pembelian + 0 + 0 + $count_model_total + 0 + $count_model_jenis_bayar + 0 + $count_model_id_penagih;
        // + $count_model_no_faktur_pembelian + $count_model_tanggal_faktur_pembelian;

        $is_pembelian = AktPembelian::cekButtonPembelian();
        $data_customer = AktPembelian::dataCustomer();
        $data_mata_uang = AktPembelian::dataMataUang();
        $data_kas_bank = AktPembelian::dataKasBank();


        return $this->render('view', [
            'model' => $model,
            'foto' => $foto,
            'model_pembelian_detail' => $model_pembelian_detail,
            'data_customer' => $data_customer,
            'data_kas_bank' => $data_kas_bank,
            'data_mata_uang' => $data_mata_uang,
            'is_pembelian' => $is_pembelian,
            'model_pembelian_detail_baru' => $model_pembelian_detail_baru,
            'data_item_stok' => $data_item_stok,
            'count_data_pembelian_count' => $count_data_pembelian_count,
        ]);
    }

    public function actionPenerimaan($id)
    {
        $model = $this->findModel($id);
        $model->status = 5;

        $model->save(FALSE);
        return $this->redirect(['akt-pembelian-penerimaan-sendiri/view', 'id' => $model->id_pembelian]);
    }

    public function actionUpload()
    {
        $model = new Foto();

        if (Yii::$app->request->isPost) {

            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');
            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel'), '#' => 'unggah-dokumen']);
        } else {
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel'), '#' => 'unggah-dokumen']);
        }
    }


    protected function findModel($id)
    {
        if (($model = AktPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateDataPembelian($id)
    {

        $model = AktPembelian::findOne($id);
        $query = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
        $model_pembelian_detail = $query->sum('total');


        if ($model->load(Yii::$app->request->post())) {

            $model->ongkir = $model->ongkir == '' ? 0 : $model->ongkir;
            $model->diskon = $model->diskon == '' ? 0 : $model->diskon;
            $model->materai = $model->materai == '' ? 0 : $model->materai;

            $model_ongkir = Yii::$app->request->post('AktPembelian')['ongkir'];

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

            $model->save();

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
            $jurnal_umum->keterangan = 'Pembelian : ' .  $model->no_pembelian;
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
                    $jurnal_umum_detail->keterangan = 'Pembelian : ' .  $model->no_pembelian;
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
                    $jurnal_umum_detail->keterangan = 'Pembelian : ' .  $model->no_pembelian;
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
        }

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Perubahan Data Pembelian Berhasil Di Simpan']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian]);
    }

    public function actionHapusDataPembelian($id)
    {

        $model = $this->findModel($id);
        $model->jenis_bayar = null;
        $model->ongkir = 0;
        $model->diskon = 0;
        $model->pajak = 0;
        $model->uang_muka = 0;
        $model->materai = 0;
        $model->id_kas_bank = null;
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



        Yii::$app->session->setFlash('success', [['Berhasil!', 'Data Pembelian Berhasil Dihapus!']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian]);
    }

    public function actionGetTanggal($id)
    {
        $h = AktPembelian::find()->where(['id_pembelian' => $id])->asArray()->one();
        return json_encode($h);
    }


    public function actionCreate()
    {
        $model = new AktPembelian();

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_pembelian FROM `akt_pembelian` ORDER by no_pembelian DESC LIMIT 1")->queryScalar();

        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            // echo $noUrut; die;
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'PE' . date('ym') . '001';
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

                $no_order_pembelian = "PE" . date('ym') . $noUrut_2;
                $kode = $no_order_pembelian;
            }
        } else {
            # code...
            $kode = 'PE' . date('ym') . '001';
        }

        $model->no_pembelian = $kode;
        $model->no_penerimaan = substr_replace($kode, "PQ", 0, 2);

        $data_customer = AktPembelian::dataCustomer();
        $data_mata_uang = AktPembelian::dataMataUang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $kode,
            'data_customer' => $data_customer,
            'data_mata_uang' => $data_mata_uang,
        ]);
    }
}
