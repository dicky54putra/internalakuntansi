<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembayaranBiaya;
use backend\models\AktPembelianHartaTetapDetail;
use backend\models\AktPembayaranBiayaSearch;
use backend\models\AktPembelianHartaTetapSearch;
use backend\models\AktPembelian;
use backend\models\AktReturPembelian;
use backend\models\JurnalTransaksi;
use backend\models\AktHistoryTransaksi;
use backend\models\AktPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AktKasBank;
use backend\models\Setting;
use backend\models\AktJurnalUmum;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktAkun;
use backend\models\AktHartaTetap;
use backend\models\AktPembayaranBiayaHartaTetap;
use backend\models\AktPembelianHartaTetap;
use yii\helpers\Json;

/**
 * AktPembayaranBiayaController implements the CRUD actions for AktPembayaranBiaya model.
 */
class AktPembayaranBiayaController extends Controller
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
     * Lists all AktPembayaranBiaya models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianSearch();
        $dataProvider = $searchModel->searchPembayaranBiaya(Yii::$app->request->queryParams);
        $searchModel2 = new AktPembelianHartaTetapSearch();
        $dataProvider2 = $searchModel2->searchPembayaranBiaya(Yii::$app->request->queryParams);

        return $this->render('index_pembayaran_biaya', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionViewPembayaranBiaya($id)
    {
        $model = AktPembelian::findOne($id);

        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'];
            }
        );

        $model_pembayaran_biaya = new AktPembayaranBiaya();
        $model_pembayaran_biaya->tanggal_pembayaran_biaya = date('Y-m-d');
        $model_pembayaran_biaya->id_pembelian = $model->id_pembelian;

        $query = (new \yii\db\Query())->from('akt_pembayaran_biaya')->where(['id_pembelian' => $model->id_pembelian]);
        $sum_nominal = $query->sum('nominal');

        return $this->render('view_pembayaran_biaya', [
            'model' => $model,
            'data_kas_bank' => $data_kas_bank,
            'model_pembayaran_biaya' => $model_pembayaran_biaya,
            'sum_nominal' => $sum_nominal,
        ]);
    }

    public function actionViewPembayaranBiayaHartaTetap($id)
    {
        $model = AktPembelianHartaTetap::findOne($id);

        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'];
            }
        );

        $model_pembayaran_biaya = new AktPembayaranBiayaHartaTetap();
        $model_pembayaran_biaya->tanggal_pembayaran_biaya = date('Y-m-d');
        $model_pembayaran_biaya->id_pembelian_harta_tetap = $model->id_pembelian_harta_tetap;

        // $query = (new \yii\db\Query())->from('akt_pembayaran_biaya')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
        // $sum_nominal = $query->sum('nominal');

        return $this->render('view_pembayaran_biaya_harta_tetap', [
            'model' => $model,
            'data_kas_bank' => $data_kas_bank,
            'model_pembayaran_biaya' => $model_pembayaran_biaya,
            // 'sum_nominal' => $sum_nominal,
        ]);
    }

    /**
     * Displays a single AktPembayaranBiaya model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AktPembayaranBiaya model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPembayaranBiaya();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembayaran_biaya]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPembayaranBiaya model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembayaran_biaya]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCreateFromView()
    {
        $model = new AktPembayaranBiaya();
        $model_tanggal_pembayaran_biaya = Yii::$app->request->post('AktPembayaranBiaya')['tanggal_pembayaran_biaya'];
        $model_id_pembelian = Yii::$app->request->post('AktPembayaranBiaya')['id_pembelian'];
        $model_cara_bayar = Yii::$app->request->post('AktPembayaranBiaya')['cara_bayar'];
        $model_id_kas_bank = Yii::$app->request->post('AktPembayaranBiaya')['id_kas_bank'];
        $model_nominal = Yii::$app->request->post('AktPembayaranBiaya')['nominal'];
        $model_keterangan = Yii::$app->request->post('AktPembayaranBiaya')['keterangan'];
        $total = Yii::$app->db->createCommand("SELECT total from akt_pembelian where id_pembelian = '$model_id_pembelian'")->queryScalar();
        $nominal = Yii::$app->db->createCommand("SELECT nominal from akt_pembayaran_biaya where id_pembelian = '$model_id_pembelian'")->queryScalar();
        $sisa = $total - $nominal;

        $akt_pembelian = AktPembelian::findOne($model_id_pembelian);
        $pembelian_detail = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_pembelian_detail WHERE id_pembelian = '$model_id_pembelian'")->queryScalar();

        $pajak = 0;
        $diskon = $akt_pembelian->diskon / 100 * $pembelian_detail;
        if ($akt_pembelian->pajak == 1) {
            $total_pembelian = $pembelian_detail - $diskon;
            $pajak = 0.1 * $total_pembelian;
        }
        $pembelian_barang = $pembelian_detail - $diskon;
        // $grand_total = $pembelian_barang + $pajak + $akt_pembelian->ongkir;

        if ($model_nominal > $sisa) {
            Yii::$app->session->setFlash('danger', [['Perhatian !', 'Nominal yang diinputkan melebihi total yang belum dibayar!']]);
            return $this->redirect(['view-pembayaran-biaya', 'id' => $model_id_pembelian]);
        } else if ($model_nominal <= $sisa) {
            $model->tanggal_pembayaran_biaya = $model_tanggal_pembayaran_biaya;
            $model->id_pembelian = $model_id_pembelian;
            $model->cara_bayar = $model_cara_bayar;
            $model->id_kas_bank = $model_id_kas_bank;
            $model->nominal =  $model_nominal + $akt_pembelian['uang_muka'];

            $model->keterangan = $model_keterangan;
            $cek_kas = AktKasBank::find()->where(['id_kas_bank' => $model_id_kas_bank])->one();
            if ($cek_kas->saldo < $model_nominal) {
                Yii::$app->session->setFlash('danger', [['Perhatian !', 'Nominal yang diinputkan melebihi saldo kas yang dimiliki!']]);
            } else if ($cek_kas->saldo >= $model_nominal) {
                $model->save(FALSE);

                // Create jurnal umum

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
                $jurnal_umum->keterangan = 'Pembayaran Biaya : ' . $akt_pembelian->no_pembelian;
                $jurnal_umum->save(false);
                // End create jurnal umum
                // Create Jurnal Umum detail

                $pembayaran_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembayaran Transaksi Cash'])->one();
                $pembayaran_kredit = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembayaran Transaksi Kredit'])->one();

                if ($akt_pembelian->jenis_bayar == 1) {
                    $jurnal_transaksi = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembayaran_cash['id_jurnal_transaksi']])->all();
                    foreach ($jurnal_transaksi as $jurnal) {
                        $jurnal_umum_detail = new AktJurnalUmumDetail();
                        $akun = AktAkun::findOne($jurnal->id_akun);
                        $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                        $jurnal_umum_detail->id_akun = $jurnal->id_akun;
                        if ($jurnal->id_akun == 64 && $jurnal->tipe == 'D') {
                            $jurnal_umum_detail->debit = $model_nominal;
                            if ($akun->saldo_normal == 1) {
                                $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                            } else {
                                $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                            }
                        } else if ($jurnal->id_akun == 64 && $jurnal->tipe == 'K') {
                            $jurnal_umum_detail->kredit = $model_nominal;
                            if ($akun->saldo_normal == 1) {

                                $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                            } else {
                                $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                            }
                        } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'D') {
                            $jurnal_umum_detail->debit = $model_nominal;
                            if ($akun->saldo_normal == 1) {
                                $cek_kas->saldo = $cek_kas->saldo + $model_nominal;
                            } else {
                                $cek_kas->saldo = $cek_kas->saldo - $model_nominal;
                            }
                        } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'K') {
                            $jurnal_umum_detail->kredit = $model_nominal;
                            if ($akun->saldo_normal == 1) {
                                $cek_kas->saldo = $cek_kas->saldo - $model_nominal;
                            } else {
                                $cek_kas->saldo = $cek_kas->saldo + $model_nominal;
                            }
                        }
                        $jurnal_umum_detail->keterangan = 'Pembayaran Biaya Cash: ' . $akt_pembelian->no_pembelian;
                        $akun->save(false);
                        $jurnal_umum_detail->save(false);
                        $cek_kas->save(false);
                        if ($akun->nama_akun == 'kas') {
                            $history_transaksi2 = new AktHistoryTransaksi();
                            $history_transaksi2->nama_tabel = 'akt_kas_bank';
                            $history_transaksi2->id_tabel = $model_id_kas_bank;
                            $history_transaksi2->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                            $history_transaksi2->save(false);
                        }
                    }
                } else if ($akt_pembelian->jenis_bayar == 2) {
                    $jurnal_transaksi = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembayaran_kredit['id_jurnal_transaksi']])->all();
                    foreach ($jurnal_transaksi as $jurnal) {
                        $jurnal_umum_detail = new AktJurnalUmumDetail();
                        $akun = AktAkun::findOne($jurnal->id_akun);
                        $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                        $jurnal_umum_detail->id_akun = $jurnal->id_akun;
                        if ($jurnal->id_akun == 64 && $jurnal->tipe == 'D') {
                            $jurnal_umum_detail->debit = $model_nominal;
                            if ($akun->saldo_normal == 1) {
                                $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                            } else {
                                $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                            }
                        } else if ($jurnal->id_akun == 64 && $jurnal->tipe == 'K') {
                            $jurnal_umum_detail->kredit = $model_nominal;
                            if ($akun->saldo_normal == 1) {

                                $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                            } else {
                                $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                            }
                        } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'D') {
                            $jurnal_umum_detail->debit = $model_nominal;
                            if ($akun->saldo_normal == 1) {
                                $cek_kas->saldo = $cek_kas->saldo + $model_nominal;
                            } else {
                                $cek_kas->saldo = $cek_kas->saldo - $model_nominal;
                            }
                        } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'K') {
                            $jurnal_umum_detail->kredit = $model_nominal;
                            if ($akun->saldo_normal == 1) {
                                $cek_kas->saldo = $cek_kas->saldo - $model_nominal;
                            } else {
                                $cek_kas->saldo = $cek_kas->saldo + $model_nominal;
                            }
                        }
                        $jurnal_umum_detail->keterangan = 'Pembayaran Biaya Kredit : ' . $akt_pembelian->no_pembelian;
                        $akun->save(false);
                        $cek_kas->save(false);
                        $jurnal_umum_detail->save(false);

                        if ($akun->nama_akun == 'kas') {
                            $history_transaksi3 = new AktHistoryTransaksi();
                            $history_transaksi3->nama_tabel = 'akt_kas_bank';
                            $history_transaksi3->id_tabel = $model_id_kas_bank;
                            $history_transaksi3->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                            $history_transaksi3->save(false);
                        }
                    }
                }


                $history_transaksi = new AktHistoryTransaksi();
                $history_transaksi->nama_tabel = 'akt_pembayaran_biaya';
                $history_transaksi->id_tabel = $model->id_pembayaran_biaya;
                $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $history_transaksi->save(false);

                // End Create Jurnal Umum Detail

            }
            return $this->redirect(['view-pembayaran-biaya', 'id' => $model->id_pembelian]);
        }

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Tersimpan Didata Pembayaran Biaya']]);
        return $this->redirect(['view-pembayaran-biaya', 'id' => $model->id_pembelian]);
    }

    public function actionCreateHartaTetapFromView()
    {
        $model = new AktPembayaranBiayaHartaTetap();
        if ($model->load(Yii::$app->request->post())) {
            // $model->save();
            // Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Tersimpan Didata Pembayaran Biaya']]);
            $query = (new \yii\db\Query())->from('akt_pembayaran_biaya_harta_tetap')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
            $sum_nominal = $query->sum('nominal');
            $harta_tetap = AktPembelianHartaTetap::findOne($model->id_pembelian_harta_tetap);
            $harta_tetap_detail = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->sum('harga');
            $total = $harta_tetap_detail + $harta_tetap->uang_muka;
            // $nominal = Yii::$app->db->createCommand("SELECT nominal from akt_pembayaran_biaya_harta_tetap where id_pembelian_harta_tetap = '$model->id_pembelian_harta_tetap'")->queryScalar();
            $nominal = $model->nominal;
            $total_ = 0;
            if ($sum_nominal != 0) {
                $total_ = $harta_tetap_detail;
                $sisa = $total_ - $sum_nominal;
            } else {
                $sisa =  $harta_tetap_detail;
            }
            // $sisa = $total - $nominal;
            // var_dump($sisa);
            // die;

            $pajak = 0;
            $diskon = $harta_tetap->diskon / 100 * $harta_tetap_detail;
            if ($harta_tetap->pajak == 1) {
                $total_pembelian = $harta_tetap_detail - $diskon;
                $pajak = 0.1 * $total_pembelian;
            }
            $pembelian_barang = $harta_tetap_detail - $diskon;
            $grand_total = $pembelian_barang + $pajak + $harta_tetap->ongkir;

            if ($model->nominal > $sisa) {
                Yii::$app->session->setFlash('danger', [['Perhatian !', 'Nominal yang diinputkan melebihi total yang belum dibayar!']]);
                return $this->redirect(['view-pembayaran-biaya-harta-tetap', 'id' => $model->id_pembelian_harta_tetap]);
            } else if ($model->nominal <= $sisa) {
                $cek = AktPembayaranBiayaHartaTetap::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->count();

                // if ($cek == 0) {
                //     $model->nominal = $model->nominal + $harta_tetap->uang_muka;
                // }

                $cek_kas = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();
                if ($cek_kas->saldo < $model->nominal) {
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Nominal yang diinputkan melebihi saldo kas yang dimiliki!']]);
                } else if ($cek_kas->saldo >= $model->nominal) {
                    Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Tersimpan Didata Pembayaran Biaya']]);
                    $model->save(FALSE);

                    // Create jurnal umum

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
                    $jurnal_umum->keterangan = 'Pembayaran Biaya : ' . $harta_tetap->no_pembelian_harta_tetap;

                    $jurnal_umum->save(false);

                    // End create jurnal umum
                    // Create Jurnal Umum detail

                    $pembayaran_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembayaran Transaksi Cash'])->one();
                    $pembayaran_kredit = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembayaran Transaksi Kredit'])->one();

                    if ($harta_tetap->jenis_bayar == 1) {
                        $jurnal_transaksi = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembayaran_cash['id_jurnal_transaksi']])->all();
                        foreach ($jurnal_transaksi as $jurnal) {
                            $jurnal_umum_detail = new AktJurnalUmumDetail();
                            $akun = AktAkun::findOne($jurnal->id_akun);
                            $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                            $jurnal_umum_detail->id_akun = $jurnal->id_akun;
                            if ($jurnal->id_akun == 64 && $jurnal->tipe == 'D') {
                                $jurnal_umum_detail->debit = $model->nominal;
                                if ($akun->saldo_normal == 1) {
                                    $akun->saldo_akun = $akun->saldo_akun + $model->nominal;
                                } else {
                                    $akun->saldo_akun = $akun->saldo_akun - $model->nominal;
                                }
                            } else if ($jurnal->id_akun == 64 && $jurnal->tipe == 'K') {
                                $jurnal_umum_detail->kredit = $model->nominal;
                                if ($akun->saldo_normal == 1) {

                                    $akun->saldo_akun = $akun->saldo_akun - $model->nominal;
                                } else {
                                    $akun->saldo_akun = $akun->saldo_akun + $model->nominal;
                                }
                            } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'D') {
                                $jurnal_umum_detail->debit = $model->nominal;
                                if ($akun->saldo_normal == 1) {
                                    $cek_kas->saldo = $cek_kas->saldo + $model->nominal;
                                } else {
                                    $cek_kas->saldo = $cek_kas->saldo - $model->nominal;
                                }
                            } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'K') {
                                $jurnal_umum_detail->kredit = $model->nominal;
                                if ($akun->saldo_normal == 1) {
                                    $cek_kas->saldo = $cek_kas->saldo - $model->nominal;
                                } else {
                                    $cek_kas->saldo = $cek_kas->saldo + $model->nominal;
                                }
                            }
                            $jurnal_umum_detail->keterangan = 'Pembayaran Biaya Cash: ' . $harta_tetap->no_pembelian_harta_tetap;
                            $akun->save(false);
                            $jurnal_umum_detail->save(false);
                            $cek_kas->save(false);
                            if ($akun->nama_akun == 'kas') {
                                $history_transaksi2 = new AktHistoryTransaksi();
                                $history_transaksi2->nama_tabel = 'akt_kas_bank';
                                $history_transaksi2->id_tabel = $model->id_kas_bank;
                                $history_transaksi2->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                                $history_transaksi2->save(false);
                            }
                        }
                    } else if ($harta_tetap->jenis_bayar == 2) {
                        $jurnal_transaksi = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembayaran_kredit['id_jurnal_transaksi']])->all();
                        foreach ($jurnal_transaksi as $jurnal) {
                            $jurnal_umum_detail = new AktJurnalUmumDetail();
                            $akun = AktAkun::findOne($jurnal->id_akun);
                            $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                            $jurnal_umum_detail->id_akun = $jurnal->id_akun;
                            if ($jurnal->id_akun == 64 && $jurnal->tipe == 'D') {
                                $jurnal_umum_detail->debit = $model->nominal;
                                if ($akun->saldo_normal == 1) {
                                    $akun->saldo_akun = $akun->saldo_akun + $model->nominal;
                                } else {
                                    $akun->saldo_akun = $akun->saldo_akun - $model->nominal;
                                }
                            } else if ($jurnal->id_akun == 64 && $jurnal->tipe == 'K') {
                                $jurnal_umum_detail->kredit = $model->nominal;
                                if ($akun->saldo_normal == 1) {

                                    $akun->saldo_akun = $akun->saldo_akun - $model->nominal;
                                } else {
                                    $akun->saldo_akun = $akun->saldo_akun + $model->nominal;
                                }
                            } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'D') {
                                $jurnal_umum_detail->debit = $model->nominal;
                                if ($akun->saldo_normal == 1) {
                                    $cek_kas->saldo = $cek_kas->saldo + $model->nominal;
                                } else {
                                    $cek_kas->saldo = $cek_kas->saldo - $model->nominal;
                                }
                            } else if ($akun->nama_akun == 'kas' && $jurnal->tipe == 'K') {
                                $jurnal_umum_detail->kredit = $model->nominal;
                                if ($akun->saldo_normal == 1) {
                                    $cek_kas->saldo = $cek_kas->saldo - $model->nominal;
                                } else {
                                    $cek_kas->saldo = $cek_kas->saldo + $model->nominal;
                                }
                            }
                            $jurnal_umum_detail->keterangan = 'Pembayaran Biaya Kredit : ' . $harta_tetap->no_pembelian_harta_tetap;
                            $akun->save(false);
                            $cek_kas->save(false);
                            $jurnal_umum_detail->save(false);

                            if ($akun->nama_akun == 'kas') {
                                $history_transaksi3 = new AktHistoryTransaksi();
                                $history_transaksi3->nama_tabel = 'akt_kas_bank';
                                $history_transaksi3->id_tabel = $model->id_kas_bank;
                                $history_transaksi3->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                                $history_transaksi3->save(false);
                            }
                        }
                    }


                    $history_transaksi = new AktHistoryTransaksi();
                    $history_transaksi->nama_tabel = 'akt_pembayaran_biaya_harta_tetap';
                    $history_transaksi->id_tabel = $model->id_pembayaran_biaya_harta_tetap;
                    $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                    $history_transaksi->save(false);

                    // End Create Jurnal Umum Detail

                }
                return $this->redirect(['view-pembayaran-biaya-harta-tetap', 'id' => $model->id_pembelian_harta_tetap]);
            }
        }
    }

    public function actionDeleteFromView($id)
    {
        $model = $this->findModel($id);
        $akt_pembelian = AktPembelian::findOne($model->id_pembelian);
        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembayaran_biaya'])->count();
        if ($history_transaksi_count > 0) {
            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembayaran_biaya'])->one();
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi->id_jurnal_umum])->one();
            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum->id_jurnal_umum])->all();
            // if($akt_pembelian->jenis_bayar == 1) {
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
                }
                if ($akun->nama_akun == 'kas') {
                    $history_transaksi2 = AktHistoryTransaksi::find()->where(['id_tabel' => $model->id_kas_bank])->andWhere(['nama_tabel' => 'akt_kas_bank'])->andWhere(['id_jurnal_umum' => $ju->id_jurnal_umum_detail])->one();
                    $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();
                    $akt_kas_bank->saldo = $akt_kas_bank->saldo + $ju->debit + $ju->kredit;
                    $akt_kas_bank->save(false);
                    $history_transaksi2->delete();
                }
                $akun->save(false);
                $ju->delete();
            }
            // } 


            $jurnal_umum->delete();
            $history_transaksi->delete();
        }

        $model->delete();
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Terhapus dari Data Pembayaran Biaya']]);
        return $this->redirect(['view-pembayaran-biaya', 'id' => $model->id_pembelian]);
    }

    public function actionDeleteFromViewHartaTetap($id)
    {
        $model = AktPembayaranBiayaHartaTetap::find()->where(['id_pembayaran_biaya_harta_tetap' => $id])->one();
        $harta_tetap = AktHartaTetap::findOne($model->id_pembelian_harta_tetap);
        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembayaran_biaya_harta_tetap'])->count();
        if ($history_transaksi_count > 0) {
            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembayaran_biaya_harta_tetap'])->one();
            // var_dump($history_transaksi);
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi->id_jurnal_umum])->one();
            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum->id_jurnal_umum])->all();
            // if($akt_pembelian->jenis_bayar == 1) {
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
                }
                if ($akun->nama_akun == 'kas') {
                    $history_transaksi2 = AktHistoryTransaksi::find()->where(['id_tabel' => $model->id_kas_bank])->andWhere(['nama_tabel' => 'akt_kas_bank'])->andWhere(['id_jurnal_umum' => $ju->id_jurnal_umum_detail])->one();
                    $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();
                    $akt_kas_bank->saldo = $akt_kas_bank->saldo + $ju->debit + $ju->kredit;
                    $akt_kas_bank->save(false);
                    $history_transaksi2->delete();
                }
                $akun->save(false);
                $ju->delete();
            }
            // } 


            $jurnal_umum->delete();
            $history_transaksi->delete();
        }
        // die;

        $model->delete();
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Terhapus dari Data Pembayaran Biaya']]);
        return $this->redirect(['view-pembayaran-biaya-harta-tetap', 'id' => $model->id_pembelian_harta_tetap]);
    }

    /**
     * Deletes an existing AktPembayaranBiaya model.
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
     * Finds the AktPembayaranBiaya model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPembayaranBiaya the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPembayaranBiaya::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionKasBank()
    {
        $jenis = $_POST['depdrop_parents'][0];
        $state = Yii::$app->db->createCommand("
        SELECT akt_kas_bank.id_kas_bank, akt_kas_bank.keterangan, akt_kas_bank.kode_kas_bank, akt_kas_bank.saldo
        FROM akt_kas_bank 
        WHERE akt_kas_bank.jenis = '$jenis'")->query();
        $all_state = array();
        $i = 0;
        foreach ($state as $value) {
            $all_state[$i]['id'] = $value['id_kas_bank'];
            $all_state[$i]['name'] = $value['kode_kas_bank']  . ' - ' . $value['keterangan'] . ' : ' . ribuan($value['saldo']);
            $i++;
        }

        echo Json::encode(['output' => $all_state, 'selected' => '']);
        return;
    }


    public function actionCetakInvoice($id)
    {
        $model = AktPembelian::findOne($id);

        $data_setting = Setting::find()->one();

        $sum_retur = Yii::$app->db->createCommand("SELECT SUM(total) from akt_retur_pembelian WHERE id_pembelian = '$id'")->queryScalar();
        $query = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
        $total_pembelian_barang = $query->sum('total');

        return $this->renderPartial('cetak_invoice', [
            'model' => $model,
            'sum_retur' => $sum_retur,
            'data_setting' => $data_setting,
            'total_pembelian_barang' => $total_pembelian_barang,
        ]);
    }
}
