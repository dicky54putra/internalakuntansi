<?php

namespace backend\controllers;

use Yii;
use backend\models\AktReturPenjualan;
use backend\models\AktReturPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktHistoryTransaksi;
use backend\models\AktAkun;

use backend\models\AktReturPenjualanDetail;
use backend\models\AktPenjualan;
use backend\models\AktPenjualanPengiriman;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktKasBank;
use yii\helpers\ArrayHelper;
use yii\helpers\Utils;
use backend\models\Foto;
use backend\models\Setting;
use Mpdf\Mpdf;
use yii\helpers\Json;


/**
 * AktReturPenjualanController implements the CRUD actions for AktReturPenjualan model.
 */
class AktReturPenjualanController extends Controller
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
     * Lists all AktReturPenjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktReturPenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktReturPenjualan model.
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

        $foto = Foto::find()->where(["id_tabel" => $model->id_retur_penjualan, "nama_tabel" => "akt_retur_penjualan"])->all();

        $data_penjualan_detail = ArrayHelper::map(
            AktPenjualanDetail::find()
                ->select(["akt_penjualan_detail.id_penjualan_detail", "akt_item.nama_item", "akt_penjualan_detail.qty"])
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item_stok = akt_penjualan_detail.id_item_stok")
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->where(['id_penjualan' => $model->id_penjualan])
                ->asArray()
                ->all(),
            'id_penjualan_detail',
            function ($model) {
                $sum_retur_detail = Yii::$app->db->createCommand("SELECT SUM(retur) as retur FROM akt_retur_penjualan_detail WHERE id_penjualan_detail = '$model[id_penjualan_detail]'")->queryScalar();
                $qty = $model['qty'] - $sum_retur_detail;
                return $model['nama_item'] . ', Qty penjualan : ' . $qty;
            }
        );

        $model_retur_penjualan_detail = new AktReturPenjualanDetail();
        $model_retur_penjualan_detail->id_retur_penjualan = $model->id_retur_penjualan;


        return $this->render('view', [
            'model' => $model,
            'model_retur_penjualan_detail' => $model_retur_penjualan_detail,
            'data_penjualan_detail' => $data_penjualan_detail,
            'foto' => $foto,
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
     * Creates a new AktReturPenjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktReturPenjualan();
        $model->tanggal_retur_penjualan = date('Y-m-d');

        $no_retur_penjualan = Utils::getNomorTransaksi($model, 'RP', 'no_retur_penjualan', 'no_retur_penjualan');
        $model->no_retur_penjualan = $no_retur_penjualan;

        $data_penjualan = ArrayHelper::map(
            AktPenjualan::find()
                ->where(["=", 'status', 4])
                ->andWhere(['IS NOT', 'no_penjualan', NULL])
                ->all(),
            'id_penjualan',
            'no_penjualan'
        );

        $data_kas_bank = AktReturPenjualan::getKasBank();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_retur_penjualan . ' Berhasil Tersimpan di Data Retur Penjualan']]);
            return $this->redirect(['view', 'id' => $model->id_retur_penjualan]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_kas_bank' => $data_kas_bank,
            'data_penjualan' => $data_penjualan,
        ]);
    }

    /**
     * Updates an existing AktReturPenjualan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $data_penjualan = ArrayHelper::map(
            AktPenjualan::find()
                ->where(["=", 'status', 4])
                ->andWhere(['IS NOT', 'no_penjualan', NULL])
                ->all(),
            'id_penjualan',
            'no_penjualan'
        );

        $data_kas_bank = AktReturPenjualan::getKasBank();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data ' . $model->no_retur_penjualan . ' Berhasil Tersimpan di Data Retur Penjualan']]);
            return $this->redirect(['view', 'id' => $model->id_retur_penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_kas_bank' => $data_kas_bank,
            'data_penjualan' => $data_penjualan,
        ]);
    }

    /**
     * Deletes an existing AktReturPenjualan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_retur_penjualan . ' Berhasil Terhapus dari Data Retur Barang Penjualan']]);
        AktReturPenjualanDetail::deleteAll(["id_retur_penjualan" => $model->id_retur_penjualan]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktReturPenjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktReturPenjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktReturPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        $query_retur_penjualan_detail = AktReturPenjualanDetail::find()->where(['id_retur_penjualan' => $model->id_retur_penjualan])->all();
        $model_penjualan = AktPenjualan::findOne($model->id_penjualan);

        $jurnal_umum = new AktJurnalUmum();
        $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();
        $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
        $jurnal_umum->tipe = 1;
        $jurnal_umum->tanggal = date('Y-m-d');
        $jurnal_umum->keterangan = 'Retur Penjualan : ' .  $model_penjualan->no_penjualan;
        $jurnal_umum->save(false);
        // End Create Jurnal Umum

        $qty_x_hpp = 0;
        $total_harga_semua_retur = 0;

        foreach ($query_retur_penjualan_detail as $key => $data) {
            $penjualan_detail = AktPenjualanDetail::findOne($data['id_penjualan_detail']);
            $query_retur_penjualan_detail_ = AktReturPenjualanDetail::find()->where(['id_penjualan_detail' => $data['id_penjualan_detail']])->one();
            $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
            $item_stok->qty = $item_stok->qty + $query_retur_penjualan_detail_->retur;

            $qty_x_hpp += ($penjualan_detail['harga'] * $data['retur']);

            $item_stok->save(false);


            $diskon_pembelian = $penjualan_detail->diskon == NULL ? 0 : $penjualan_detail->diskon;
            $diskon = $diskon_pembelian / 100 * $penjualan_detail['harga'];
            $harga_per_item = $penjualan_detail['harga'] - $diskon;
            $diskon_keseluruhan = $model_penjualan->diskon / 100 * $harga_per_item;

            $harga_diskon_keseluruhan = $harga_per_item - $diskon_keseluruhan;

            $total = $harga_diskon_keseluruhan * $data['retur'];
            $total_harga_semua_retur += $total;
        }


        $pajak = 0.1 * $total_harga_semua_retur;

        if ($model_penjualan->pajak == 1) {
            $ppn = $pajak;
            $hutang_usaha = $total_harga_semua_retur + $ppn;
        } else {
            $ppn = 0;
            $hutang_usaha = $total_harga_semua_retur;
        }




        // Debit
        if ($model_penjualan->jenis_bayar == 1) {
            $jurnal_transaksi_detail = AktReturPenjualan::getJurnalTransaksi('Retur Penjualan Transaksi Cash');
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
                    AktReturPenjualan::setfilterNamaAkun($akun, 'ppn keluaran', $jurnal_umum_detail, $ppn, $jt);
                    AktReturPenjualan::setfilterNamaAkun($akun, 'retur penjualan', $jurnal_umum_detail, $total_harga_semua_retur, $jt);
                    AktReturPenjualan::setfilterNamaAkun($akun, 'penjualan barang', $jurnal_umum_detail, $qty_x_hpp, $jt);
                    AktReturPenjualan::setfilterNamaAkun($akun, 'hpp', $jurnal_umum_detail, $qty_x_hpp, $jt);
                }
                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Retur Penjualan Transaksi Cash : ' .  $model->no_retur_penjualan;
                $jurnal_umum_detail->save(false);

                if ($akun->id_akun == 1) {
                    $history_transaksi_kas = new AktHistoryTransaksi();
                    $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                    $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                    $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                    $history_transaksi_kas->save(false);
                }
            }
        } else if ($model_penjualan->jenis_bayar == 2) {
            $jurnal_transaksi_detail = AktReturPenjualan::getJurnalTransaksi('Retur Penjualan Transaksi Kredit');
            foreach ($jurnal_transaksi_detail as $jt) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
                AktReturPenjualan::setfilterNamaAkun($akun, 'ppn keluaran', $jurnal_umum_detail, $ppn, $jt);
                AktReturPenjualan::setfilterNamaAkun($akun, 'retur penjualan', $jurnal_umum_detail, $total_harga_semua_retur, $jt);
                AktReturPenjualan::setfilterNamaAkun($akun, 'penjualan barang', $jurnal_umum_detail, $qty_x_hpp, $jt);
                AktReturPenjualan::setfilterNamaAkun($akun, 'piutang usaha', $jurnal_umum_detail, $hutang_usaha, $jt);
                AktReturPenjualan::setfilterNamaAkun($akun, 'hpp', $jurnal_umum_detail, $qty_x_hpp, $jt);

                $akun->save(false);
                $jurnal_umum_detail->keterangan = 'Retur Penjualan Transaksi Kredit : ' .  $model->no_retur_penjualan;
                $jurnal_umum_detail->save(false);
            }
        }

        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_retur_penjualan';
        $history_transaksi->id_tabel = $model->id_retur_penjualan;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);

        $model_penjualan->total  = $model_penjualan->total - $hutang_usaha;
        $model_penjualan->save(false);

        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 1;
        $model->total = $hutang_usaha;
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Retur ' . $model->no_retur_penjualan . ' Berhasil Disetujui']]);
        return $this->redirect(['view', 'id' => $model->id_retur_penjualan]);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 2;
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Retur ' . $model->no_retur_penjualan . ' Berhasil Ditolak']]);
        return $this->redirect(['view', 'id' => $model->id_retur_penjualan]);
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);
        $query_retur_penjualan_detail = AktReturPenjualanDetail::find()->where(['id_retur_penjualan' => $model->id_retur_penjualan])->all();
        foreach ($query_retur_penjualan_detail as $key => $data) {
            $penjualan_detail = AktPenjualanDetail::findOne($data['id_penjualan_detail']);
            $query_retur_penjualan_detail_ = AktReturPenjualanDetail::find()->where(['id_penjualan_detail' => $data['id_penjualan_detail']])->one();
            $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
            $item_stok->qty = $item_stok->qty - $query_retur_penjualan_detail_->retur;
            $item_stok->save(false);
        }

        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_retur_penjualan'])->count();

        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_retur_penjualan'])->one();
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
        $model_penjualan = AktPenjualan::findOne($model->id_penjualan);
        $model->tanggal_approve = NULL;
        $model->id_login = NULL;
        $model->status_retur = 0;
        $model_penjualan->total = $model_penjualan->total + $model->total;
        $model_penjualan->save(false);
        $model->total = 0;
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Retur ' . $model->no_retur_penjualan . ' Berhasil Dipending']]);
        return $this->redirect(['view', 'id' => $model->id_retur_penjualan]);
    }

    public function actionPrintView($id)
    {
        $model = $this->findModel($id);
        $model_detail = AktReturPenjualanDetail::findAll(['id_retur_penjualan' => $model->id_retur_penjualan]);
        $setting = Setting::find()->one();
        $print =  $this->renderPartial('_print_view', [
            'model' => $model,
            'setting' => $setting,
            'model_detail' => $model_detail
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
        $data = AktPenjualan::findOne($id);
        echo Json::encode($data->jenis_bayar);
    }
}
