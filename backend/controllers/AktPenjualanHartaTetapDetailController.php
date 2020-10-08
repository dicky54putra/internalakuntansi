<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualanHartaTetapDetail;
use backend\models\AktPenjualanHartaTetapDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktPenjualanHartaTetap;
use yii\helpers\ArrayHelper;
use backend\models\AktItemStok;
use backend\models\AktPembelianHartaTetapDetail;
use yii\helpers\Json;

/**
 * AktPenjualanHartaTetapDetailController implements the CRUD actions for AktPenjualanHartaTetapDetail model.
 */
class AktPenjualanHartaTetapDetailController extends Controller
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
     * Lists all AktPenjualanHartaTetapDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenjualanHartaTetapDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenjualanHartaTetapDetail model.
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
     * Creates a new AktPenjualanHartaTetapDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenjualanHartaTetapDetail();

        if ($model->load(Yii::$app->request->post())) {

            $model_harga_post = Yii::$app->request->post('AktPenjualanHartaTetapDetail')['harga'];
            $model->harga = preg_replace('/\D/', '', $model_harga_post);

            $diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
            $model->total = ($model->qty * $model->harga) - $diskon_a;

            $count_barang = AktPenjualanHartaTetapDetail::find()->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap])->andWhere(['id_pembelian_harta_tetap_detail' => $model->id_pembelian_harta_tetap_detail])->count();

            if ($count_barang == 0) {
                # code...
                $model->save();

                # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                $query = (new \yii\db\Query())->from('akt_penjualan_harta_tetap_detail')->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
                $total_penjualan_harta_tetap_detail = $query->sum('total');

                # get data penjualan, 
                $data_penjualan_harta_tetap = AktPenjualanHartaTetap::findOne($model->id_penjualan_harta_tetap);
                $diskon = ($data_penjualan_harta_tetap->diskon > 0) ? ($data_penjualan_harta_tetap->diskon * $total_penjualan_harta_tetap_detail) / 100 : 0;
                $pajak = ($data_penjualan_harta_tetap->pajak == 1) ? (($total_penjualan_harta_tetap_detail - $diskon) * 10) / 100 : 0;
                $total_sementara = (($total_penjualan_harta_tetap_detail - $diskon) + $pajak) + $data_penjualan_harta_tetap->ongkir + $data_penjualan_harta_tetap->materai;
                $total_sebenarnya = $total_sementara - $data_penjualan_harta_tetap->uang_muka;
                $data_penjualan_harta_tetap->total = $total_sebenarnya;
                $data_penjualan_harta_tetap->save(FALSE);
            } else {
                # code...
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Barang Yang Di Input Sudah Terdaftar']]);
            }


            return $this->redirect(['akt-penjualan-harta-tetap/view', 'id' => $model->id_penjualan_harta_tetap]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktPenjualanHartaTetapDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $akt_penjualan_harta_tetap = AktPenjualanHartaTetap::findOne($model->id_penjualan_harta_tetap);

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
                return 'Nama Barang : ' . $model['nama_item'] . ', Satuan : ' . $model['nama_satuan'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        if ($model->load(Yii::$app->request->post())) {

            $count_barang = AktPenjualanHartaTetapDetail::find()->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap])->andWhere(['id_pembelian_harta_tetap_detail' => $model->id_pembelian_harta_tetap_detail])->count();

            $model_harga_post = Yii::$app->request->post('AktPenjualanHartaTetapDetail')['harga'];
            $model->harga = preg_replace('/\D/', '', $model_harga_post);

            $diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
            $model->total = ($model->qty * $model->harga) - $diskon_a;

            if ($model->id_pembelian_harta_tetap_detail == $model_sebelumnya->id_pembelian_harta_tetap_detail) {
                # code...
                $model->save();

                # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                $query = (new \yii\db\Query())->from('akt_penjualan_harta_tetap_detail')->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
                $total_penjualan_harta_tetap_detail = $query->sum('total');

                # get data penjualan, 
                $data_penjualan_harta_tetap = AktPenjualanHartaTetap::findOne($model->id_penjualan_harta_tetap);
                $diskon = ($data_penjualan_harta_tetap->diskon > 0) ? ($data_penjualan_harta_tetap->diskon * $total_penjualan_harta_tetap_detail) / 100 : 0;
                $pajak = ($data_penjualan_harta_tetap->pajak == 1) ? (($total_penjualan_harta_tetap_detail - $diskon) * 10) / 100 : 0;
                $total_sementara = (($total_penjualan_harta_tetap_detail - $diskon) + $pajak) + $data_penjualan_harta_tetap->ongkir + $data_penjualan_harta_tetap->materai;
                $total_sebenarnya = $total_sementara - $data_penjualan_harta_tetap->uang_muka;
                $data_penjualan_harta_tetap->total = $total_sebenarnya;
                $data_penjualan_harta_tetap->save(FALSE);
            } else {
                # code...
                if ($count_barang == 0) {
                    # code...
                    $model->save();

                    # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                    $query = (new \yii\db\Query())->from('akt_penjualan_harta_tetap_detail')->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
                    $total_penjualan_harta_tetap_detail = $query->sum('total');

                    # get data penjualan, 
                    $data_penjualan_harta_tetap = AktPenjualanHartaTetap::findOne($model->id_penjualan_harta_tetap);
                    $diskon = ($data_penjualan_harta_tetap->diskon > 0) ? ($data_penjualan_harta_tetap->diskon * $total_penjualan_harta_tetap_detail) / 100 : 0;
                    $pajak = ($data_penjualan_harta_tetap->pajak == 1) ? (($total_penjualan_harta_tetap_detail - $diskon) * 10) / 100 : 0;
                    $total_sementara = (($total_penjualan_harta_tetap_detail - $diskon) + $pajak) + $data_penjualan_harta_tetap->ongkir + $data_penjualan_harta_tetap->materai;
                    $total_sebenarnya = $total_sementara - $data_penjualan_harta_tetap->uang_muka;
                    $data_penjualan_harta_tetap->total = $total_sebenarnya;
                    $data_penjualan_harta_tetap->save(FALSE);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Barang Yang Di Input Sudah Terdaftar']]);
                }
            }


            return $this->redirect(['akt-penjualan-harta-tetap/view', 'id' => $model->id_penjualan_harta_tetap]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_item_stok' => $data_item_stok,
            'akt_penjualan_harta_tetap' => $akt_penjualan_harta_tetap,
        ]);
    }

    /**
     * Deletes an existing AktPenjualanHartaTetapDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
        $query = (new \yii\db\Query())->from('akt_penjualan_harta_tetap_detail')->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap]);
        $total_penjualan_harta_tetap_detail = $query->sum('total');

        # get data penjualan, 
        $data_penjualan_harta_tetap = AktPenjualanHartaTetap::findOne($model->id_penjualan_harta_tetap);
        $diskon = ($data_penjualan_harta_tetap->diskon > 0) ? ($data_penjualan_harta_tetap->diskon * $total_penjualan_harta_tetap_detail) / 100 : 0;
        $pajak = ($data_penjualan_harta_tetap->pajak == 1) ? (($total_penjualan_harta_tetap_detail - $diskon) * 10) / 100 : 0;
        $total_sementara = (($total_penjualan_harta_tetap_detail - $diskon) + $pajak) + $data_penjualan_harta_tetap->ongkir + $data_penjualan_harta_tetap->materai;
        $total_sebenarnya = $total_sementara - $data_penjualan_harta_tetap->uang_muka;
        $data_penjualan_harta_tetap->total = $total_sebenarnya;
        $data_penjualan_harta_tetap->save(FALSE);

        return $this->redirect(['akt-penjualan-harta-tetap/view', 'id' => $model->id_penjualan_harta_tetap]);
    }

    /**
     * Finds the AktPenjualanHartaTetapDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenjualanHartaTetapDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenjualanHartaTetapDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetHargaBarang($id)
    {
        $data_pembelian_harta_tetap_detail = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap_detail' => $id])->one();
        echo Json::encode($data_pembelian_harta_tetap_detail);
    }
}
