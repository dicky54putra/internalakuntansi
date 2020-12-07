<?php

namespace backend\controllers;

use Yii;
use backend\models\AktHartaTetap;
use backend\models\AktAkun;
use backend\models\AktDepresiasiHartaTetap;
use backend\models\AktKelompokHartaTetap;


use backend\models\AktPembelianHartaTetapDetail;
use backend\models\AktPembelianHartaTetapDetailSearch;


use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktHistoryTransaksi;

use backend\models\AktHartaTetapSearch;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktPembelianHartaTetapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * AktHartaTetapController implements the CRUD actions for AktHartaTetap model.
 */
class AktHartaTetapController extends Controller
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
     * Lists all AktHartaTetap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktHartaTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexAkutansi()
    {
        $searchModel = new AktPembelianHartaTetapDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index_akutansi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktHartaTetap model.
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

    public function actionViewAkutansi($id)
    {
        $model = AktPembelianHartaTetapDetail::findOne($id);
        $akt_kelompok_harta_tetap = new AktKelompokHartaTetap();

        $data_akt_kelompok_harta_tetap = ArrayHelper::map(
            AktKelompokHartaTetap::find()->all(),
            'id_kelompok_harta_tetap',
            function ($akt_kelompok_harta_tetap) {
                return $akt_kelompok_harta_tetap['kode'] . ' - ' . $akt_kelompok_harta_tetap['nama'];
            }
        );


        return $this->render('view_akutansi', [
            'model' => $model,
            'data_akt_kelompok_harta_tetap' => $data_akt_kelompok_harta_tetap
        ]);
    }
    public function actionSettingDepresiasi($id)
    {
        $model = AktPembelianHartaTetapDetail::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            $_beban_per_bulan = Yii::$app->request->post('beban_per_bulan');
            $beban_per_bulan = preg_replace("/[^0-9,]+/", "", $_beban_per_bulan);

            $_beban_tahun_ini = Yii::$app->request->post('beban_tahun_ini');
            $beban_tahun_ini = preg_replace("/[^0-9,]+/", "", $_beban_tahun_ini);
            $model->beban_per_bulan = $beban_per_bulan;

            $tanggal_ekonomis = date("Y-m-d", strtotime("$model->tanggal_pakai +$model->umur_ekonomis year"));

            $month = strtotime($model->tanggal_pakai);
            $end = strtotime($tanggal_ekonomis);
            while ($month <= $end) {
                $tanggal =  date('Y-m-t', $month);
                $depresiasi_harta_tetap = new AktDepresiasiHartaTetap();
                $akt_depresiasi_harta_tetap = AktDepresiasiHartaTetap::find()->select(["kode_depresiasi"])->orderBy("id_depresiasi_harta_tetap DESC")->limit(1)->one();
                if (!empty($akt_depresiasi_harta_tetap->kode_depresiasi)) {
                    # code...
                    $no_bulan = substr($akt_depresiasi_harta_tetap->kode_depresiasi, 2, 4);
                    if ($no_bulan == date('ym')) {
                        # code...
                        $noUrut = substr($akt_depresiasi_harta_tetap->kode_depresiasi, -3);
                        $noUrut++;
                        $noUrut_2 = sprintf("%03s", $noUrut);
                        $kode_depresiasi = 'FD' . date('ym') . $noUrut_2;
                    } else {
                        # code...
                        $kode_depresiasi = 'FD' . date('ym') . '001';
                    }
                } else {
                    # code...
                    $kode_depresiasi = 'FD' . date('ym') . '001';
                }

                $depresiasi_harta_tetap->id_pembelian_harta_tetap_detail = $id;
                $depresiasi_harta_tetap->tanggal = $tanggal;
                $depresiasi_harta_tetap->nilai = $beban_per_bulan;
                $depresiasi_harta_tetap->kode_depresiasi = $kode_depresiasi;
                $depresiasi_harta_tetap->save(false);

                $month = strtotime("+1 month", $month);
            }

            // Create Jurnal Umum
            $jurnal_umum = new AktJurnalUmum();
            $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();

            $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
            $jurnal_umum->tipe = 1;
            $jurnal_umum->tanggal = date('Y-m-d');
            $jurnal_umum->keterangan = 'Setting Depresiasi : ' .  $model->kode_pembelian;
            $jurnal_umum->save(false);


            $model->save(false);


            $kelompok_harta_tetap = AktKelompokHartaTetap::find()->where(['id_kelompok_harta_tetap' => $model->id_kelompok_aset_tetap])->one();
            $akun_akumulasi = AktAkun::find()->where(['id_akun' => $kelompok_harta_tetap->id_akun_akumulasi])->one();
            $akun_depresiasi = AktAkun::find()->where(['id_akun' => $kelompok_harta_tetap->id_akun_depresiasi])->one();
            $akun_harta = AktAkun::find()->where(['id_akun' => $kelompok_harta_tetap->id_akun_harta])->one();

            $jurnal_umum_detail_akumulasi = new AktJurnalUmumDetail();
            $jurnal_umum_detail_akumulasi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail_akumulasi->id_akun = $akun_akumulasi->id_akun;
            if ($akun_akumulasi->saldo_normal == 2) {
                $jurnal_umum_detail_akumulasi->kredit = intval($beban_per_bulan);
                $jurnal_umum_detail_akumulasi->debit = 0;
            } else if ($akun_akumulasi->saldo_normal == 1) {
                $jurnal_umum_detail_akumulasi->debit = intval($beban_per_bulan);
                $jurnal_umum_detail_akumulasi->kredit = 0;
            }
            $jurnal_umum_detail_akumulasi->keterangan = 'Setting Depresiasi : ' .  $model->kode_pembelian;
            $jurnal_umum_detail_akumulasi->save(false);

            $akun_akumulasi->saldo_akun = $akun_akumulasi->saldo_akun + intval($beban_per_bulan);
            $akun_akumulasi->save(false);


            $jurnal_umum_detail_depresiasi = new AktJurnalUmumDetail();
            $jurnal_umum_detail_depresiasi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail_depresiasi->id_akun = $akun_depresiasi->id_akun;
            if ($akun_depresiasi->saldo_normal == 2) {
                $jurnal_umum_detail_depresiasi->kredit = intval($beban_per_bulan);
                $jurnal_umum_detail_depresiasi->debit = 0;
            } else if ($akun_depresiasi->saldo_normal == 1) {
                $jurnal_umum_detail_depresiasi->debit = intval($beban_per_bulan);
                $jurnal_umum_detail_depresiasi->kredit = 0;
            }
            $jurnal_umum_detail_depresiasi->keterangan = 'Setting Depresiasi : ' .  $model->kode_pembelian;
            $jurnal_umum_detail_depresiasi->save(false);

            $akun_depresiasi->saldo_akun = $akun_depresiasi->saldo_akun + intval($beban_per_bulan);
            $akun_depresiasi->save(false);



            $jurnal_umum_detail_harta = new AktJurnalUmumDetail();
            $jurnal_umum_detail_harta->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail_harta->id_akun = $akun_harta->id_akun;
            if ($akun_harta->saldo_normal == 2) {
                $jurnal_umum_detail_harta->kredit = intval($beban_tahun_ini);
                $jurnal_umum_detail_harta->debit = 0;
            } else if ($akun_harta->saldo_normal == 1) {
                $jurnal_umum_detail_harta->debit = intval($beban_tahun_ini);
                $jurnal_umum_detail_harta->kredit = 0;
            }
            $jurnal_umum_detail_harta->keterangan = 'Setting Depresiasi : ' .  $model->kode_pembelian;
            $jurnal_umum_detail_harta->save(false);

            $akun_harta->saldo_akun = $akun_harta->saldo_akun + intval($beban_tahun_ini);
            $akun_harta->save(false);


            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_setting_depresiasi';
            $history_transaksi->id_tabel = $model->id_pembelian_harta_tetap_detail;
            $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $history_transaksi->save(false);



            return $this->redirect(['view-akutansi', 'id' => $model->id_pembelian_harta_tetap_detail]);
        }
    }


    public function actionDeleteDepresiasi($id)
    {
        $model = AktPembelianHartaTetapDetail::findOne($id);

        $tanggal_ekonomis = date("Y-m-t", strtotime("$model->tanggal_pakai +$model->umur_ekonomis year"));
        $start = $model->tanggal_pakai;

        $depresiasi_harta_tetap =  AktDepresiasiHartaTetap::find()
            ->where(['>=', 'tanggal', $start])
            ->andWhere(['<=', 'tanggal', $tanggal_ekonomis])
            ->andWhere(['=', 'id_pembelian_harta_tetap_detail', $id])
            ->all();


        foreach ($depresiasi_harta_tetap as $d) {
            $d->delete();
        }

        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_setting_depresiasi'])->count();

        // echo $history_transaksi_count;
        // die;

        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_setting_depresiasi'])->one();
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi['id_jurnal_umum']])->one();

            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum['id_jurnal_umum']])->all();
            foreach ($jurnal_umum_detail as $ju) {
                $akun = AktAkun::find()->where(['id_akun' => $ju->id_akun])->one();
                if ($akun->saldo_normal == 1 && $ju->debit > 0 || $ju->debit < 0) {
                    $akun->saldo_akun = $akun->saldo_akun - $ju->debit;
                } else if ($akun->saldo_normal == 1 && $ju->kredit > 0 || $ju->kredit < 0) {
                    $akun->saldo_akun = $akun->saldo_akun + $ju->kredit;
                } else if ($akun->saldo_normal == 2 && $ju->kredit > 0 || $ju->kredit < 0) {
                    $akun->saldo_akun = $akun->saldo_akun - $ju->kredit;
                } else if ($akun->saldo_normal == 2 && $ju->debit > 0 || $ju->debit < 0) {
                    $akun->saldo_akun = $akun->saldo_akun + $ju->debit;
                }
                $akun->save(false);
                $ju->delete();
            }

            $jurnal_umum->delete();
            $history_transaksi->delete();
        }


        $model->id_kelompok_aset_tetap = null;
        $model->umur_ekonomis = null;
        $model->lokasi = null;
        $model->beban_per_bulan = null;
        $model->terhitung_tanggal = null;
        $model->tanggal_pakai = null;
        $model->save(false);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Depresiasi Berhasil Dihapus, Jangan Lupa Untuk Setting Ulang Data Depresiasi!']]);

        return $this->redirect(['view-akutansi', 'id' => $model->id_pembelian_harta_tetap_detail]);
    }


    public function actionGetAktKelompokHartaTetap($id)
    {
        $akt_kelompok_harta_tetap =  AktKelompokHartaTetap::find()
            ->where(['id_kelompok_harta_tetap' => $id])
            ->one();

        $akun_harta = AktAkun::find()->select(['nama_akun'])->where(['id_akun' => $akt_kelompok_harta_tetap['id_akun_harta']])->one();
        $akun_depresiasi = AktAkun::find()->select(['nama_akun'])->where(['id_akun' => $akt_kelompok_harta_tetap['id_akun_depresiasi']])->one();
        $akun_akumulasi = AktAkun::find()->select(['nama_akun'])->where(['id_akun' => $akt_kelompok_harta_tetap['id_akun_akumulasi']])->one();

        $data = array(
            'metode_depresiasi' => $akt_kelompok_harta_tetap['metode_depresiasi'],
            'umur_ekonomis' => $akt_kelompok_harta_tetap['umur_ekonomis'],
            'akun_harta' => $akun_harta,
            'akun_akumulasi' => $akun_akumulasi,
            'akun_depresiasi' => $akun_depresiasi,
        );

        echo Json::encode($data);
    }
    /**
     * Creates a new AktHartaTetap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktHartaTetap();

        $id_harta_tetap = AktHartaTetap::find()->select(['max(id_harta_tetap) as id_harta_tetap'])->one();
        $nomor_sebelumnya = AktHartaTetap::find()->select(['kode'])->where(['id_harta_tetap' => $id_harta_tetap])->one();
        if (!empty($nomor_sebelumnya->kode)) {
            # code...
            $noUrut = (int) substr($nomor_sebelumnya->kode, 2);
            if ($noUrut <= 999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
            } elseif ($noUrut <= 9999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%04s", $noUrut);
            } elseif ($noUrut <= 99999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%05s", $noUrut);
            }
            $kode = "HT" . $noUrut_2;
            $kode = $kode;
        } else {
            # code...
            $kode = 'HT001';
        }

        $model->kode = $kode;


        $model_kelompok_harta_tetap = new AktKelompokHartaTetap();

        $id_kelompok_harta_tetap = AktKelompokHartaTetap::find()->select(['max(id_kelompok_harta_tetap) as id_kelompok_harta_tetap'])->one();
        $nomor_sebelumnya_kelompok_harta_tetap = AktKelompokHartaTetap::find()->select(['kode'])->where(['id_kelompok_harta_tetap' => $id_kelompok_harta_tetap])->one();
        if (!empty($nomor_sebelumnya_kelompok_harta_tetap->kode)) {
            # code...
            $noUrut = (int) substr($nomor_sebelumnya_kelompok_harta_tetap->kode, 2);
            if ($noUrut <= 999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
            } elseif ($noUrut <= 9999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%04s", $noUrut);
            } elseif ($noUrut <= 99999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%05s", $noUrut);
            }
            $kode = "KH" . $noUrut_2;
            $kode = $kode;
        } else {
            # code...
            $kode = 'KH001';
        }

        $model_kelompok_harta_tetap->kode = $kode;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_harta_tetap]);
        }

        return $this->render('create', [
            'model' => $model,
            'model_kelompok_harta_tetap' => $model_kelompok_harta_tetap,
        ]);
    }

    /**
     * Updates an existing AktHartaTetap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model_kelompok_harta_tetap = new AktKelompokHartaTetap();

        $id_kelompok_harta_tetap = AktKelompokHartaTetap::find()->select(['max(id_kelompok_harta_tetap) as id_kelompok_harta_tetap'])->one();
        $nomor_sebelumnya_kelompok_harta_tetap = AktKelompokHartaTetap::find()->select(['kode'])->where(['id_kelompok_harta_tetap' => $id_kelompok_harta_tetap])->one();
        if (!empty($nomor_sebelumnya_kelompok_harta_tetap->kode)) {
            # code...
            $noUrut = (int) substr($nomor_sebelumnya_kelompok_harta_tetap->kode, 2);
            if ($noUrut <= 999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
            } elseif ($noUrut <= 9999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%04s", $noUrut);
            } elseif ($noUrut <= 99999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%05s", $noUrut);
            }
            $kode = "KH" . $noUrut_2;
            $kode = $kode;
        } else {
            # code...
            $kode = 'KH001';
        }

        $model_kelompok_harta_tetap->kode = $kode;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_harta_tetap]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_kelompok_harta_tetap' => $model_kelompok_harta_tetap,
        ]);
    }

    /**
     * Deletes an existing AktHartaTetap model.
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
     * Finds the AktHartaTetap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktHartaTetap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktHartaTetap::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
