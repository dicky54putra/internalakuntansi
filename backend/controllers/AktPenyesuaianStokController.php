<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenyesuaianStok;
use backend\models\AktPenyesuaianStokSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktAkun;
use backend\models\AktPenyesuaianStokDetail;
use backend\models\AktItemStok;
use backend\models\AktHistoryTransaksi;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktStokMasukDetail;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use yii\helpers\ArrayHelper;

/**
 * AktPenyesuaianStokController implements the CRUD actions for AktPenyesuaianStok model.
 */
class AktPenyesuaianStokController extends Controller
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
     * Lists all AktPenyesuaianStok models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenyesuaianStokSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenyesuaianStok model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model_penyesuain_stok_detail = new AktPenyesuaianStokDetail();
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item ASC")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return $model['nama_item'] . ' - Gudang : ' . $model['nama_gudang'] . ' - Stok : ' . $model['qty'];
            }
        );
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_penyesuain_stok_detail' =>  $model_penyesuain_stok_detail,
            'data_item_stok' => $data_item_stok
        ]);
    }

    /**
     * Creates a new AktPenyesuaianStok model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionGetHpp($id)
    {
        $harta_tetap = AktItemStok::find()
            ->select(["hpp", 'qty'])
            ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
            ->leftJoin("akt_item_harga_jual", "akt_item.id_item = akt_item_harga_jual.id_item")
            ->where(['id_item_stok' => $id])
            ->asArray()
            ->one();
        return json_encode($harta_tetap);
    }
    public function actionCreate()
    {
        $model = new AktPenyesuaianStok();
        $model->tanggal_penyesuaian = date('Y-m-d');

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_transaksi FROM `akt_penyesuaian_stok` ORDER by no_transaksi DESC LIMIT 1")->queryScalar();

        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -5, 2);
            if ($bulanNoUrut !== date('m')) {
                $kode = 'PS' . date('ym') . '001';
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

                $nomor_permintaan = "PS" . date('ym') . $noUrut_2;
                $kode = $nomor_permintaan;
            }
        } else {
            # code...
            $kode = 'PS' . date('ym') . '001';
        }

        $model->no_transaksi = $kode;

        if ($model->load(Yii::$app->request->post())) {


            // Create Jurnal Umum 

            $jurnal_umum = new AktJurnalUmum();
            $akt_jurnal_umum = $model->getJurnalUmum();


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
            $jurnal_umum->tanggal = $model->tanggal_penyesuaian;
            $jurnal_umum->keterangan = 'Penyesuaian Stok : ' . $kode;
            $jurnal_umum->save(false);

            // End Create Jurnal Umum

            $model->save();

            if ($model->tipe_penyesuaian == 0) {
                $tipe = "Pengurangan";
            } elseif ($model->tipe_penyesuaian == 1) {
                $tipe = "Penambahan";
            }

            $jurnal_transaksi_detail = $model->getJurnalTransaksi();

            foreach ($jurnal_transaksi_detail as $jt) {

                $jurnal_umum_detail = new AktJurnalUmumDetail();
                $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                $jurnal_umum_detail->id_akun = $jt->id_akun;

                $jurnal_umum_detail->debit = 0;
                $jurnal_umum_detail->kredit = 0;

                $jurnal_umum_detail->keterangan = 'Penyesuaian Stok : ' .  $model->no_transaksi . ' | ' . $tipe;

                $jurnal_umum_detail->save(false);
            }


            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_penyesuaian_stok';
            $history_transaksi->id_tabel = $model->id_penyesuaian_stok;
            $history_transaksi->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $history_transaksi->save(false);


            return $this->redirect(['view', 'id' => $model->id_penyesuaian_stok]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPenyesuaianStok model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penyesuaian_stok]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPenyesuaianStok model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $modelName = new AktPenyesuaianStok();
        $model = $this->findModel($id);

        $count_detail = AktPenyesuaianStokDetail::find()->where(['id_penyesuaian_stok' => $model->id_penyesuaian_stok])->count();

        if ($count_detail == 0) {

            $akt_history_transaksi = $modelName->getHistoryTransaksi($id);
            $jurnal_umum = $modelName->getJurnalUmum($akt_history_transaksi['id_jurnal_umum']);
            $jurnal_umum_detail = AktJurnalUmumDetail::find()
                ->where(['id_jurnal_umum' => $akt_history_transaksi['id_jurnal_umum']])
                ->all();

            foreach ($jurnal_umum_detail as $ju) {
                $ju->deleteAll();
            }

            $jurnal_umum->delete();
            $akt_history_transaksi->delete();

            $model->delete();
        } else {
            # code...
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak Dapat Menghapus Data Karena Masih Ada Data Detail']]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktPenyesuaianStok model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenyesuaianStok the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function findModel($id)
    {
        if (($model = AktPenyesuaianStok::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
