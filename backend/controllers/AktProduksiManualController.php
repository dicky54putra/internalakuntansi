<?php

namespace backend\controllers;

use Yii;
use backend\models\AktProduksiManual;
use backend\models\AktProduksiManualDetailBb;
use backend\models\AktProduksiManualDetailHp;
use backend\models\AktProduksiManualSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Setting;
use Mpdf\Mpdf;
use backend\models\AktAkun;
use yii\helpers\ArrayHelper;

/**
 * AktProduksiManualController implements the CRUD actions for AktProduksiManual model.
 */
class AktProduksiManualController extends Controller
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
     * Lists all AktProduksiManual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktProduksiManualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktProduksiManual model.
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
     * Creates a new AktProduksiManual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktProduksiManual();
        $model->tanggal = date('Y-m-d');
        $model_akun = new AktAkun();
        $data_akun = ArrayHelper::map(AktAkun::find()->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });

        // $total = AktProduksiManual::find()->count();
        // $nomor = 'PM' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);
        $model->status_produksi = 1;
        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_produksi_manual FROM `akt_produksi_manual` ORDER by no_produksi_manual DESC LIMIT 1")->queryScalar();
        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            // echo $noUrut; die;
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'PM' . date('ym') . '001';
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

                $no_produksi_manual = "PM" . date('ym') . $noUrut_2;
                $kode = $no_produksi_manual;
            }
        } else {
            # code...
            $kode = 'PM' . date('ym') . '001';
        }

        $nomor = $kode;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_produksi_manual]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
            'data_akun' => $data_akun
        ]);
    }

    /**
     * Updates an existing AktProduksiManual model.
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

        $nomor = $model->no_produksi_manual;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_produksi_manual]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'data_akun' => $data_akun
        ]);
    }

    public function actionTutup($id)
    {
        $hp = Yii::$app->db->createCommand("SELECT * FROM akt_produksi_manual_detail_bb WHERE id_produksi_manual = '$id'")->query();
        foreach ($hp as $data) {
            $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = qty + '$data[qty]' WHERE id_item_stok = '$data[id_item_stok]'")->execute();
        }
        $status = Yii::$app->db->createCommand("UPDATE akt_produksi_manual SET status_produksi = 1 WHERE id_produksi_manual = '$id'")->execute();
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing AktProduksiManual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $cek_bb = Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_produksi_manual_detail_bb WHERE id_produksi_manual = '$id'")->queryScalar();
        $cek_hp = Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_produksi_manual_detail_hp WHERE id_produksi_manual = '$id'")->queryScalar();

        if ($model->status_produksi == 1) {
            $bb = AktProduksiManualDetailBb::find()
                ->where(['id_produksi_manual' => $id])
                ->one();
            $hp = AktProduksiManualDetailHp::find()
                ->where(['id_produksi_manual' => $id])
                ->one();
            if ($cek_hp > 0) $hp->delete();
            if ($cek_bb > 0) $bb->delete();
            $model->delete();
        } else if ($model->status_produksi == 0) {
            if ($cek_bb > 0 || $cek_hp > 0) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Bahan Baku dan Hasil Produksi ini, masih ada!']]);
            }
        }
        return $this->redirect(['index']);
    }

    public function actionPrint($id)
    {
        // $daftar_item = ItemPermintaanPembelian::find()->where(['id_permintaan_pembelian' => $id])->all();
        $setting = Setting::find()->one();
        $print =  $this->renderPartial('_print_view', [
            // return $this->renderPartial('request_print', [
            'model' => $this->findModel($id),
            'setting' => $setting,
        ]);
        $mPDF = new mPDF([
            'orientation' => 'L',
        ]);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }

    /**
     * Finds the AktProduksiManual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktProduksiManual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktProduksiManual::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
