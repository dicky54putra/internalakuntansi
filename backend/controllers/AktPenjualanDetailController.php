<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualanDetail;
use backend\models\AktPenjualanDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktItemStok;
use backend\models\AktPenjualan;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\models\AktItem;
use backend\models\AktItemHargaJual;

/**
 * AktPenjualanDetailController implements the CRUD actions for AktPenjualanDetail model.
 */
class AktPenjualanDetailController extends Controller
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
     * Lists all AktPenjualanDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenjualanDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenjualanDetail model.
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
     * Creates a new AktPenjualanDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPenjualanDetail();
        $model->id_penjualan = $_GET['id'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_penjualan_detail]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateFromOrderPenjualan()
    {
        # get data
        $model_id_penjualan = Yii::$app->request->post('AktPenjualanDetail')['id_penjualan'];
        $model_id_item_stok = Yii::$app->request->post('AktPenjualanDetail')['id_item_stok'];
        $model_qty = Yii::$app->request->post('AktPenjualanDetail')['qty'];
        $_model_harga = Yii::$app->request->post('AktPenjualanDetail')['harga'];
        $model_harga = preg_replace('/\D/', '', $_model_harga);
        $model_diskon = Yii::$app->request->post('AktPenjualanDetail')['diskon'];
        $model_id_item_harga_jual = Yii::$app->request->post('AktPenjualanDetail')['id_item_harga_jual'];

        $model_diskon_a = ($model_diskon > 0) ? (($model_qty * $model_harga) * $model_diskon) / 100 : 0;

        $model_total = ($model_qty * $model_harga) - $model_diskon_a;

        $model = new AktPenjualanDetail();
        $model->id_penjualan = $model_id_penjualan;
        $model->id_item_stok = $model_id_item_stok;
        $model->qty = $model_qty;
        $model->harga = $model_harga;
        $model->diskon = $model_diskon;
        $model->total = $model_total;
        $model->id_item_harga_jual = $model_id_item_harga_jual;
        $model->keterangan = Yii::$app->request->post('AktPenjualanDetail')['keterangan'];

        $count_barang = AktPenjualanDetail::find()->where(['id_penjualan' => $model_id_penjualan])->andWhere(['id_item_stok' => $model_id_item_stok])->andWhere(['id_item_harga_jual' => $model->id_item_harga_jual])->count();

        $item_stok = AktItemStok::findOne($model_id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        if ($count_barang == 0) {
            # code...
            $model->save();

            # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
            $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model_id_penjualan]);
            $total_penjualan_barang = $query->sum('total');

            # get data penjualan, 
            $data_penjualan = AktPenjualan::find()->where(['id_penjualan' => $model_id_penjualan])->one();
            $diskon = ($data_penjualan->diskon > 0) ? ($data_penjualan->diskon * $total_penjualan_barang) / 100 : 0;
            $pajak = ($data_penjualan->pajak == 1) ? (($total_penjualan_barang - $diskon) * 10) / 100 : 0;
            $total_sementara = (($total_penjualan_barang - $diskon) + $pajak) + $data_penjualan->ongkir + $data_penjualan->materai;
            $total_sebenarnya = $total_sementara - $data_penjualan->uang_muka;
            $data_penjualan->total = $total_sebenarnya;
            $data_penjualan->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil di Tambahkan ke Data Barang Penjualan']]);
        } else {
            # code...
            Yii::$app->session->setFlash('danger', [['Perhatian!', '' . $item->nama_item . ' Sudah Terdaftar di Data Barang Penjualan']]);
        }

        $button_submit =  Yii::$app->request->post('create-from-penjualan');
        if (isset($button_submit)) {
            $url = 'akt-penjualan-penjualan/view';
        } else {
            $url = 'akt-penjualan/view';
        }
        return $this->redirect([$url, 'id' => $model->id_penjualan]);
    }

    public function actionUpdateFromOrderPenjualan($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);
        $akt_penjualan = AktPenjualan::findOne($model->id_penjualan);
        $akt_item_harga_jual = AktItemHargaJual::findOne($model->id_item_harga_jual);
        $data_item_stok = AktPenjualan::data_item_stok();

        $data_level = AktPenjualan::dataLevel($akt_item_harga_jual->id_item);



        if ($model->load(Yii::$app->request->post())) {

            $_model_harga = Yii::$app->request->post('AktPenjualanDetail')['harga'];
            $model_harga = preg_replace('/\D/', '', $_model_harga);
            $model->harga = $model_harga;
            $count_barang = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->andWhere(['id_item_stok' => $model->id_item_stok])->andWhere(['id_item_harga_jual' => $model->id_item_harga_jual])->count();

            $item_stok = AktItemStok::findOne($model->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);

            $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
            $model->total = ($model->qty * $model->harga) - $model_diskon_a;

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $model->save();

                # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
                $total_penjualan_barang = $query->sum('total');

                # get data penjualan, 
                $data_penjualan = AktPenjualan::find()->where(['id_penjualan' => $model->id_penjualan])->one();
                $diskon = ($data_penjualan->diskon > 0) ? ($data_penjualan->diskon * $total_penjualan_barang) / 100 : 0;
                $pajak = ($data_penjualan->pajak == 1) ? (($total_penjualan_barang - $diskon) * 10) / 100 : 0;
                $total_sementara = (($total_penjualan_barang - $diskon) + $pajak) + $data_penjualan->ongkir + $data_penjualan->materai;
                $total_sebenarnya = $total_sementara - $data_penjualan->uang_muka;
                $data_penjualan->total = $total_sebenarnya;
                $data_penjualan->save(FALSE);

                Yii::$app->session->setFlash('success', [['Perhatian!', 'Perubahan ' . $item->nama_item . ' Berhasil di Simpan ke Data Barang Penjualan']]);
            } else {
                # code...
                if ($count_barang == 0) {
                    # code...
                    $model->save();

                    # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                    $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
                    $total_penjualan_barang = $query->sum('total');

                    # get data penjualan, 
                    $data_penjualan = AktPenjualan::find()->where(['id_penjualan' => $model->id_penjualan])->one();
                    $diskon = ($data_penjualan->diskon > 0) ? ($data_penjualan->diskon * $total_penjualan_barang) / 100 : 0;
                    $pajak = ($data_penjualan->pajak == 1) ? (($total_penjualan_barang - $diskon) * 10) / 100 : 0;
                    $total_sementara = (($total_penjualan_barang - $diskon) + $pajak) + $data_penjualan->ongkir + $data_penjualan->materai;
                    $total_sebenarnya = $total_sementara - $data_penjualan->uang_muka;
                    $data_penjualan->total = $total_sebenarnya;
                    $data_penjualan->save(FALSE);

                    Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil di Simpan ke Data Barang Penjualan']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', '' . $item->nama_item . ' Sudah Ada Di Order Penjualan : ' . $akt_penjualan->no_order_penjualan]]);
                }
            }

            return $this->redirect(['akt-penjualan/view', 'id' => $model->id_penjualan]);
        }

        return $this->render('update', [
            'model' => $model,
            'akt_penjualan' => $akt_penjualan,
            'data_item_stok' => $data_item_stok,
            'data_level' => $data_level,
        ]);
    }


    public function actionUpdateFromPenjualan($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);
        $akt_penjualan = AktPenjualan::findOne($model->id_penjualan);
        $akt_item_harga_jual = AktItemHargaJual::findOne($model->id_item_harga_jual);


        $data_item_stok = AktPenjualan::data_item_stok();

        $data_level = AktPenjualan::dataLevel($akt_item_harga_jual->id_item);

        if ($model->load(Yii::$app->request->post())) {

            $_model_harga = Yii::$app->request->post('AktPenjualanDetail')['harga'];
            $model_harga = preg_replace('/\D/', '', $_model_harga);
            $model->harga = $model_harga;
            $count_barang = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->andWhere(['id_item_stok' => $model->id_item_stok])->andWhere(['id_item_harga_jual' => $model->id_item_harga_jual])->count();

            $item_stok = AktItemStok::findOne($model->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);

            $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
            $model->total = ($model->qty * $model->harga) - $model_diskon_a;

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $model->save();

                # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
                $total_penjualan_barang = $query->sum('total');

                # get data penjualan, 
                $data_penjualan = AktPenjualan::find()->where(['id_penjualan' => $model->id_penjualan])->one();
                $diskon = ($data_penjualan->diskon > 0) ? ($data_penjualan->diskon * $total_penjualan_barang) / 100 : 0;
                $pajak = ($data_penjualan->pajak == 1) ? (($total_penjualan_barang - $diskon) * 10) / 100 : 0;
                $total_sementara = (($total_penjualan_barang - $diskon) + $pajak) + $data_penjualan->ongkir + $data_penjualan->materai;
                $total_sebenarnya = $total_sementara - $data_penjualan->uang_muka;
                $data_penjualan->total = $total_sebenarnya;
                $data_penjualan->save(FALSE);

                Yii::$app->session->setFlash('success', [['Perhatian!', 'Perubahan ' . $item->nama_item . ' Berhasil di Simpan ke Data Barang Penjualan']]);
            } else {
                # code...
                if ($count_barang == 0) {
                    # code...
                    $model->save();

                    # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                    $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
                    $total_penjualan_barang = $query->sum('total');

                    # get data penjualan, 
                    $data_penjualan = AktPenjualan::find()->where(['id_penjualan' => $model->id_penjualan])->one();
                    $diskon = ($data_penjualan->diskon > 0) ? ($data_penjualan->diskon * $total_penjualan_barang) / 100 : 0;
                    $pajak = ($data_penjualan->pajak == 1) ? (($total_penjualan_barang - $diskon) * 10) / 100 : 0;
                    $total_sementara = (($total_penjualan_barang - $diskon) + $pajak) + $data_penjualan->ongkir + $data_penjualan->materai;
                    $total_sebenarnya = $total_sementara - $data_penjualan->uang_muka;
                    $data_penjualan->total = $total_sebenarnya;
                    $data_penjualan->save(FALSE);

                    Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil di Simpan ke Data Barang Penjualan']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', '' . $item->nama_item . ' Sudah Ada Di Order Penjualan : ' . $akt_penjualan->no_order_penjualan]]);
                }
            }

            return $this->redirect(['akt-penjualan-penjualan/view', 'id' => $model->id_penjualan]);
        }

        return $this->render('update_langsung', [
            'model' => $model,
            'akt_penjualan' => $akt_penjualan,
            'data_item_stok' => $data_item_stok,
            'data_level' => $data_level,
        ]);
    }



    public function actionGetHargaItem($id)
    {
        $item_stok = AktItemHargaJual::find()->where(['id_item_harga_jual' => $id])->one();
        echo Json::encode($item_stok);
    }

    public function actionDeleteFromOrderPenjualan($id, $type)
    {
        $model = $this->findModel($id);
        $model->delete();

        $item_stok = AktItemStok::findOne($model->id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        # total penjualan barang termasuk yang barusan di add, makanya di taruh di bawah model->save
        $query = (new \yii\db\Query())->from('akt_penjualan_detail')->where(['id_penjualan' => $model->id_penjualan]);
        $total_penjualan_barang = $query->sum('total');

        # get data penjualan, 
        $data_penjualan = AktPenjualan::find()->where(['id_penjualan' => $model->id_penjualan])->one();
        $diskon = ($data_penjualan->diskon > 0) ? ($data_penjualan->diskon * $total_penjualan_barang) / 100 : 0;
        $pajak = ($data_penjualan->pajak == 1) ? (($total_penjualan_barang - $diskon) * 10) / 100 : 0;
        $total_sementara = (($total_penjualan_barang - $diskon) + $pajak) + $data_penjualan->ongkir + $data_penjualan->materai;
        $total_sebenarnya = $total_sementara - $data_penjualan->uang_muka;
        $data_penjualan->total = $total_sebenarnya;
        $data_penjualan->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil di Hapus dari Data Barang Penjualan']]);

        if ($type == 'order_penjualan') {
            $url = 'akt-penjualan/view';
        } else if ($type == 'penjualan_langsung') {
            $url = 'akt-penjualan-penjualan/view';
        }
        return $this->redirect([$url, 'id' => $model->id_penjualan]);
    }


    /**
     * Finds the AktPenjualanDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenjualanDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenjualanDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
