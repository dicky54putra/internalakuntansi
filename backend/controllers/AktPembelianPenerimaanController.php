<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelianPenerimaan;
use backend\models\AktPembelianPenerimaanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\AktPembelian;
use backend\models\Setting;

/**
 * AktPembelianPenerimaanController implements the CRUD actions for AktPembelianPenerimaan model.
 */
class AktPembelianPenerimaanController extends Controller
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
     * Lists all AktPembelianPenerimaan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianPenerimaanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPembelianPenerimaan model.
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
     * Creates a new AktPembelianPenerimaan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPembelianPenerimaan();
        $model_pembelian = AktPembelian::findOne($_GET['id']);

        $sum_pembelian_detail = Yii::$app->db->createCommand("SELECT SUM(akt_pembelian_detail.qty) FROM akt_pembelian_detail WHERE id_pembelian = $model_pembelian->id_pembelian")->queryScalar();

        $sum_penerimaan_detail = Yii::$app->db->createCommand("SELECT SUM(qty_diterima) as qty_diterima FROM akt_pembelian_penerimaan_detail LEFT JOIN akt_pembelian_detail ON akt_pembelian_detail.id_pembelian_detail = akt_pembelian_penerimaan_detail.id_pembelian_detail WHERE akt_pembelian_detail.id_pembelian = $model_pembelian->id_pembelian")->queryScalar();

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_penerimaan FROM `akt_pembelian_penerimaan` ORDER by no_penerimaan DESC LIMIT 1")->queryScalar();
        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            // echo $noUrut; die;
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'PQ' . date('ym') . '001';
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

                $no_penerimaan = "PQ" . date('ym') . $noUrut_2;
                $kode = $no_penerimaan;
            }
        } else {
            # code...
            $kode = 'PQ' . date('ym') . '001';
        }

        $model->no_penerimaan = $kode;

        if ($model->load(Yii::$app->request->post())) {
            $model->foto_resi = UploadedFile::getInstance($model, 'foto_resi');
            $model->save();
            return $this->redirect(['akt-pembelian-penerimaan-sendiri/view', 'id' => $model_pembelian->id_pembelian]);
            // return $this->redirect(['akt-penjualan-pengiriman-parent/view', 'id' => $model->id_penjualan]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
            'model_pembelian' => $model_pembelian,
        ]);
    }

    /**
     * Updates an existing AktPembelianPenerimaan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->foto_resi = UploadedFile::getInstance($model, 'foto_resi');
            $model->save();
            return $this->redirect(['akt-pembelian-penerimaan-sendiri/view', 'id' => $model->id_pembelian]);
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'model_pembelian' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPembelianPenerimaan model.
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
     * Finds the AktPembelianPenerimaan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPembelianPenerimaan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPembelianPenerimaan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCetakSuratPengantar($id)
    {
        $model = $this->findModel($id);
        $data_setting = Setting::find()->one();

        return $this->renderPartial('cetak_surat_pengantar', [
            'model' => $model,

            'data_setting' => $data_setting,
        ]);
    }

    public function actionCetakLabelBarang($id)
    {
        $model = $this->findModel($id);
        $data_setting = Setting::find()->one();

        return $this->renderPartial('cetak_label_barang', [
            'model' => $model,

            'data_setting' => $data_setting,
        ]);
    }
}
