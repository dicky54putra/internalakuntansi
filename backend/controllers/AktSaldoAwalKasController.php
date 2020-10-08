<?php

namespace backend\controllers;

use Yii;
use backend\models\AktSaldoAwalKas;
use backend\models\AktSaldoAwalKasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktKasBank;
use backend\models\AktHistoryTransaksi;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use yii\helpers\ArrayHelper;

/**
 * AktSaldoAwalKasController implements the CRUD actions for AktSaldoAwalKas model.
 */
class AktSaldoAwalKasController extends Controller
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
     * Lists all AktSaldoAwalKas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktSaldoAwalKasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktSaldoAwalKas model.
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
     * Creates a new AktSaldoAwalKas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktSaldoAwalKas();
        $model->tanggal_transaksi = date('Y-m-d');

        $akt_saldo_awal_kas = AktSaldoAwalKas::find()->select(["no_transaksi"])->orderBy("id_saldo_awal_kas DESC")->limit(1)->one();
        if (!empty($akt_saldo_awal_kas->no_transaksi)) {
            # code...
            $no_bulan = substr($akt_saldo_awal_kas->no_transaksi, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_saldo_awal_kas->no_transaksi, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_transaksi = 'SW' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_transaksi = 'SW' . date('ym') . '001';
            }
        } else {
            # code...
            $no_transaksi = 'SW' . date('ym') . '001';
        }

        $model->no_transaksi = $no_transaksi;

        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()
                ->leftJoin("akt_akun", "akt_akun.id_akun = akt_kas_bank.id_akun")
                ->leftJoin("akt_klasifikasi", "akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi")
                ->where(["=", 'akt_klasifikasi.klasifikasi', 'Kas'])
                ->andWhere(["=", 'akt_kas_bank.status_aktif', 1])
                ->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post())) {

            // var_dump($model);
            // die;
            // membuat jurnal umum

            $model->save();

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
            $jurnal_umum->keterangan = 'Set saldo awal kas : ' . $no_transaksi;
            $jurnal_umum->tipe = 1;

            $jurnal_umum->save(false);

            // Create Jurnal Umum detail
            $jurnal_transaksi = JurnalTransaksi::find()->where(['nama_transaksi' => 'Set Saldo Awal Kas'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $jurnal_transaksi['id_jurnal_transaksi']])->all();
            // var_dump($jurnal_transaksi);

            foreach ($jurnal_transaksi_detail as $k) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $akun = AktAkun::findOne($k->id_akun);
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $k->id_akun;
                $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                if ($akun['nama_akun'] == 'kas') {
                    $jurnal_umum_detail->debit =  $model->jumlah;
                    if ($k->tipe == 'D') {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->jumlah;
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->jumlah;
                    }
                    $akt_kas_bank->save(false);
                } else {
                    if ($akun->saldo_normal == 1 && $k->tipe == 'D') {
                        $jurnal_umum_detail->debit =  $model->jumlah;
                        $akun->saldo_akun = $akun->saldo_akun + $model->jumlah;
                    } elseif ($akun->saldo_normal == 1 && $k->tipe == 'K') {
                        $jurnal_umum_detail->debit =  $model->jumlah;
                        $akun->saldo_akun = $akun->saldo_akun + $model->jumlah;
                    } elseif ($akun->saldo_normal == 2 && $k->tipe == 'K') {
                        $jurnal_umum_detail->kredit =  $model->jumlah;
                        $akun->saldo_akun = $akun->saldo_akun + $model->jumlah;
                    } elseif ($akun->saldo_normal == 1 && $k->tipe == 'D') {
                        $jurnal_umum_detail->kredit =  $model->jumlah;
                        $akun->saldo_akun = $akun->saldo_akun - $model->jumlah;
                    }
                }


                $akun->save(false);
                $jurnal_umum_detail->save(false);

                if ($akun->nama_akun == 'kas') {
                    $history_transaksi_kas = new AktHistoryTransaksi();
                    $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                    $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                    $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                    $history_transaksi_kas->save(false);
                }

                // OLD 

                // if ($k->tipe == 'K') {
                //     if ($akun->saldo_normal == 1) {
                //         if ($akun->saldo_akun < $model->jumlah) {
                //             Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak bisa menambah jurnal umum, karena saldo tidak mencukupi.']]);
                //         } else {
                //             $akun->saldo_akun = $akun->saldo_akun - $model->jumlah;
                //             $jurnal_umum_detail->kredit =  $model->jumlah;
                //             $jurnal_umum_detail->debit =  0;
                //         }
                //     } else if ($akun->saldo_normal == 2) {
                //         $akun->saldo_akun = $akun->saldo_akun + $model->jumlah;
                //         $jurnal_umum_detail->kredit =  $model->jumlah;
                //         $jurnal_umum_detail->debit =  0;
                //     }
                // } else if ($k->tipe == 'D') {
                //     if ($akun->saldo_normal == 1) {
                //         $akun->saldo_akun = $akun->saldo_akun + $model->jumlah;
                //         $jurnal_umum_detail->debit =  $model->jumlah;
                //         $jurnal_umum_detail->kredit =  0;
                //     } else if ($akun->saldo_normal == 2) {
                //         if ($akun->saldo_akun < $model->jumlah) {
                //             Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak bisa menambah jurnal umum, karena saldo tidak mencukupi.']]);
                //         } else {
                //             $akun->saldo_akun = $akun->saldo_akun - $model->jumlah;
                //             $jurnal_umum_detail->debit =  $model->jumlah;
                //             $jurnal_umum_detail->kredit =  0;
                //         }
                //     }
                // }

                // END OLD

            }

            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_saldo_awal_kas';
            $history_transaksi->id_tabel = $model->id_saldo_awal_kas;
            $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $history_transaksi->save(false);


            // die;


            # update saldo kas bank
            // $update_kas_bank = AktKasBank::findOne($model->id_kas_bank);
            // $update_kas_bank->saldo = $update_kas_bank->saldo + $model->jumlah;
            // $update_kas_bank->save(FALSE);

            #update saldo akun
            // $update_akun = AktAkun::findOne($update_kas_bank->id_akun);
            // $update_akun->saldo_akun = $update_akun->saldo_akun + $model->jumlah;
            // $update_akun->save(FALSE);

            return $this->redirect(['view', 'id' => $model->id_saldo_awal_kas]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_kas_bank' => $data_kas_bank,
        ]);
    }

    /**
     * Updates an existing AktSaldoAwalKas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()
                ->leftJoin("akt_akun", "akt_akun.id_akun = akt_kas_bank.id_akun")
                ->leftJoin("akt_klasifikasi", "akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi")
                ->where(["=", 'akt_klasifikasi.klasifikasi', 'Kas'])
                ->andWhere(["=", 'akt_kas_bank.status_aktif', 1])
                ->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post())) {

            #cek kas apakah sama sebelum di update
            if ($model->id_kas_bank == $model_sebelumnya->id_kas_bank) {
                # code...

                #cek jumlah apakah sama sebelum di update
                if ($model->jumlah == $model_sebelumnya->jumlah) {
                    # code...
                    $model->save();
                } else {
                    # code...
                    $model->save();

                    #pengurangan dan penjumlahan kas bank
                    $update_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                    $update_kas_bank->saldo = ($update_kas_bank->saldo - $model_sebelumnya->jumlah) + $model->jumlah;
                    $update_kas_bank->save(FALSE);

                    #pengurangan dan penjumlahan akun
                    $update_akun = AktAkun::findOne($update_kas_bank->id_akun);
                    $update_akun->saldo_akun = ($update_akun->saldo_akun - $model_sebelumnya->jumlah) + $model->jumlah;
                    $update_akun->save(FALSE);
                }
            } else {
                # code...
                $model->save(FALSE);

                #pengurangan kas bank sebelumnya
                $update_kas_bank_sebelumnya = AktKasBank::findOne($model_sebelumnya->id_kas_bank);
                $update_kas_bank_sebelumnya->saldo = $update_kas_bank_sebelumnya->saldo - $model_sebelumnya->jumlah;
                $update_kas_bank_sebelumnya->save(FALSE);

                #pengurangan akun sebelumnya
                $update_akun_sebelumnya = AktAkun::findOne($update_kas_bank_sebelumnya->id_akun);
                $update_akun_sebelumnya->saldo_akun = $update_akun_sebelumnya->saldo_akun - $model_sebelumnya->jumlah;
                $update_akun_sebelumnya->save(FALSE);

                #penjumlahan kas bank baru
                $update_kas_bank_baru = AktKasBank::findOne($model->id_kas_bank);
                $update_kas_bank_baru->saldo = $update_kas_bank_baru->saldo + $model->jumlah;
                $update_kas_bank_baru->save(FALSE);

                #pengurangan akun sebelumnya
                $update_akun_baru = AktAkun::findOne($update_kas_bank_baru->id_akun);
                $update_akun_baru->saldo_akun = $update_akun_baru->saldo_akun + $model->jumlah;
                $update_akun_baru->save(FALSE);
            }

            return $this->redirect(['view', 'id' => $model->id_saldo_awal_kas]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_kas_bank' => $data_kas_bank,
        ]);
    }

    /**
     * Deletes an existing AktSaldoAwalKas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);


        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_saldo_awal_kas'])->count();

        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_saldo_awal_kas'])->one();
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

        $model->delete();

        // #pengurangan dan penjumlahan kas bank
        // $update_kas_bank = AktKasBank::findOne($model->id_kas_bank);
        // $update_kas_bank->saldo = $update_kas_bank->saldo - $model->jumlah;
        // $update_kas_bank->save(FALSE);

        // #pengurangan dan penjumlahan akun
        // $update_akun = AktAkun::findOne($update_kas_bank->id_akun);
        // $update_akun->saldo_akun = $update_akun->saldo_akun - $model->jumlah;
        // $update_akun->save(FALSE);

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktSaldoAwalKas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktSaldoAwalKas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktSaldoAwalKas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
