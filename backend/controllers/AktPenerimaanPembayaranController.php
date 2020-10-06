<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenerimaanPembayaran;
use backend\models\AktPenerimaanPembayaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktKasBank;
use backend\models\AktPenjualan;
use backend\models\AktPenjualanSearch;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktAkun;
use backend\models\AktPenjualanHartaTetap;
use yii\helpers\ArrayHelper;
use backend\models\JurnalTransaksi;
use backend\models\AktHistoryTransaksi;
use backend\models\AktPenjualanHartaTetapSearch;

/**
 * AktPenerimaanPembayaranController implements the CRUD actions for AktPenerimaanPembayaran model.
 */
class AktPenerimaanPembayaranController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new AktPenjualanSearch();
        $dataProvider = $searchModel->searchPenerimaanPembayaran(Yii::$app->request->queryParams);
        $searchModel2 = new AktPenjualanHartaTetapSearch();
        $dataProvider2 = $searchModel2->searchPenerimaanPembayaran(Yii::$app->request->queryParams);

        return $this->render('index_penerimaan_pembayaran', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionViewPenerimaanPembayaran($id)
    {
        $model = AktPenjualan::findOne($id);

        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'];
            }
        );

        $model_penerimaan_pembayaran = new AktPenerimaanPembayaran();
        $model_penerimaan_pembayaran->tanggal_penerimaan_pembayaran = date('Y-m-d');
        $model_penerimaan_pembayaran->id_penjualan = $model->id_penjualan;

        $query = (new \yii\db\Query())->from('akt_penerimaan_pembayaran')->where(['id_penjualan' => $model->id_penjualan]);
        $sum_nominal = $query->sum('nominal');

        return $this->render('view_penerimaan_pembayaran', [
            'model' => $model,
            'data_kas_bank' => $data_kas_bank,
            'model_penerimaan_pembayaran' => $model_penerimaan_pembayaran,
            'sum_nominal' => $sum_nominal,
        ]);
    }

    public function actionCreateFromView()
    {
        $model = new AktPenerimaanPembayaran();
        $model_tanggal_penerimaan_pembayaran = Yii::$app->request->post('AktPenerimaanPembayaran')['tanggal_penerimaan_pembayaran'];
        $model_id_penjualan = Yii::$app->request->post('AktPenerimaanPembayaran')['id_penjualan'];
        $model_cara_bayar = Yii::$app->request->post('AktPenerimaanPembayaran')['cara_bayar'];
        $model_id_kas_bank = Yii::$app->request->post('AktPenerimaanPembayaran')['id_kas_bank'];
        $model_nominal = Yii::$app->request->post('AktPenerimaanPembayaran')['nominal'];
        $model_keterangan = Yii::$app->request->post('AktPenerimaanPembayaran')['keterangan'];
        $total = Yii::$app->db->createCommand("SELECT total from akt_penjualan where id_penjualan = '$model_id_penjualan'")->queryScalar();
        $nominal = Yii::$app->db->createCommand("SELECT nominal from akt_penerimaan_pembayaran where id_penjualan = '$model_id_penjualan'")->queryScalar();
        $sisa = $total - $nominal;

        $model2 = AktPenjualan::find()->where(['id_penjualan' => $model_id_penjualan])->one();
        $cek_kas = AktKasBank::find()->where(['id_kas_bank' => $model_id_kas_bank])->one();
        if ($model_nominal > $sisa) {
            Yii::$app->session->setFlash('danger', [['Perhatian !', 'Nominal yang diinputkan melebihi total yang belum diterima!']]);
            return $this->redirect(['view-penerimaan-pembayaran', 'id' => $model_id_penjualan]);
        } else if ($model_nominal <= $sisa) {
            $model->tanggal_penerimaan_pembayaran = $model_tanggal_penerimaan_pembayaran;
            $model->id_penjualan = $model_id_penjualan;
            $model->cara_bayar = $model_cara_bayar;
            $model->id_kas_bank = $model_id_kas_bank;
            $model->nominal = $model_nominal + $model2->uang_muka;
            $model->keterangan = $model_keterangan;
            $model->save(FALSE);

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
            $jurnal_umum->keterangan = 'Penerimaan Biaya : ' . $model2->no_penjualan;
            $jurnal_umum->save(false);

            $pembayaran_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penerimaan Transaksi Cash'])->one();
            $pembayaran_kredit = JurnalTransaksi::find()->where(['nama_transaksi' => 'Penerimaan Transaksi Kredit'])->one();


            if ($model2->jenis_bayar == 1) {
                $jurnal_transaksi = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembayaran_cash['id_jurnal_transaksi']])->all();
                foreach ($jurnal_transaksi as $jurnal) {
                    $jurnal_umum_detail = new AktJurnalUmumDetail();
                    $akun = AktAkun::findOne($jurnal->id_akun);
                    $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                    $jurnal_umum_detail->id_akun = $jurnal->id_akun;
                    if ($akun->nama_akun == 'Piutang Usaha' && $jurnal->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model_nominal;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                        }
                    } else if ($akun->nama_akun == 'Piutang Usaha' && $jurnal->tipe == 'K') {
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
                    $jurnal_umum_detail->keterangan = 'Penerimaan Biaya Cash: ' . $model2->no_penjualan;
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
            } else if ($model2->jenis_bayar == 2) {
                $jurnal_transaksi = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembayaran_kredit['id_jurnal_transaksi']])->all();
                foreach ($jurnal_transaksi as $jurnal) {
                    $jurnal_umum_detail = new AktJurnalUmumDetail();
                    $akun = AktAkun::findOne($jurnal->id_akun);
                    $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                    $jurnal_umum_detail->id_akun = $jurnal->id_akun;
                    if ($akun->nama_akun == 'Piutang Usaha' && $jurnal->tipe == 'D') {
                        $jurnal_umum_detail->debit = $model_nominal;
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                        } else {
                            $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                        }
                    } else if ($akun->nama_akun == 'Piutang Usaha' && $jurnal->tipe == 'K') {
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
                    $jurnal_umum_detail->keterangan = 'Penerimaan Biaya Kredit: ' . $model2->no_penjualan;
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
            $history_transaksi->nama_tabel = 'akt_penerimaan_pembayaran';
            $history_transaksi->id_tabel = $model->id_penerimaan_pembayaran_penjualan;
            $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $history_transaksi->save(false);
        }


        // $kas = Yii::$app->db->createCommand("UPDATE akt_kas_bank SET saldo = saldo + '$model_nominal' WHERE id_kas_bank = '$model_id_kas_bank'")->execute();
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Tersimpan di Data Penerimaan Pembayaran']]);
        return $this->redirect(['view-penerimaan-pembayaran', 'id' => $model->id_penjualan]);
    }



    public function actionDeleteFromView($id)
    {
        $model = $this->findModel($id);
        // $kas_bank = Yii::$app->db->createCommand("UPDATE akt_kas_bank SET saldo = saldo - '$model->nominal' WHERE id_kas_bank = '$model->id_kas_bank'")->execute();

        $akt_pembelian = AktPenjualan::findOne($model->id_penjualan);

        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penerimaan_pembayaran'])->count();

        if ($history_transaksi_count > 0) {
            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penerimaan_pembayaran'])->one();

            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi->id_jurnal_umum])->one();


            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum->id_jurnal_umum])->all();
            // if($akt_pembelian->jenis_bayar == 1) {
            foreach ($jurnal_umum_detail as $ju) {
                $akun = AktAkun::find()->where(['id_akun' => $ju->id_akun])->one();
                if ($akun->nama_akun != 'kas') {
                    if ($akun->saldo_normal == 1 && $ju->debit > 0) {
                        $akun->saldo_akun = $akun->saldo_akun - $ju->debit;
                    } else if ($akun->saldo_normal == 1 && $ju->kredit > 0) {
                        $akun->saldo_akun = $akun->saldo_akun + $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->kredit > 0) {
                        $akun->saldo_akun = $akun->saldo_akun - $ju->kredit;
                    } else if ($akun->saldo_normal == 2 && $ju->debit > 0) {
                        $akun->saldo_akun = $akun->saldo_akun + $ju->debit;
                    }
                }
                if ($akun->nama_akun == 'kas') {
                    $history_transaksi2 = AktHistoryTransaksi::find()->where(['id_tabel' => $model->id_kas_bank])->andWhere(['nama_tabel' => 'akt_kas_bank'])->andWhere(['id_jurnal_umum' => $ju->id_jurnal_umum_detail])->one();
                    $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();
                    $akt_kas_bank->saldo = $akt_kas_bank->saldo - $ju->debit + $ju->kredit;
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
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Terhapus dari Data Penerimaan Pembayaran']]);
        return $this->redirect(['view-penerimaan-pembayaran', 'id' => $model->id_penjualan]);
    }

    // public function actionIndex()
    // {
    //     $searchModel = new AktPenerimaanPembayaranSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    // public function actionCreate()
    // {
    //     $model = new AktPenerimaanPembayaran();
    //     $model->tanggal_penerimaan_pembayaran = date('Y-m-d');

    //     if ($model->load(Yii::$app->request->post()) && $model->save(FALSE)) {
    //         return $this->redirect(['update-dua', 'id' => $model->id_penerimaan_pembayaran_penjualan]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($model->load(Yii::$app->request->post()) && $model->save(FALSE)) {
    //         return $this->redirect(['view', 'id' => $model->id_penerimaan_pembayaran_penjualan]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    protected function findModel($id)
    {
        if (($model = AktPenerimaanPembayaran::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
