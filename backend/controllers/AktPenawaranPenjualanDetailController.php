<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenawaranPenjualanDetail;
use backend\models\AktPenawaranPenjualanDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktItemHargaJual;
use backend\models\AktPenawaranPenjualan;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * AktPenawaranPenjualanDetailController implements the CRUD actions for AktPenawaranPenjualanDetail model.
 */
class AktPenawaranPenjualanDetailController extends Controller
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
     * Lists all AktPenawaranPenjualanDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenawaranPenjualanDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenawaranPenjualanDetail model.
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
     * Creates a new AktPenawaranPenjualanDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenawaranPenjualanDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penawaran_penjualan_detail]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateFromPenawaranPenjualan()
    {
        $model_id_penawaran_penjualan = Yii::$app->request->post('AktPenawaranPenjualanDetail')['id_penawaran_penjualan'];
        $model_id_item_stok = Yii::$app->request->post('AktPenawaranPenjualanDetail')['id_item_stok'];
        $model_qty = Yii::$app->request->post('AktPenawaranPenjualanDetail')['qty'];
        $_model_harga = Yii::$app->request->post('AktPenawaranPenjualanDetail')['harga'];
        $model_harga = preg_replace('/\D/', '', $_model_harga);
        $model_diskon = Yii::$app->request->post('AktPenawaranPenjualanDetail')['diskon'];
        $model_keterangan = Yii::$app->request->post('AktPenawaranPenjualanDetail')['keterangan'];
        $model_id_item_harga_jual = Yii::$app->request->post('AktPenawaranPenjualanDetail')['id_item_harga_jual'];

        $sub_total_sementara = $model_qty * $model_harga;
        $nilai_diskon = ($sub_total_sementara * $model_diskon) / 100;
        $sub_total_akhir = $sub_total_sementara - $nilai_diskon;

        $model = new AktPenawaranPenjualanDetail();
        $model->id_penawaran_penjualan = $model_id_penawaran_penjualan;
        $model->id_item_stok = $model_id_item_stok;
        $model->qty = $model_qty;
        $model->harga = $model_harga;
        $model->diskon = $model_diskon;
        $model->sub_total = $sub_total_akhir;
        $model->keterangan = $model_keterangan;
        $model->id_item_harga_jual = $model_id_item_harga_jual;

        $count_barang = AktPenawaranPenjualanDetail::find()->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan])->andWhere(['id_item_stok' => $model->id_item_stok])->andWhere(['id_item_harga_jual' => $model->id_item_harga_jual])->count();

        $item_stok = AktItemStok::findOne($model->id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        if ($count_barang == 0) {
            # code...
          
                $model->save();

                $penawaran_penjualan = AktPenawaranPenjualan::find()->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan])->one();

                $query = (new \yii\db\Query())->from('akt_penawaran_penjualan_detail')->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan]);
                $sum_sub_total = $query->sum('sub_total');

                $nilai_diskon = ($sum_sub_total * $penawaran_penjualan->diskon) / 100;
                $nilai_pajak = ($penawaran_penjualan->pajak > 0) ? (($sum_sub_total - $nilai_diskon) * $penawaran_penjualan->pajak) / 100 : 0;
                $nilai_total = ($sum_sub_total - $nilai_diskon) + $nilai_pajak;

                $penawaran_penjualan->total = $nilai_total;
                $penawaran_penjualan->save(false);

                Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil Tersimpan di Data Barang Penawaran Penjualan']]);
            
        } else {
            # code...
            Yii::$app->session->setFlash('danger', [['Perhatian !', '' . $item->nama_item . ' Sudah Terdaftar di Data Barang Penawaran Penjualan']]);
        }

        return $this->redirect(['akt-penawaran-penjualan/view', 'id' => $model->id_penawaran_penjualan]);
    }

    /**
     * Updates an existing AktPenawaranPenjualanDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $akt_penawaran_penjualan = AktPenawaranPenjualan::findOne($model->id_penawaran_penjualan);
        $akt_item_harga_jual = AktItemHargaJual::findOne($model->id_item_harga_jual);
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

        $data_level = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_harga_jual.id_item_harga_jual","akt_item_harga_jual.harga_satuan","akt_level_harga.keterangan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_item_harga_jual", "akt_item_harga_jual.id_item = akt_item.id_item")
                ->leftJoin("akt_level_harga", "akt_level_harga.id_level_harga = akt_item_harga_jual.id_level_harga")
                ->where(['akt_item.id_item' => $akt_item_harga_jual->id_item])
                ->asArray()
                ->all(),
            'id_item_harga_jual',function ($model) {
                return $model['keterangan'];
            }
        );

        if ($model->load(Yii::$app->request->post())) {
            $_model_harga = Yii::$app->request->post('AktPenawaranPenjualanDetail')['harga'];
            $model_harga = preg_replace('/\D/', '', $_model_harga);
            $model->harga = $model_harga;
            $count_barang = AktPenawaranPenjualanDetail::find()->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan])->andWhere(['id_item_stok' => $model->id_item_stok])->andWhere(['id_item_harga_jual' => $model->id_item_harga_jual])->count();
            $item_stok = AktItemStok::findOne($model->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $sub_total_sementara = $model->qty * $model->harga;
                $nilai_diskon = ($sub_total_sementara * $model->diskon) / 100;
                $sub_total_akhir = $sub_total_sementara - $nilai_diskon;
                $model->sub_total = $sub_total_akhir;
                $model->save();

                $penawaran_penjualan = AktPenawaranPenjualan::find()->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan])->one();

                $query = (new \yii\db\Query())->from('akt_penawaran_penjualan_detail')->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan]);
                $sum_sub_total = $query->sum('sub_total');

                $nilai_diskon = ($sum_sub_total * $penawaran_penjualan->diskon) / 100;
                $nilai_pajak = ($penawaran_penjualan->pajak > 0) ? (($sum_sub_total - $nilai_diskon) * $penawaran_penjualan->pajak) / 100 : 0;
                $nilai_total = ($sum_sub_total - $nilai_diskon) + $nilai_pajak;

                $penawaran_penjualan->total = $nilai_total;
                $penawaran_penjualan->save(false);

                Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan ' . $item->nama_item . ' Berhasil Tersimpan di Data Barang Penawaran Penjualan']]);
            } else {
                # code...
                if ($count_barang == 0) {
                    # code...
                    $sub_total_sementara = $model->qty * $model->harga;
                    $nilai_diskon = ($sub_total_sementara * $model->diskon) / 100;
                    $sub_total_akhir = $sub_total_sementara - $nilai_diskon;
                    $model->sub_total = $sub_total_akhir;
                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil Tersimpan di Data Barang Penawaran Penjualan']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian !', '' . $item->nama_item . ' Sudah Terdaftar di Data Barang Penawaran Penjualan']]);
                }
            }


            return $this->redirect(['akt-penawaran-penjualan/view', 'id' => $model->id_penawaran_penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_item_stok' => $data_item_stok,
            'data_level' => $data_level,
            'akt_penawaran_penjualan' => $akt_penawaran_penjualan,
        ]);
    }

    /**
     * Deletes an existing AktPenawaranPenjualanDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        $penawaran_penjualan = AktPenawaranPenjualan::find()->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan])->one();

        $query = (new \yii\db\Query())->from('akt_penawaran_penjualan_detail')->where(['id_penawaran_penjualan' => $model->id_penawaran_penjualan]);
        $sum_sub_total = $query->sum('sub_total');

        $nilai_diskon = ($sum_sub_total * $penawaran_penjualan->diskon) / 100;
        $nilai_pajak = ($penawaran_penjualan->pajak > 0) ? (($sum_sub_total - $nilai_diskon) * $penawaran_penjualan->pajak) / 100 : 0;
        $nilai_total = ($sum_sub_total - $nilai_diskon) + $nilai_pajak;

        $penawaran_penjualan->total = $nilai_total;
        $penawaran_penjualan->save(false);

        $item_stok = AktItemStok::findOne($model->id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil Terhapus dari Data Barang Penawaran Penjualan']]);
        return $this->redirect(['akt-penawaran-penjualan/view', 'id' => $model->id_penawaran_penjualan]);
    }

    /**
     * Finds the AktPenawaranPenjualanDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenawaranPenjualanDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenawaranPenjualanDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
