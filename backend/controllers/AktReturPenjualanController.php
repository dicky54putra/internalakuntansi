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
use yii\helpers\ArrayHelper;
use backend\models\Foto;
use backend\models\Setting;
use Mpdf\Mpdf;

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

        $data_penjualan_pengiriman_detail = ArrayHelper::map(
            AktPenjualanPengirimanDetail::find()
                ->select(["akt_penjualan_pengiriman_detail.id_penjualan_pengiriman_detail", "akt_item.nama_item", "akt_penjualan_pengiriman_detail.qty_dikirim"])
                ->leftJoin("akt_penjualan_detail", "akt_penjualan_detail.id_penjualan_detail = akt_penjualan_pengiriman_detail.id_penjualan_detail")
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item_stok = akt_penjualan_detail.id_item_stok")
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->where(['id_penjualan_pengiriman' => $model->id_penjualan_pengiriman])
                ->asArray()
                ->all(),
            'id_penjualan_pengiriman_detail',
            function ($model) {
                return $model['nama_item'] . ', Qty Dikirim : ' . $model['qty_dikirim'];
            }
        );

        $model_retur_penjualan_detail = new AktReturPenjualanDetail();
        $model_retur_penjualan_detail->id_retur_penjualan = $model->id_retur_penjualan;


        return $this->render('view', [
            'model' => $model,
            'model_retur_penjualan_detail' => $model_retur_penjualan_detail,
            'data_penjualan_pengiriman_detail' => $data_penjualan_pengiriman_detail,
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

        $akt_retur_penjualan = AktReturPenjualan::find()->select(["no_retur_penjualan"])->orderBy("id_retur_penjualan DESC")->limit(1)->one();
        if (!empty($akt_retur_penjualan->no_retur_penjualan)) {
            # code...
            $no_bulan = substr($akt_retur_penjualan->no_retur_penjualan, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_retur_penjualan->no_retur_penjualan, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_retur_penjualan = 'RP' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_retur_penjualan = 'RP' . date('ym') . '001';
            }
        } else {
            # code...
            $no_retur_penjualan = 'RP' . date('ym') . '001';
        }

        $model->no_retur_penjualan = $no_retur_penjualan;

        $data_penjualan_pengiriman = ArrayHelper::map(
            AktPenjualanPengiriman::find()
                ->where(['status' => 1])
                ->orderBy("no_pengiriman ASC")
                ->all(),
            'id_penjualan_pengiriman',
            'no_pengiriman'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_retur_penjualan . ' Berhasil Tersimpan di Data Retur Penjualan']]);
            return $this->redirect(['view', 'id' => $model->id_retur_penjualan]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_penjualan_pengiriman' => $data_penjualan_pengiriman,
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

        $data_penjualan_pengiriman = ArrayHelper::map(
            AktPenjualanPengiriman::find()
                ->where(['status' => 1])
                ->orderBy("no_pengiriman ASC")
                ->all(),
            'id_penjualan_pengiriman',
            'no_pengiriman'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data ' . $model->no_retur_penjualan . ' Berhasil Tersimpan di Data Retur Penjualan']]);
            return $this->redirect(['view', 'id' => $model->id_retur_penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_penjualan_pengiriman' => $data_penjualan_pengiriman,
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
        $jurnal_umum->keterangan = 'Retur Penjualan : ' .  $model->no_retur_penjualan;
        $jurnal_umum->save(false);
        // End Create Jurnal Umum

        $jurnal_transaksi = JurnalTransaksi::find()->where(['nama_transaksi' => 'Retur Penjualan'])->one();
        $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $jurnal_transaksi['id_jurnal_transaksi']])->all();

        $qty_x_hpp = 0;

        foreach ($query_retur_penjualan_detail as $key => $data) {

            $penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::findOne($data->id_penjualan_pengiriman_detail);

            $penjualan_detail = AktPenjualanDetail::findOne($penjualan_pengiriman_detail->id_penjualan_detail);
            $query_retur_penjualan_detail_ = AktReturPenjualanDetail::find()->where(['id_penjualan_pengiriman_detail' => $data['id_penjualan_pengiriman_detail']])->one();
            $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
            $item_stok->qty = $item_stok->qty + $query_retur_penjualan_detail_->retur;

            $qty_x_hpp += ($penjualan_detail['harga'] * $data['retur']);

            $item_stok->save(false);
        }

        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 1;
        $model->save(FALSE);

        foreach ($jurnal_transaksi_detail as $jt) {
            $jurnal_umum_detail = new AktJurnalUmumDetail();
            $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail->id_akun = $jt->id_akun;
            $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
            if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'D') {
                $jurnal_umum_detail->debit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                }
            } else if ($akun->nama_akun == 'Persediaan Barang Dagang' && $jt->tipe == 'K') {
                $jurnal_umum_detail->kredit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                }
            } else if ($akun->nama_akun == 'Retur Penjualan' && $jt->tipe == 'D') {
                $jurnal_umum_detail->debit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                }
            } else if ($akun->nama_akun == 'Retur Penjualan' && $jt->tipe == 'K') {
                $jurnal_umum_detail->kredit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                }
            } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'D') {
                $jurnal_umum_detail->debit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                }
            } else if ($akun->nama_akun == 'Piutang Usaha' && $jt->tipe == 'K') {
                $jurnal_umum_detail->kredit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                }
            } else if ($akun->nama_akun == 'HPP' && $jt->tipe == 'D') {
                $jurnal_umum_detail->debit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                }
            } else if ($akun->nama_akun == 'HPP' && $jt->tipe == 'K') {
                $jurnal_umum_detail->kredit = $qty_x_hpp;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun - $qty_x_hpp;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $qty_x_hpp;
                }
            }
            $akun->save(false);
            $jurnal_umum_detail->keterangan = 'Retur Penjualan : ' .  $model->no_retur_penjualan;
            $jurnal_umum_detail->save(false);
        }

        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_retur_penjualan';
        $history_transaksi->id_tabel = $model->id_retur_penjualan;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);



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

            $penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::findOne($data->id_penjualan_pengiriman_detail);

            $penjualan_detail = AktPenjualanDetail::findOne($penjualan_pengiriman_detail->id_penjualan_detail);
            $query_retur_penjualan_detail_ = AktReturPenjualanDetail::find()->where(['id_penjualan_pengiriman_detail' => $data['id_penjualan_pengiriman_detail']])->one();
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

        $model->tanggal_approve = NULL;
        $model->id_login = NULL;
        $model->status_retur = 0;
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
}
