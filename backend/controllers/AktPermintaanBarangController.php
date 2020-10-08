<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPermintaanBarang;
use backend\models\AktPermintaanBarangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Setting;
use backend\models\AktPermintaanBarangPegawai;
use backend\models\AktPermintaanBarangDetail;
use backend\models\AktItem;
use yii\helpers\ArrayHelper;
use Mpdf\Mpdf;
/**
 * AktPermintaanBarangController implements the CRUD actions for AktPermintaanBarang model.
 */
class AktPermintaanBarangController extends Controller
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
     * Lists all AktPermintaanBarang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPermintaanBarangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPermintaanBarang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model_detail = new AktPermintaanBarangDetail();
        $data_item = ArrayHelper::map(AktItem::find()->all(), 'id_item','nama_item');
        $model_detail->id_permintaan_barang = $model->id_permintaan_barang;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model2' => $model_detail,
            'data_item' => $data_item
        ]);
    }

    /**
     * Creates a new AktPermintaanBarang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPermintaanBarang();
        $model->tanggal_permintaan = date('Y-m-d');
        // $id_penjualan_max = Yii::$app->db->createCommand("SELECT MAX(id_permintaan_barang) FROM akt_permintaan_barang")->queryScalar();
        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT nomor_permintaan FROM `akt_permintaan_barang` ORDER by nomor_permintaan DESC LIMIT 1")->queryScalar();

        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7,4);
            if($bulanNoUrut !== date('ym') ) {
                $kode = 'PB' . date('ym') . '001';
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
                
                $nomor_permintaan = "PB" . date('ym') . $noUrut_2;
                $kode = $nomor_permintaan;
            }
            
        } else {
            # code...
            $kode = 'PB' . date('ym') . '001';
        }
        $model->nomor_permintaan = $kode;
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_permintaan_barang]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPermintaanBarang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_permintaan_barang]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPermintaanBarang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $count_permintaan_barang_pegawai = AktPermintaanBarangPegawai::find()->where(['id_permintaan_barang' => $model->id_permintaan_barang])->count();
        $count_permintaan_barang_detail = AktPermintaanBarangDetail::find()->where(['id_permintaan_barang' => $model->id_permintaan_barang])->count();
        $sum_count = $count_permintaan_barang_pegawai + $count_permintaan_barang_detail;
        if ($sum_count == 0) {
            # code...
            $model->delete();
        } else {
            # code...
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak Dapat Menghapus Data Karena Masih Ada Data Detail']]);
        }
      
        return $this->redirect(['index']);
    }

    public function actionPrintView($id)
    {
        $daftar_permintaan = Yii::$app->db->createCommand("SELECT akt_permintaan_barang_detail.qty,akt_permintaan_barang_detail.qty_ordered,akt_permintaan_barang_detail.qty_rejected, akt_item.nama_item,akt_item.kode_item, akt_satuan.nama_satuan, akt_item_harga_jual.harga_satuan
        from akt_permintaan_barang_detail 
        LEFT JOIN akt_item ON akt_item.id_item = akt_permintaan_barang_detail.id_item
        LEFT JOIN akt_satuan ON akt_satuan.id_satuan = akt_item.id_satuan
        LEFT JOIN akt_item_harga_jual ON akt_item_harga_jual.id_item = akt_item.id_item
        WHERE id_permintaan_barang = '$id'
        ")->query();
        $setting = Setting::find()->one();
        $print =  $this->renderPartial('_print_view', [
            'model' => $this->findModel($id),
            'setting' => $setting,
            'daftar_permintaan' => $daftar_permintaan
        ]);
        $mPDF = new mPDF([
            'orientation' => 'L',
        ]);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }

    public function actionApprove($id)
    {
        $date = date("Y-m-d h:i:sa");
        $id_login =  Yii::$app->user->identity->id_login;
        $item_stok = Yii::$app->db->createCommand("UPDATE akt_permintaan_barang SET status_aktif = 1, tanggal_approve = '$date', id_login = '$id_login'  WHERE id_permintaan_barang = '$id'")->execute();
        return $this->redirect(['akt-permintaan-barang/view','id' => $id]);
    }

    public function actionReject($id)
    {
        $date = date("Y-m-d h:i:sa");
        $id_login =  Yii::$app->user->identity->id_login;
        $item_stok = Yii::$app->db->createCommand("UPDATE akt_permintaan_barang SET status_aktif = 2, tanggal_approve = '$date', id_login = '$id_login'  WHERE id_permintaan_barang = '$id'")->execute();
        return $this->redirect(['akt-permintaan-barang/view','id' => $id]);
    }

    public function actionPending($id)
    {
        $date = date("Y-m-d h:i:sa");
        $id_login =  Yii::$app->user->identity->id_login;
        $item_stok = Yii::$app->db->createCommand("UPDATE akt_permintaan_barang SET status_aktif = 0, tanggal_approve = '$date', id_login = '$id_login'  WHERE id_permintaan_barang = '$id'")->execute();
        return $this->redirect(['akt-permintaan-barang/view','id' => $id]);
    }

    /**
     * Finds the AktPermintaanBarang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPermintaanBarang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPermintaanBarang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
