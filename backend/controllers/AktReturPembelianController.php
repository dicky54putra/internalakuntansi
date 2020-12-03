<?php

namespace backend\controllers;

use Yii;
use backend\models\AktReturPembelian;
use backend\models\AktReturPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktHistoryTransaksi;
use backend\models\AktAkun;
use backend\models\AktKasBank;


use backend\models\AktReturPembelianDetail;
use backend\models\AktPembelian;
use backend\models\AktItemStok;
use backend\models\AktPembelianDetail;
use yii\helpers\ArrayHelper;
use backend\models\Foto;
use backend\models\Setting;
use Mpdf\Mpdf;
use yii\helpers\Json;
use yii\helpers\Utils;

/**
 * AktReturPembelianController implements the CRUD actions for AktReturPembelian model.
 */
class AktReturPembelianController extends Controller
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
     * Lists all AktReturPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktReturPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktReturPembelian model.
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

        $foto = Foto::find()->where(["id_tabel" => $model->id_retur_pembelian, "nama_tabel" => "akt_retur_pembelian"])->all();

        $data_pembelian_detail = ArrayHelper::map(
            AktPembelianDetail::find()
                ->select(["akt_pembelian_detail.id_pembelian_detail", "akt_item.nama_item", "akt_pembelian_detail.qty"])
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok")
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->where(['id_pembelian' => $model->id_pembelian])
                ->asArray()
                ->all(),
            'id_pembelian_detail',
            function ($model) {
                $sum_retur_detail = Yii::$app->db->createCommand("SELECT SUM(retur) as retur FROM akt_retur_pembelian_detail WHERE id_pembelian_detail = '$model[id_pembelian_detail]'")->queryScalar();
                $qty = $model['qty'] - $sum_retur_detail;
                return $model['nama_item'] . ', Qty pembelian : ' . $qty;
            }
        );

        $model_retur_pembelian_detail = new AktReturPembelianDetail();
        $model_retur_pembelian_detail->id_retur_pembelian = $model->id_retur_pembelian;


        return $this->render('view', [
            'model' => $model,
            'model_retur_pembelian_detail' => $model_retur_pembelian_detail,
            'data_pembelian_detail' => $data_pembelian_detail,
            'foto' => $foto,
        ]);
    }

    /**
     * Creates a new AktReturPembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktReturPembelian();
        $model->tanggal_retur_pembelian = date('Y-m-d');

        $kode = Utils::getNomorTransaksi($model, 'RB', 'no_retur_pembelian', 'no_retur_pembelian');
        $model->no_retur_pembelian = $kode;
        $data_penerimaan = ArrayHelper::map(
            AktPembelian::find()
                ->where(["=", 'status', 4])
                ->andWhere(['IS NOT', 'no_pembelian', NULL])
                ->all(),
            'id_pembelian',
            'no_pembelian'
        );

        $data_kas_bank = AktReturPembelian::getKasBank();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_retur_pembelian . ' Berhasil Tersimpan di Data Retur Pembelian']]);
            return $this->redirect(['view', 'id' => $model->id_retur_pembelian]);
        }

        return $this->render('create', [
            'data_kas_bank' => $data_kas_bank,
            'model' => $model,
            'data_penerimaan' => $data_penerimaan,
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
     * Updates an existing AktReturPembelian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data_penerimaan = ArrayHelper::map(
            AktPembelian::find()
                ->where(["=", 'status', 4])
                ->andWhere(['IS NOT', 'no_pembelian', NULL])
                ->all(),
            'id_pembelian',
            'no_pembelian'
        );

        $data_kas_bank = AktReturPembelian::getKasBank();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data ' . $model->no_retur_pembelian . ' Berhasil Tersimpan di Data Retur Pembelian']]);
            return $this->redirect(['view', 'id' => $model->id_retur_pembelian]);
        }

        return $this->render('update', [
            'data_kas_bank' => $data_kas_bank,
            'model' => $model,
            'data_penerimaan' => $data_penerimaan,
        ]);
    }

    /**
     * Deletes an existing AktReturPembelian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $cek_detail = AktReturPembelianDetail::find()->where(['id_retur_pembelian' => $id])->count();

        if ($cek_detail > 0) {
            Yii::$app->session->setFlash('success', [['Perhatian !', 'Hapus Detail Barang Terlebih dahulu']]);
            return $this->redirect(['view', 'id' => $id]);
        } else {
            $model->delete();
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the AktReturPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktReturPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktReturPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApproved($id)
    {
        $model = $this->findModel($id);

        $query_retur_pembelian_detail = AktReturPembelianDetail::find()->where(['id_retur_pembelian' => $model->id_retur_pembelian])->all();
        $model_pembelian = AktPembelian::findOne($model->id_pembelian);


        // Create Jurnal Umum
        $jurnal_umum = new AktJurnalUmum();
        $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();
        $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
        $jurnal_umum->tipe = 1;
        $jurnal_umum->tanggal = date('Y-m-d');
        $jurnal_umum->keterangan = 'Retur Pembelian : ' .  $model_pembelian->no_pembelian;
        $jurnal_umum->save(false);
        // End Create Jurnal Umum


        $total_harga_semua_retur = 0;

        foreach ($query_retur_pembelian_detail as $key => $data) {
            $pembelian_detail = AktPembelianDetail::findOne($data['id_pembelian_detail']);
            $query_retur_pembelian_detail_ = AktReturPembelianDetail::find()->where(['id_pembelian_detail' => $data['id_pembelian_detail']])->one();
            $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
            $item_stok->qty = $item_stok->qty - $query_retur_pembelian_detail_->retur;
            $item_stok->save(false);

            $diskon_pembelian = $pembelian_detail->diskon == NULL ? 0 : $pembelian_detail->diskon;
            $diskon = $diskon_pembelian / 100 * $pembelian_detail['harga'];
            $harga_per_item = $pembelian_detail['harga'] - $diskon;
            $diskon_keseluruhan = $model_pembelian->diskon / 100 * $harga_per_item;

            $harga_diskon_keseluruhan = $harga_per_item - $diskon_keseluruhan;

            $total = $harga_diskon_keseluruhan * $data['retur'];
            $total_harga_semua_retur += $total;
        }

        $pajak = 0.1 * $total_harga_semua_retur;

        if ($model_pembelian->pajak == 1) {
            $ppn = $pajak;
            $hutang_usaha = $total_harga_semua_retur + $ppn;
        } else {
            $ppn = 0;
            $hutang_usaha = $total_harga_semua_retur;
        }


        // Debit
        if ($model_pembelian->jenis_bayar == 1) {
            $jurnal_transaksi_detail = AktReturPembelian::getJurnalTransaksi('Retur Pembelian Transaksi Cash');
            foreach ($jurnal_transaksi_detail as $jt) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
                if ($akun->id_akun == 1) {
                    $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                    if (strtolower($akun->nama_akun) == 'kas' && $jt->tipe == 'D') {
                        $jurnal_umum_detail->debit = $hutang_usaha;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $hutang_usaha;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $hutang_usaha;
                        }
                    } else if (strtolower($akun->nama_akun) == 'kas' && $jt->tipe == 'K') {
                        $jurnal_umum_detail->kredit = $hutang_usaha;
                        if ($akun->saldo_normal == 1) {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo - $hutang_usaha;
                        } else {
                            $akt_kas_bank->saldo = $akt_kas_bank->saldo + $hutang_usaha;
                        }
                    }
                    $akt_kas_bank->save(false);
                } else {
                    AktReturPembelian::setfilterNamaAkun($akun, 'ppn masukan', $jurnal_umum_detail, $ppn, $jt);
                    AktReturPembelian::setfilterNamaAkun($akun, 'retur pembelian', $jurnal_umum_detail, $total_harga_semua_retur, $jt);
                }
                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Retur Pembelian Transaksi Cash : ' .  $model->no_retur_pembelian;
                $jurnal_umum_detail->save(false);

                if ($akun->id_akun == 1) {
                    $history_transaksi_kas = new AktHistoryTransaksi();
                    $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                    $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                    $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                    $history_transaksi_kas->save(false);
                }
            }
        }
        // Kredit
        else if ($model_pembelian->jenis_bayar == 2) {
            $jurnal_transaksi_detail = AktReturPembelian::getJurnalTransaksi('Retur Pembelian Transaksi Kredit');
            foreach ($jurnal_transaksi_detail as $jt) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
                if ($jt->id_akun == 64 && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $hutang_usaha;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun + $hutang_usaha;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun - $hutang_usaha;
                    }
                } else if ($jt->id_akun == 64 && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $hutang_usaha;
                    if ($akun->saldo_normal == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $hutang_usaha;
                    } else {
                        $akun->saldo_akun = $akun->saldo_akun + $hutang_usaha;
                    }
                }
                AktReturPembelian::setfilterNamaAkun($akun, 'ppn masukan', $jurnal_umum_detail, $ppn, $jt);
                AktReturPembelian::setfilterNamaAkun($akun, 'retur pembelian', $jurnal_umum_detail, $total_harga_semua_retur, $jt);
                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Retur Pembelian Transaksi Kredit : ' .  $model->no_retur_pembelian;
                $jurnal_umum_detail->save(false);
            }
        }

        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_retur_pembelian';
        $history_transaksi->id_tabel = $model->id_retur_pembelian;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);


        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 2;
        $model->total = $hutang_usaha;
        $model->save(FALSE);
        $model_pembelian->total  = $model_pembelian->total - $hutang_usaha;
        $model_pembelian->save(false);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Retur ' . $model->no_retur_pembelian . ' Berhasil Diterima']]);
        return $this->redirect(['view', 'id' => $model->id_retur_pembelian]);
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);

        $query_retur_pembelian_detail = AktReturPembelianDetail::find()->where(['id_retur_pembelian' => $model->id_retur_pembelian])->all();
        foreach ($query_retur_pembelian_detail as $key => $data) {
            $pembelian_detail = AktPembelianDetail::findOne($data['id_pembelian_detail']);
            $query_retur_pembelian_detail_ = AktReturPembelianDetail::find()->where(['id_pembelian_detail' => $data['id_pembelian_detail']])->one();
            $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
            $item_stok->qty = $item_stok->qty + $query_retur_pembelian_detail_->retur;
            $item_stok->save(false);
        }

        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_retur_pembelian'])->count();

        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_retur_pembelian'])->one();
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi['id_jurnal_umum']])->one();
            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum['id_jurnal_umum']])->all();
            foreach ($jurnal_umum_detail as $ju) {
                $akun = AktAkun::find()->where(['id_akun' => $ju->id_akun])->one();
                if ($akun->id_akun == 1) {
                    $history_transaksi_kas = AktHistoryTransaksi::find()
                        ->where(['id_tabel' => $model->id_kas_bank])
                        ->andWhere(['nama_tabel' => 'akt_kas_bank'])
                        ->andWhere(['id_jurnal_umum' => $ju->id_jurnal_umum_detail])->one();
                    $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();
                    $akt_kas_bank->saldo = $akt_kas_bank->saldo - $ju->debit + $ju->kredit;
                    $akt_kas_bank->save(false);
                    $history_transaksi_kas->delete();
                } else {
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

                $akun->save(false);
                $ju->delete();
            }

            $jurnal_umum->delete();
            $history_transaksi->delete();
        }
        $model_pembelian = AktPembelian::findOne($model->id_pembelian);
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 1;
        $model_pembelian->total = $model_pembelian->total + $model->total;
        $model_pembelian->save(false);
        $model->total = 0;
        $model->save(FALSE);
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Retur ' . $model->no_retur_pembelian . ' Berhasil dipending']]);
        return $this->redirect(['view', 'id' => $model->id_retur_pembelian]);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 3;
        $model->save(FALSE);
        Yii::$app->session->setFlash('success', [['Perhatian !', 'Retur ' . $model->no_retur_pembelian . ' Berhasil ditolak']]);
        return $this->redirect(['view', 'id' => $model->id_retur_pembelian]);
    }

    public function actionPrintView($id)
    {
        $detail_retur = Yii::$app->db->createCommand("SELECT akt_item.*, akt_pembelian_detail.qty as qty_pembelian,akt_pembelian_detail.harga,akt_pembelian_detail.diskon, akt_retur_pembelian_detail.retur, akt_retur_pembelian_detail.keterangan as ket_retur FROM akt_retur_pembelian_detail LEFT JOIN akt_pembelian_detail ON akt_pembelian_detail.id_pembelian_detail = akt_retur_pembelian_detail.id_pembelian_detail LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item WHERE akt_retur_pembelian_detail.id_retur_pembelian = '$id' ORDER BY akt_item.kode_item ASC")->query();
        $setting = Setting::find()->one();
        $print =  $this->renderPartial('_print_view', [
            'model' => $this->findModel($id),
            'setting' => $setting,
            'detail_retur' => $detail_retur
        ]);
        $mPDF = new mPDF([
            'orientation' => 'L',
        ]);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }

    public function actionGetJenisPembayaran($id)
    {
        $data = AktPembelian::findOne($id);
        echo Json::encode($data->jenis_bayar);
    }
}
