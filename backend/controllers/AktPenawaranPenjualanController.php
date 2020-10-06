<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenawaranPenjualan;
use backend\models\AktPenawaranPenjualanDetail;
use backend\models\AktPenawaranPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktItemStok;
use backend\models\AktItemHargaJual;
use backend\models\AktItem;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\models\Setting;
use Mpdf\Mpdf;

/**
 * AktPenawaranPenjualanController implements the CRUD actions for AktPenawaranPenjualan model.
 */
class AktPenawaranPenjualanController extends Controller
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
     * Lists all AktPenawaranPenjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenawaranPenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenawaranPenjualan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->get('aksi') == "simpan_grand_total") {
            $penawaran_penjualan = $this->findModel($id);
            $penawaran_penjualan->pajak = (Yii::$app->request->post("pajak") == 1) ? 10 : 0;
            $penawaran_penjualan->diskon = (!empty(Yii::$app->request->post("diskon"))) ? Yii::$app->request->post("diskon") : 0;

            $query = (new \yii\db\Query())->from('akt_penawaran_penjualan_detail')->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan]);
            $sum_sub_total = $query->sum('sub_total');

            $nilai_diskon = ($sum_sub_total * $penawaran_penjualan->diskon) / 100;
            $nilai_pajak = ($penawaran_penjualan->pajak > 0) ? (($sum_sub_total - $nilai_diskon) * $penawaran_penjualan->pajak) / 100 : 0;
            $nilai_total = ($sum_sub_total - $nilai_diskon) + $nilai_pajak;

            $penawaran_penjualan->total = $nilai_total;
            $penawaran_penjualan->save(false);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan ' . $penawaran_penjualan->no_penawaran_penjualan . ' Berhasil Tersimpan']]);
            return $this->redirect(['view', 'id' => $id]);
        }

        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty", "akt_satuan.nama_satuan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->leftJoin("akt_satuan", "akt_satuan.id_satuan = akt_item.id_satuan")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        $model_penawaran_penjualan_detail_baru = new AktPenawaranPenjualanDetail();
        $model_penawaran_penjualan_detail_baru->id_penawaran_penjualan = $model->id_penawaran_penjualan;
        $model_penawaran_penjualan_detail_baru->diskon = 0;

        return $this->render('view', [
            'model' => $model,
            'model_penawaran_penjualan_detail_baru' => $model_penawaran_penjualan_detail_baru,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    public function actionLevelHarga() {
        $country_id = $_POST['depdrop_parents'][0];
        $state = Yii::$app->db->createCommand("
        SELECT akt_item_harga_jual.id_item_harga_jual, akt_item_harga_jual.harga_satuan, akt_level_harga.keterangan FROM akt_item_stok 
        LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item 
        LEFT JOIN akt_item_harga_jual ON akt_item_harga_jual.id_item = akt_item.id_item
        Left JOIN akt_level_harga ON akt_level_harga.id_level_harga = akt_item_harga_jual.id_level_harga
        WHERE id_item_stok = '$country_id'")->query();
        $all_state = array();
        $i = 0;
        foreach ($state as $value) {
            $all_state[$i]['id'] = empty($value['id_item_harga_jual']) ? 0 : $value['id_item_harga_jual'];
            $all_state[$i]['name'] = empty($value['keterangan']) ? 'Data Kosong' : $value['keterangan'];
            $i++;
        }
        
        echo Json::encode(['output' => $all_state, 'selected' => '']);
        return;
    }
    
    public function actionGetHargaItem($id)
    {
        $item_stok = AktItemHargaJual::find()->where(['id_item_harga_jual' => $id])->one();
        echo Json::encode($item_stok);
    }



    /**
     * Creates a new AktPenawaranPenjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenawaranPenjualan();
        $model->tanggal = date('Y-m-d');
        $model->id_mata_uang = 1;
        $akt_penawaran_penjualan_terakhir = AktPenawaranPenjualan::find()->select(["no_penawaran_penjualan"])->orderBy("id_penawaran_penjualan DESC")->limit(1)->one();
        if (!empty($akt_penawaran_penjualan_terakhir->no_penawaran_penjualan)) {
            # code...
            $no_bulan = substr($akt_penawaran_penjualan_terakhir->no_penawaran_penjualan, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_penawaran_penjualan_terakhir->no_penawaran_penjualan, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_penawaran_penjualan = 'PP' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_penawaran_penjualan = 'PP' . date('ym') . '001';
            }
        } else {
            # code...
            $no_penawaran_penjualan = 'PP' . date('ym') . '001';
        }

        $model->no_penawaran_penjualan = $no_penawaran_penjualan;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penawaran_penjualan]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPenawaranPenjualan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penawaran_penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktPenawaranPenjualan model.
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

    public function actionPrintView($id)
    {
        $daftar_item = AktPenawaranPenjualanDetail::find()->where(['id_penawaran_penjualan' => $id])->all();
        $count_daftar_item = AktPenawaranPenjualanDetail::find()->where(['id_penawaran_penjualan' => $id])->count();
        $penawaran_penjualan = AktPenawaranPenjualan::find()->where(['id_penawaran_penjualan' => $id])->one();
        $setting = Setting::find()->one();
        $print =  $this->renderPartial('_print_view', [
            // return $this->renderPartial('request_print', [
            'model' => $this->findModel($id),
            'daftar_item' => $daftar_item,
            'setting' => $setting,
            'penawaran_penjualan' => $penawaran_penjualan,
            'count_daftar_item' => $count_daftar_item,
        ]);
        $mPDF = new mPDF([
            'orientation' => 'P',
        ]);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }

    /**
     * Finds the AktPenawaranPenjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenawaranPenjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenawaranPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionApprove($id, $id_login)
    {
        $model = $this->findModel($id);
        $model->the_approver = $id_login;
        $model->status = 2;
        $model->tanggal_approve = date('Y-m-d H:i:s');
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Melakukan Approving']]);
        return $this->redirect(['view', 'id' => $model->id_penawaran_penjualan]);
    }

    public function actionReject($id, $id_login)
    {
        $model = $this->findModel($id);
        $model->the_approver = $id_login;
        $model->status = 3;
        $model->tanggal_approve = date('Y-m-d H:i:s');
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Melakukan Rejecting']]);
        return $this->redirect(['view', 'id' => $model->id_penawaran_penjualan]);
    }

    public function actionPending($id, $id_login)
    {
        $model = $this->findModel($id);
        $model->the_approver = NULL;
        $model->status = 1;
        $model->tanggal_approve = NULL;
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Berhasil Melakukan Rejecting']]);
        return $this->redirect(['view', 'id' => $model->id_penawaran_penjualan]);
    }
}
