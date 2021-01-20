<?php

namespace backend\controllers;

use Yii;
use backend\models\AktTransferStok;
use backend\models\AktTransferStokSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktGudang;
use backend\models\AktItem;
use yii\helpers\ArrayHelper;
use backend\models\AktTransferStokDetail;

/**
 * AktTransferStokController implements the CRUD actions for AktTransferStok model.
 */
class AktTransferStokController extends Controller
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
     * Lists all AktTransferStok models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktTransferStokSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktTransferStok model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model_transfer_detail = new AktTransferStokDetail();
        $akt_transfer_stok = AktTransferStok::findOne($id);
        $data_item = ArrayHelper::map(
            AktItem::find()
                ->select(["akt_item.nama_item", "akt_item.id_item", "akt_item_stok.qty"])
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item = akt_item.id_item")
                ->where("akt_item_stok.id_gudang IN ($akt_transfer_stok->id_gudang_asal, $akt_transfer_stok->id_gudang_tujuan)")
                ->groupBy("akt_item_stok.id_item")
                ->having("count(*) = 2")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item',
            function ($model) {
                return $model['nama_item'];
            }
        );
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_transfer_detail' => $model_transfer_detail,
            'data_item' => $data_item,
        ]);
    }

    /**
     * Creates a new AktTransferStok model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktTransferStok();
        $model->tanggal_transfer = date('Y-m-d');

        # untuk create gudang asal & gudang tujuan tidak di disabled
        $disabled = false;

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_transfer FROM `akt_transfer_stok` ORDER by no_transfer DESC LIMIT 1")->queryScalar();

        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7,4);
            if($bulanNoUrut !== date('ym') ) {
                $kode = 'TS' . date('ym') . '001';
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
                
                $no_transfer = "TS" . date('ym') . $noUrut_2;
                $kode = $no_transfer;
            }
            
        } else {
            # code...
            $kode = 'TS' . date('ym') . '001';
        }
        $model->no_transfer = $kode;

        $data_gudang = ArrayHelper::map(AktGudang::find()->all(), 'id_gudang', 'nama_gudang');

        if ($model->load(Yii::$app->request->post())) {

            # cek gudang
            if ($model->id_gudang_asal == $model->id_gudang_tujuan) {
                # code...
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Gudang Asal Tidak Boleh Sama Dengan Gudang Tujuan']]);
            } else {
                # code...
                $model->save();

                Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
                return $this->redirect(['view', 'id' => $model->id_transfer_stok]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'data_gudang' => $data_gudang,
            'disabled' => $disabled,
        ]);
    }

    /**
     * Updates an existing AktTransferStok model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        # untuk update gudang asal & gudang tujuan tergantung apakah sudah ada inputan detail, klo belum makan disable false
        $count_detail = AktTransferStokDetail::find()->where(['id_transfer_stok' => $model->id_transfer_stok])->count();
        $disabled = ($count_detail == 0) ? false : true;

        $data_gudang = ArrayHelper::map(AktGudang::find()->all(), 'id_gudang', 'nama_gudang');

        if ($model->load(Yii::$app->request->post())) {

            # cek gudang
            if ($model->id_gudang_asal == $model->id_gudang_tujuan) {
                # code...
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Gudang Asal Tidak Boleh Sama Dengan Gudang Tujuan']]);
            } else {
                # code...
                $model->save();

                Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Diubah']]);
                return $this->redirect(['view', 'id' => $model->id_transfer_stok]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'data_gudang' => $data_gudang,
            'disabled' => $disabled,
        ]);
    }

    /**
     * Deletes an existing AktTransferStok model.
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
     * Finds the AktTransferStok model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktTransferStok the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktTransferStok::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
