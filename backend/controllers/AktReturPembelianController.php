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

use backend\models\AktReturPembelianDetail;
use backend\models\AktPembelian;
use backend\models\AktItemStok;
use backend\models\AktPembelianDetail;
use yii\helpers\ArrayHelper;
use backend\models\Foto;
use backend\models\Setting;
use Mpdf\Mpdf;

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

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_retur_pembelian FROM akt_retur_pembelian ORDER by no_retur_pembelian DESC LIMIT 1")->queryScalar();
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            if ($bulanNoUrut == date('ym')) {
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
                $no_retur_pembelian = "RB" . date('ym') . $noUrut_2;
                $kode = $no_retur_pembelian;
            } else {
                $kode = 'RB' . date('ym') . '001';
            }
        } else {
            $kode = 'RB' . date('ym') . '001';
        }

        $model->no_retur_pembelian = $kode;
        $subQuery = AktReturPembelian::find()->select('id_pembelian');
        $data_penerimaan = ArrayHelper::map(
            AktPembelian::find()
                ->where([">", 'status', 3])
                ->andWhere(['IS NOT', 'no_pembelian', NULL])
                ->andWhere(['NOT IN', 'id_pembelian', $subQuery])
                ->all(),
            'id_pembelian',
            'no_pembelian'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_retur_pembelian . ' Berhasil Tersimpan di Data Retur Pembelian']]);
            return $this->redirect(['view', 'id' => $model->id_retur_pembelian]);
        }

        return $this->render('create', [
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

        $subQuery = AktReturPembelian::find()->select('id_pembelian');
        $data_penerimaan = ArrayHelper::map(
            AktPembelian::find()
                ->where([">", 'status', 3])
                ->andWhere(['IS NOT', 'no_pembelian', NULL])
                // ->andWhere(['NOT IN', 'id_pembelian', $subQuery])
                ->all(),
            'id_pembelian',
            'no_pembelian'
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data ' . $model->no_retur_pembelian . ' Berhasil Tersimpan di Data Retur Pembelian']]);
            return $this->redirect(['view', 'id' => $model->id_retur_pembelian]);
        }

        return $this->render('update', [
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        $jurnal_umum->keterangan = 'Retur Pembelian : ' .  $model->no_retur_pembelian;
        $jurnal_umum->save(false);
        // End Create Jurnal Umum

        $jurnal_transaksi = JurnalTransaksi::find()->where(['nama_transaksi' => 'Retur Pembelian'])->one();
        $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $jurnal_transaksi['id_jurnal_transaksi']])->all();

        $grandtotal = 0;

        foreach ($query_retur_pembelian_detail as $key => $data) {
            $pembelian_detail = AktPembelianDetail::findOne($data['id_pembelian_detail']);
            $query_retur_pembelian_detail_ = AktReturPembelianDetail::find()->where(['id_pembelian_detail' => $data['id_pembelian_detail']])->one();
            $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
            $item_stok->qty = $item_stok->qty - $query_retur_pembelian_detail_->retur;
            $item_stok->save(false);

            $grandtotal += $pembelian_detail['harga'] * $data['retur'];
        }

        foreach ($jurnal_transaksi_detail as $jt) {
            $jurnal_umum_detail = new AktJurnalUmumDetail();
            $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail->id_akun = $jt->id_akun;
            $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();
            if ($jt->tipe == 'D') {
                $jurnal_umum_detail->debit = $grandtotal;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $grandtotal;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $grandtotal;
                }
            } else if ($jt->tipe == 'K') {
                $jurnal_umum_detail->kredit = $grandtotal;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun - $grandtotal;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $grandtotal;
                }
            }
            $akun->save(false);
            $jurnal_umum_detail->keterangan = 'Retur Pembelian : ' .  $model->no_retur_pembelian;
            $jurnal_umum_detail->save(false);
        }


        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_retur_pembelian';
        $history_transaksi->id_tabel = $model->id_retur_pembelian;
        $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);


        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 2;
        $model->save(FALSE);

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

        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_retur = 1;
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
}
