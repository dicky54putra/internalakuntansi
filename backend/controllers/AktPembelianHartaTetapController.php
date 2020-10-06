<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktPembelianHartaTetapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktJurnalUmum;
use backend\models\AktHistoryTransaksi;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\JurnalUmumDetail;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktAkun;

use backend\models\AktPembelianHartaTetapDetail;
use backend\models\AktMitraBisnis;
use backend\models\AktMataUang;
use backend\models\AktKasBank;
use backend\models\AktApprover;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\models\Setting;
use Mpdf\Mpdf;

/**
 * AktPembelianHartaTetapController implements the CRUD actions for AktPembelianHartaTetap model.
 */
class AktPembelianHartaTetapController extends Controller
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
     * Lists all AktPembelianHartaTetap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianHartaTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $id_login =  Yii::$app->user->identity->id_login;
        $approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Pembelian Harta Tetap'])
            ->andWhere(['id_login' => $id_login])
            ->asArray()
            ->count();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'approve' => $approve
        ]);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status = 3;
        $model->save(FALSE);
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Pembelian Harta Tetap ' . $model->no_pembelian_harta_tetap . ' Berhasil Direject']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian_harta_tetap]);
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status = 1;
        $model->save(FALSE);

        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembelian_harta_tetap'])->count();

        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_pembelian_harta_tetap'])->one();
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


        Yii::$app->session->setFlash('success', [['Perhatian !', 'Pembelian Harta Tetap ' . $model->no_pembelian_harta_tetap . ' Berhasil Dipending']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian_harta_tetap]);
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status = 2;


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
        $jurnal_umum->keterangan = 'Pembelian Harta Tetap : ' .  $model->no_pembelian_harta_tetap;
        $jurnal_umum->save(false);

        // End Create Jurnal Umum


        $pembelian_detail = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_pembelian_harta_tetap_detail WHERE id_pembelian_harta_tetap = '$model->id_pembelian_harta_tetap'")->queryScalar();


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



        if ($model->jenis_bayar == 1) {

            $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembelian Harta Tetap Cash'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();

            foreach ($jurnal_transaksi_detail as $jt) {

                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

                if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $pembelian_barang;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $pembelian_barang;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $pembelian_barang;
                    }
                } else if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'K') {
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
                $jurnal_umum_detail->keterangan = 'Pembelian Harta Tetap : ' .  $model->no_pembelian_harta_tetap;
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

            $pembelian_cash = JurnalTransaksi::find()->where(['nama_transaksi' => 'Pembelian Harta Tetap Kredit'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $pembelian_cash['id_jurnal_transaksi']])->all();

            foreach ($jurnal_transaksi_detail as $jt) {

                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

                if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $pembelian_barang;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $pembelian_barang;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $pembelian_barang;
                    }
                } else if ($akun->nama_akun == 'Aset Tetap' && $jt->tipe == 'K') {
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
                $jurnal_umum_detail->keterangan = 'Pembelian Harta Tetap : ' .  $model->no_pembelian_harta_tetap;
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
        $history_transaksi->nama_tabel = 'akt_pembelian_harta_tetap';
        $history_transaksi->id_tabel = $model->id_pembelian_harta_tetap;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);



        Yii::$app->session->setFlash('success', [['Perhatian !', 'Pembelian Harta Tetap ' . $model->no_pembelian_harta_tetap . ' Berhasil Diapprove']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian_harta_tetap]);
    }

    /**
     * Displays a single AktPembelianHartaTetap model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model_akt_pembelian_harta_tetap_detail = new AktPembelianHartaTetapDetail();
        $model_akt_pembelian_harta_tetap_detail->diskon = 0;
        $model_detail = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $id])->all();

        $data_customer =  ArrayHelper::map(AktMitraBisnis::find()->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis');
        $data_mata_uang = ArrayHelper::map(AktMataUang::find()->all(), 'id_mata_uang', 'mata_uang');


        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'] . ' : ' . ribuan($model['saldo']);
            }
        );

        $id_login =  Yii::$app->user->identity->id_login;
        $approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Pembelian Harta Tetap'])
            ->andWhere(['id_login' => $id_login])
            ->asArray()
            ->count();

        $query = (new \yii\db\Query())->from('akt_pembelian_harta_tetap_detail')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
        $model_pembelian_detail = $query->sum('total');
        $is_null = $query->count();
        $model_akt_pembelian_harta_tetap_detail->residu = 0;

        return $this->render('view', [
            'model_akt_pembelian_harta_tetap_detail' => $model_akt_pembelian_harta_tetap_detail,
            'model' => $model,
            'model_detail' => $model_detail,
            'data_customer' => $data_customer,
            'data_mata_uang' => $data_mata_uang,
            'data_kas_bank' => $data_kas_bank,
            'total' => $model_pembelian_detail,
            'approve' => $approve,
            'is_null' => $is_null
        ]);
    }

    /**
     * Creates a new AktPembelianHartaTetap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPembelianHartaTetap();
        $model->tanggal = date('Y-m-d');
        $model->id_mata_uang = 1;

        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 1])
                ->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
            }
        );

        $akt_pembelian_harta_tetap = AktPembelianHartaTetap::find()->select(["no_pembelian_harta_tetap"])->orderBy("id_pembelian_harta_tetap DESC")->limit(1)->one();
        if (!empty($akt_pembelian_harta_tetap->no_pembelian_harta_tetap)) {
            # code...
            $no_bulan = substr($akt_pembelian_harta_tetap->no_pembelian_harta_tetap, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_pembelian_harta_tetap->no_pembelian_harta_tetap, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_pembelian_harta_tetap = 'BT' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_pembelian_harta_tetap = 'BT' . date('ym') . '001';
            }
        } else {
            # code...
            $no_pembelian_harta_tetap = 'BT' . date('ym') . '001';
        }

        $model->no_pembelian_harta_tetap = $no_pembelian_harta_tetap;
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id_pembelian_harta_tetap]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_customer' => $data_customer,
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

    /**
     * Updates an existing AktPembelianHartaTetap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembelian_harta_tetap]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUbahDataPembelian($id)
    {
        $model = $this->findModel($id);
        $query = (new \yii\db\Query())->from('akt_pembelian_harta_tetap_detail')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
        $model_pembelian_detail = $query->sum('total');


        if ($model->load(Yii::$app->request->post())) {

            if ($model->uang_muka > 0 && $model->id_kas_bank == '') {
                Yii::$app->session->setFlash('danger', [['Perhatian !', 'Jika ada uang muka, kas bank tidak boleh kosong!']]);
                return $this->redirect(['view', 'id' => $model->id_pembelian_harta_tetap]);
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id_pembelian_harta_tetap]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPembelianHartaTetap model.
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

    public function actionPrintView($id)
    {
        $model = $this->findModel($id);

        $data_setting = Setting::find()->one();

        $query = (new \yii\db\Query())->from('item_pembelian_harta_tetap')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);


        return $this->renderPartial('_print_view', [
            'model' => $model,
            'data_setting' => $data_setting,
        ]);
    }

    /**
     * Finds the AktPembelianHartaTetap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPembelianHartaTetap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPembelianHartaTetap::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // Pembelian Harta Tetap Detail

    public function actionTambahDataSupplier($id)
    {
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
        return $this->redirect(['view', 'id' => $id]);
    }
}
