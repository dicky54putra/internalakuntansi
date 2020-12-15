<?php

namespace backend\controllers;

use Yii;
use backend\models\AktStokMasuk;
use backend\models\AktStokMasukSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktAkun;
use backend\models\AktHistoryTransaksi;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktStokMasukDetail;
use backend\models\AktItemStok;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use yii\helpers\ArrayHelper;

/**
 * AktStokMasukController implements the CRUD actions for AktStokMasuk model.
 */
class AktStokMasukController extends Controller
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
     * Lists all AktStokMasuk models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktStokMasukSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktStokMasuk model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model_stok_detail = new AktStokMasukDetail();
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item_stok.qty", "akt_item.nama_item", "akt_gudang.nama_gudang"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return $model['nama_item'] . ' - Gudang : ' . $model['nama_gudang'] . ' - Stok : ' . $model['qty'];
            }
        );
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_stok_detail' => $model_stok_detail,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    /**
     * Creates a new AktStokMasuk model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktStokMasuk();
        $model->tanggal_masuk = date('Y-m-d');

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT nomor_transaksi FROM `akt_stok_masuk` ORDER by nomor_transaksi DESC LIMIT 1")->queryScalar();

        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'SM' . date('ym') . '001';
            } else {
                // echo $noUrut; die;
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

                $nomor_transaksi = "SM" . date('ym') . $noUrut_2;
                $kode = $nomor_transaksi;
            }
        } else {
            # code...
            $kode = 'SM' . date('ym') . '001';
        }
        $model->nomor_transaksi = $kode;

        $model_akun = new AktAkun();
        $data_akun = ArrayHelper::map(AktAkun::find()->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });

        if ($model->load(Yii::$app->request->post())) {


            // Create Jurnal Umum 

            $jurnal_umum = new AktJurnalUmum();
            $akt_jurnal_umum = AktJurnalUmum::find()->select(["no_jurnal_umum"])->orderBy("id_jurnal_umum DESC")->limit(1)->one();
            if (!empty($akt_jurnal_umum->no_jurnal_umum)) {

                $no_bulan = substr($akt_jurnal_umum->no_jurnal_umum, 2, 4);

                if ($no_bulan == date('ym')) {

                    $noUrut = substr($akt_jurnal_umum->no_jurnal_umum, -3);
                    $noUrut++;
                    $noUrut_2 = sprintf("%03s", $noUrut);
                    $no_jurnal_umum = 'JU' . date('ym') . $noUrut_2;
                } else {

                    $no_jurnal_umum = 'JU' . date('ym') . '001';
                }
            } else {

                $no_jurnal_umum = 'JU' . date('ym') . '001';
            }

            $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
            $jurnal_umum->tipe = 1;
            $jurnal_umum->tanggal = $model->tanggal_masuk;
            $jurnal_umum->keterangan = 'Stok Masuk : ' . $kode;
            $jurnal_umum->save(false);

            // End Create Jurnal Umum

            $model->save();


            $stok_masuk = JurnalTransaksi::find()->where(['nama_transaksi' => 'Stok Masuk'])->one();
            $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $stok_masuk['id_jurnal_transaksi']])->all();

            foreach ($jurnal_transaksi_detail as $jt) {
                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;
                $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

                if ($akun->saldo_normal == 1 && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = 0;
                    $akun->saldo_akun = $akun->saldo_akun + 0;
                } else if ($akun->saldo_normal == 1 && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = 0;
                    $akun->saldo_akun = $akun->saldo_akun - 0;
                } else if ($akun->saldo_normal == 2 && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = 0;
                    $akun->saldo_akun = $akun->saldo_akun - 0;
                } else if ($akun->saldo_normal == 2 && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = 0;
                    $akun->saldo_akun = $akun->saldo_akun + 0;
                }

                $jurnal_umum_detail->keterangan = 'Stok Masuk : ' .  $model->nomor_transaksi;
                $akun->save();
                $jurnal_umum_detail->save(false);
            }


            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_stok_masuk';
            $history_transaksi->id_tabel = $model->id_stok_masuk;
            $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $history_transaksi->save(false);

            return $this->redirect(['view', 'id' => $model->id_stok_masuk]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_akun' => $data_akun,
        ]);
    }

    /**
     * Updates an existing AktStokMasuk model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model_akun = new AktAkun();
        $data_akun = ArrayHelper::map(AktAkun::find()->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_stok_masuk]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_akun' => $data_akun,
        ]);
    }

    /**
     * Deletes an existing AktStokMasuk model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $count_detail = AktStokMasukDetail::find()->where(['id_stok_masuk' => $model->id_stok_masuk])->count();

        if ($count_detail == 0) {

            $akt_history_transaksi = AktHistoryTransaksi::find()
                ->where(['id_tabel' => $id])
                ->andWhere(['nama_tabel' => 'akt_stok_masuk'])
                ->one();

            $jurnal_umum = AktJurnalUmum::find()
                ->where(['id_jurnal_umum' => $akt_history_transaksi['id_jurnal_umum']])
                ->one();

            $jurnal_umum_detail = AktJurnalUmumDetail::find()
                ->where(['id_jurnal_umum' => $akt_history_transaksi['id_jurnal_umum']])
                ->all();

            foreach ($jurnal_umum_detail as $ju) {
                $ju->delete();
            }


            $jurnal_umum->delete();
            $akt_history_transaksi->delete();

            $model->delete();
        } else {
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak Dapat Menghapus Data Karena Masih Ada Data Detail']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktStokMasuk model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktStokMasuk the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktStokMasuk::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
