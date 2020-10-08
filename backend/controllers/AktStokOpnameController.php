<?php

namespace backend\controllers;

use Yii;
use backend\models\AktStokOpname;
use backend\models\AktStokOpnameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktAkun;
use backend\models\AktPegawai;
use backend\models\AktItemStok;
use backend\models\AktStokOpnameDetail;
use yii\helpers\ArrayHelper;
use backend\models\AktHistoryTransaksi;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;

/**
 * AktStokOpnameController implements the CRUD actions for AktStokOpname model.
 */
class AktStokOpnameController extends Controller
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
     * Lists all AktStokOpname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktStokOpnameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktStokOpname model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model_opname_detail = new AktStokOpnameDetail();
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty"])
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
            'model_opname_detail' => $model_opname_detail,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    /**
     * Creates a new AktStokOpname model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktStokOpname();
        $model->tanggal_opname = date('Y-m-d');

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_transaksi FROM `akt_stok_opname` ORDER by no_transaksi DESC LIMIT 1")->queryScalar();

        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'SO' . date('ym') . '001';
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

                $no_transaksi = "SO" . date('ym') . $noUrut_2;
                $kode = $no_transaksi;
            }
        } else {
            # code...
            $kode = 'SO' . date('ym') . '001';
        }
        $model->no_transaksi = $kode;

        $model_akun = new AktAkun();
        $data_akun = ArrayHelper::map(AktAkun::find()->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });
        $data_pegawai = ArrayHelper::map(AktPegawai::find()->all(), 'id_pegawai', 'nama_pegawai');

        if ($model->load(Yii::$app->request->post())) {


            // Create Jurnal Umum 

            $jurnal_umum = new AktJurnalUmum();
            $akt_jurnal_umum = AktStokOpname::getJurnalUmum();


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
            $jurnal_umum->tanggal = date('Y-m-d');
            $jurnal_umum->save(false);

            // End Create Jurnal Umum

            $model->save();

            $jurnal_transaksi_detail = AktStokOpname::getJurnalTransaksi();

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

                $jurnal_umum_detail->keterangan = 'Stok opname : ' .  $model->no_transaksi;
                $akun->save();
                $jurnal_umum_detail->save(false);
            }


            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_stok_opname';
            $history_transaksi->id_tabel = $model->id_stok_opname;
            $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $history_transaksi->save(false);


            return $this->redirect(['view', 'id' => $model->id_stok_opname]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_akun' => $data_akun,
            'data_pegawai' => $data_pegawai,
        ]);
    }

    /**
     * Updates an existing AktStokOpname model.
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
        $data_pegawai = ArrayHelper::map(AktPegawai::find()->all(), 'id_pegawai', 'nama_pegawai');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_stok_opname]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_akun' => $data_akun,
            'data_pegawai' => $data_pegawai,
        ]);
    }

    /**
     * Deletes an existing AktStokOpname model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);

        $count_detail = AktStokOpnameDetail::find()->where(['id_stok_opname' => $model->id_stok_opname])->count();

        if ($count_detail == 0) {

            $akt_history_transaksi = AktStokOpname::getHistoryTransaksi($id);
            $jurnal_umum = AktStokOpname::getJurnalUmum($akt_history_transaksi['id_jurnal_umum']);
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
     * Finds the AktStokOpname model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktStokOpname the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktStokOpname::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
