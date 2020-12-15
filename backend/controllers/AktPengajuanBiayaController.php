<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPengajuanBiaya;
use backend\models\AktPengajuanBiayaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktApprover;
use backend\models\Foto;
use backend\models\AktPengajuanBiayaDetail;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktAkun;
use backend\models\AktHistoryTransaksi;
use backend\models\AktKasBank;
use yii\helpers\ArrayHelper;

/**
 * AktPengajuanBiayaController implements the CRUD actions for AktPengajuanBiaya model.
 */
class AktPengajuanBiayaController extends Controller
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
     * Lists all AktPengajuanBiaya models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPengajuanBiayaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPengajuanBiaya model.
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

        $foto = Foto::find()->where(["id_tabel" => $model->id_pengajuan_biaya, "nama_tabel" => "akt_pengajuan_biaya"])->all();

        $model_pengajuan_biaya_detail = new AktPengajuanBiayaDetail();
        $model_pengajuan_biaya_detail->id_pengajuan_biaya = $model->id_pengajuan_biaya;
        $model_pengajuan_biaya_detail->debit = 0;
        $model_pengajuan_biaya_detail->kredit = 0;

        $data_akun = ArrayHelper::map(
            AktAkun::find()
                ->orderBy("nama_akun")
                ->all(),
            'id_akun',
            function ($model) {
                return $model['kode_akun'] . ' - ' . $model['nama_akun'];
            }
        );

        return $this->render('view', [
            'model' => $model,
            'foto' => $foto,
            'model_pengajuan_biaya_detail' => $model_pengajuan_biaya_detail,
            'data_akun' => $data_akun,
        ]);
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
     * Creates a new AktPengajuanBiaya model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPengajuanBiaya();
        $model->tanggal_pengajuan = date('Y-m-d');

        $data_approver1 = AktApprover::findOne(['id_jenis_approver' => 1, 'tingkat_approver' => 1]);
        $data_approver2 = AktApprover::findOne(['id_jenis_approver' => 1, 'tingkat_approver' => 2]);
        $data_approver3 = AktApprover::findOne(['id_jenis_approver' => 1, 'tingkat_approver' => 3]);
        $id_login = Yii::$app->user->id;

        // if($data_approver1 != null  || $data_approver2 != null  || $data_approver3 != null  ) {
        $model->approver1 = null;
        $model->approver2 = null;
        $model->approver3 = null;
        // } 
        $model->approver1_date = '0000-00-00 00:00:00';
        $model->approver2_date = '0000-00-00 00:00:00';
        $model->approver3_date = '0000-00-00 00:00:00';
        $model->dibuat_oleh = $id_login;

        $id_pengajuan_biaya_max = AktPengajuanBiaya::find()->select(['max(id_pengajuan_biaya) as id_pengajuan_biaya'])->one();
        $nomor_sebelumnya = AktPengajuanBiaya::find()->select(['nomor_pengajuan_biaya'])->where(['id_pengajuan_biaya' => $id_pengajuan_biaya_max])->one();
        if (!empty($nomor_sebelumnya->nomor_pengajuan_biaya)) {
            # code...
            $noUrut = (int) substr($nomor_sebelumnya->nomor_pengajuan_biaya, 6);
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
            $nomor_pengajuan_biaya = "PB" . date('ym') . $noUrut_2;
            $kode = $nomor_pengajuan_biaya;
        } else {
            # code...
            $kode = 'PB' . date('ym') . '001';
        }

        $model->nomor_pengajuan_biaya = $kode;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pengajuan_biaya]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPengajuanBiaya model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pengajuan_biaya]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPengajuanBiaya model.
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
     * Finds the AktPengajuanBiaya model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPengajuanBiaya the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPengajuanBiaya::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $id_login = Yii::$app->user->identity->id_login;
        // $akt_approver = AktApprover::find()
        // ->select(['akt_approver.tingkat_approver'])
        // ->leftjoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
        // ->where(['id_login' => $id_login])
        // ->andWhere(['akt_jenis_approver.nama_jenis_approver' => 'Pengajuan Biaya'])
        // ->one();

        $akt_approver = Yii::$app->db->createCommand("SELECT akt_approver.tingkat_approver FROM akt_approver 
        LEFT JOIN akt_jenis_approver ON akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver
        WHERE id_login = '$id_login'
        AND akt_jenis_approver.nama_jenis_approver = 'Pengajuan Biaya'")->queryScalar();

        if ($akt_approver == 1) {
            $model->approver1 = $id_login;
            $model->approver1_date = date("Y-m-d H:i:s");
        } else if ($akt_approver == 2) {
            $model->approver2 = $id_login;
            $model->approver2_date = date("Y-m-d H:i:s");
        } else if ($akt_approver == 3) {
            $model->approver3 = $id_login;
            $model->approver3_date = date("Y-m-d H:i:s");
        }
        $model->save(false);

        $cek_approver1_date = Yii::$app->db->createCommand("SELECT IF(approver1_date = 0, 0, 1) FROM akt_pengajuan_biaya WHERE id_pengajuan_biaya = '$model->id_pengajuan_biaya'")->queryScalar();
        $cek_approver2_date = Yii::$app->db->createCommand("SELECT IF(approver2_date = 0, 0, 1) FROM akt_pengajuan_biaya WHERE id_pengajuan_biaya = '$model->id_pengajuan_biaya'")->queryScalar();
        $cek_approver3_date = Yii::$app->db->createCommand("SELECT IF(approver3_date = 0, 0, 1) FROM akt_pengajuan_biaya WHERE id_pengajuan_biaya = '$model->id_pengajuan_biaya'")->queryScalar();
        $a = $cek_approver1_date + $cek_approver2_date + $cek_approver3_date;

        if ($a == 3) {
            $status = 4;
        } else {
            $status = 0;
        }

        $ubah_lagi = AktPengajuanBiaya::find()->where(['id_pengajuan_biaya' => $id])->one();
        $ubah_lagi->status = $status;
        $ubah_lagi->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Melakukan Approving']]);
        return $this->redirect(['view', 'id' => $model->id_pengajuan_biaya]);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $id_login = Yii::$app->user->identity->id_login;
        if ($model->load(Yii::$app->request->post())) {
            $akt_approver = Yii::$app->db->createCommand("SELECT akt_approver.tingkat_approver FROM akt_approver 
            LEFT JOIN akt_jenis_approver ON akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver
            WHERE id_login = '$id_login'
            AND akt_jenis_approver.nama_jenis_approver = 'Pengajuan Biaya'")->queryScalar();

            if ($akt_approver == 1) {
                $model->status = 1;
                $model->approver1 = $id_login;
                $model->approver1_date = date("Y-m-d H:i:s");
            } else if ($akt_approver == 2) {
                $model->status = 2;
                $model->approver2 = $id_login;
                $model->approver2_date = date("Y-m-d H:i:s");
            } else if ($akt_approver == 3) {
                $model->status = 3;
                $model->approver3 = $id_login;
                $model->approver3_date = date("Y-m-d H:i:s");
            }
            // if (Yii::$app->user->identity->id_login == $model->approver1) {
            //     $model->status = 1;
            //     $model->approver1_date = "0000-00-00 00:00:00";
            // }
            // if (Yii::$app->user->identity->id_login == $model->approver2) {
            //     $model->status = 2;
            //     $model->approver2_date = "0000-00-00 00:00:00";
            // }
            // if (Yii::$app->user->identity->id_login == $model->approver3) {
            //     $model->status = 3;
            //     $model->approver3_date = "0000-00-00 00:00:00";
            // }
            $model->save(false);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Melakukan Rejecting']]);
            return $this->redirect(['view', 'id' => $model->id_pengajuan_biaya]);
        }

        return $this->render('reject', [
            'model' => $model,
        ]);
    }

    public function actionSudahDibayar($id)
    {
        $model = $this->findModel($id);
        $model->status_pembayaran = 2;
        $model->save(false);

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
        $jurnal_umum->tanggal = $model->tanggal_pengajuan;
        $jurnal_umum->tipe = 1;
        $jurnal_umum->save(false);

        $akt_pengajuan_biaya_detail = AktPengajuanBiayaDetail::find()->where(['id_pengajuan_biaya' => $id])->all();

        foreach ($akt_pengajuan_biaya_detail as $detail) {
            $akt_jurnal_umum_detail = new AktJurnalUmumDetail();
            $akt_jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $akt_jurnal_umum_detail->id_akun = $detail->id_akun;
            $akt_akun = AktAkun::find()->where(['id_akun' => $detail->id_akun])->one();

            if ($akt_akun->nama_akun != 'kas') {
                if ($akt_akun->saldo_normal == 1) {
                    $akt_akun->saldo_akun = $akt_akun->saldo_akun + $detail->debit - $detail->kredit;
                } else if ($akt_akun->saldo_normal == 2) {
                    $akt_akun->saldo_akun = $akt_akun->saldo_akun + $detail->kredit - $detail->debit;
                }
            }

            $akt_jurnal_umum_detail->debit = $detail->debit;
            $akt_jurnal_umum_detail->kredit = $detail->kredit;
            $akt_jurnal_umum_detail->keterangan = $detail->nama_pengajuan;

            $akt_akun->save();
            $akt_jurnal_umum_detail->save(false);

            if ($akt_akun->nama_akun == 'kas') {
                $history_transaksi2 = AktHistoryTransaksi::find()->where(['nama_tabel' => 'akt_kas_bank'])->andWhere(['id_jurnal_umum' => 0])->one();
                $history_transaksi2->id_jurnal_umum = $akt_jurnal_umum_detail->id_jurnal_umum_detail;
                $history_transaksi2->save(false);
                $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $history_transaksi2['id_tabel']])->one();
                $akt_kas_bank->saldo = $akt_kas_bank->saldo + $detail->debit - $detail->kredit;
                $akt_kas_bank->save(false);
            }


            // $history_transaksi2 = new AktHistoryTransaksi();
        }

        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_pengajuan_biaya';
        $history_transaksi->id_tabel = $model->id_pengajuan_biaya;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);




        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Merubah Status Pembayaran']]);
        return $this->redirect(['view', 'id' => $model->id_pengajuan_biaya]);
    }
}
