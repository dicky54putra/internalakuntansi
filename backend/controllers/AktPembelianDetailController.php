<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelianDetail;
use backend\models\AktPembelianDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktItemStok;
use backend\models\AktPembelian;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\models\AktItem;

/**
 * AktPembelianDetailController implements the CRUD actions for AktPembelianDetail model.
 */
class AktPembelianDetailController extends Controller
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
     * Lists all AktPembelianDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPembelianDetail model.
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
     * Creates a new AktPembelianDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPembelianDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembelian_detail]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateFromOrderPembelian()
    {
        # get data
        $model_id_pembelian = Yii::$app->request->post('AktPembelianDetail')['id_pembelian'];
        $model_id_item_stok = Yii::$app->request->post('AktPembelianDetail')['id_item_stok'];
        $model_qty = Yii::$app->request->post('AktPembelianDetail')['qty'];
        $model_harga = Yii::$app->request->post('AktPembelianDetail')['harga'];
        $model_diskon = Yii::$app->request->post('AktPembelianDetail')['diskon'];

        $model_diskon_a = ($model_diskon > 0) ? (($model_qty * $model_harga) * $model_diskon) / 100 : 0;

        $model_total = ($model_qty * $model_harga) - $model_diskon_a;

        $model = new AktPembelianDetail();
        $model->id_pembelian = $model_id_pembelian;
        $model->id_item_stok = $model_id_item_stok;
        $model->qty = $model_qty;
        $model->harga = $model_harga;
        // SEBELUMNYA
        // $model->diskon = $model_diskon_a;
        $model->diskon = $model_diskon;
        $model->total = $model_total;
        $model->keterangan = Yii::$app->request->post('AktPembelianDetail')['keterangan'];

        $count_barang = AktPembelianDetail::find()->where(['id_pembelian' => $model_id_pembelian])->andWhere(['id_item_stok' => $model_id_item_stok])->count();

        $item_stok = AktItemStok::findOne($model_id_item_stok);



        $item = AktItem::findOne($item_stok->id_item);

        if ($count_barang == 0) {

            $model->save();
            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
        } else {
            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Data Barang : ' . $item->nama_item . ' Sudah Ada']]);
        }

        $button_submit =  Yii::$app->request->post('create-from-pembelian');
        if (isset($button_submit)) {
            $url = 'akt-pembelian-pembelian/view';
            return $this->redirect([$url, 'id' => $model->id_pembelian]);
        } else {
            $url = 'akt-pembelian/view';
            return $this->redirect([$url, 'id' => $model->id_pembelian]);
        }
    }

    public function actionUpdateFromDataPembelian($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

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

        $akt_pembelian = AktPembelian::findOne($model->id_pembelian);

        if ($model->load(Yii::$app->request->post())) {

            $count_barang = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->andWhere(['id_item_stok' => $model->id_item_stok])->count();

            $item_stok = AktItemStok::findOne($model->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);

            $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
            $model->total = ($model->qty * $model->harga) - $model_diskon_a;

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $model->save();

                # total pembelian barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                $query = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
                $total_pembelian_barang = $query->sum('total');

                # get data pembelian, 
                $data_pembelian = AktPembelian::find()->where(['id_pembelian' => $model->id_pembelian])->one();
                $diskon = ($data_pembelian->diskon > 0) ? ($data_pembelian->diskon * $total_pembelian_barang) / 100 : 0;
                $pajak = ($data_pembelian->pajak == 1) ? (($total_pembelian_barang - $diskon) * 10) / 100 : 0;
                $data_pembelian->total = (($total_pembelian_barang - $diskon) + $pajak) + $data_pembelian->ongkir;
                $data_pembelian->save(FALSE);

                Yii::$app->session->setFlash('success', [['Perhatian!', 'Perubahan ' . $item->nama_item . ' Berhasil di Simpan ke Data Barang Pembelian']]);
            } else {
                # code...
                $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                $model->total = ($model->qty * $model->harga) - $model_diskon_a;

                if ($count_barang == 0) {
                    # code...
                    $model->save();

                    # total pembelian barang termasuk yang barusan di add, makanya di taruh di bawah model->save
                    $query = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
                    $total_pembelian_barang = $query->sum('total');

                    # get data pembelian, 
                    $data_pembelian = AktPembelian::find()->where(['id_pembelian' => $model->id_pembelian])->one();
                    $diskon = ($data_pembelian->diskon > 0) ? ($data_pembelian->diskon * $total_pembelian_barang) / 100 : 0;
                    $pajak = ($data_pembelian->pajak == 1) ? (($total_pembelian_barang - $diskon) * 10) / 100 : 0;
                    $data_pembelian->total = (($total_pembelian_barang + $pajak) - $diskon) + $data_pembelian->ongkir;
                    $data_pembelian->save(FALSE);

                    Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil Disimpan ke Data Barang pembelian']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', '' . $item->nama_item . ' Sudah Ada di Data pembelian : ' . $akt_pembelian->no_pembelian]]);
                }
            }


            return $this->redirect(['akt-pembelian-pembelian/view', 'id' => $model->id_pembelian]);
        }

        return $this->render('update_pembelian', [
            'model' => $model,
            'akt_pembelian' => $akt_pembelian,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    public function actionGetHargaItem($id)
    {
        $item_stok = AktItemStok::find()->where(['id_item_stok' => $id])->one();
        echo Json::encode($item_stok);
    }

    /**
     * Updates an existing AktPembelianDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);


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

        $akt_pembelian = AktPembelian::findOne($model->id_pembelian);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                if ($model->qty == $model_sebelumnya->qty) {
                    # code...
                    $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                    $model->total = ($model->qty * $model->harga) - $model_diskon_a;
                    $model->save();

                    Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
                } else {
                    # code...
                    $item_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
                    // $item = AktItem::findOne($item_stok->id_item);

                    if ($model->qty <= ($model_sebelumnya->qty + $item_stok->qty)) {
                        # code...
                        $item_stok->qty = ($item_stok->qty + $model_sebelumnya->qty) - $model->qty;
                        $item_stok->save(FALSE);

                        $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                        $model->total = ($model->qty * $model->harga) - $model_diskon_a;
                        $model->save();

                        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
                    } else {
                        # code...
                        Yii::$app->session->setFlash('danger', [['Perhatian!', 'Quantity Yang Di Inputkan Melebihi Stok']]);
                    }
                }
            } else {
                # code...
                $item_stok_baru = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();

                if ($model->qty <= $item_stok_baru->qty) {
                    # code...
                    $item_stok_lama = AktItemStok::find()->where(['id_item_stok' => $model_sebelumnya->id_item_stok])->one();
                    $item_stok_lama->qty = $item_stok_lama->qty + $model_sebelumnya->qty;
                    $item_stok_lama->save(FALSE);

                    $item_stok_baru = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();
                    $item_stok_baru->qty = $item_stok_baru->qty - $model->qty;
                    $item_stok_baru->save(FALSE);

                    $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                    $model->total = ($model->qty * $model->harga) - $model_diskon_a;
                    $model->save();

                    Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Quantity Yang Di Inputkan Melebihi Stok']]);
                }
            }

            return $this->redirect(['akt-pembelian/view', 'id' => $model->id_pembelian]);
        }

        return $this->render('update', [
            'model' => $model,
            'akt_pembelian' => $akt_pembelian,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    public function actionUpdateFromOrderPembelian($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

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

        $akt_pembelian = AktPembelian::findOne($model->id_pembelian);

        if ($model->load(Yii::$app->request->post())) {

            $count_barang = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->andWhere(['id_item_stok' => $model->id_item_stok])->count();

            $item_stok = AktItemStok::findOne($model->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                $model->total = ($model->qty * $model->harga) - $model_diskon_a;
                $model->save();
                Yii::$app->session->setFlash('success', [['Perhatian!', 'Perubahan ' . $item->nama_item . ' Berhasil di Simpan ke Data Barang pembelian']]);
            } else {
                # code...
                if ($count_barang == 0) {
                    # code...
                    $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                    $model->total = ($model->qty * $model->harga) - $model_diskon_a;
                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil Disimpan ke Data Barang pembelian']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', '' . $item->nama_item . ' Sudah Ada Di Order pembelian : ' . $akt_pembelian->no_order_pembelian]]);
                }
            }


            return $this->redirect(['akt-pembelian/view', 'id' => $model->id_pembelian]);
        }
        return $this->render('update', [
            'model' => $model,
            'akt_pembelian' => $akt_pembelian,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    public function actionUpdateFromPembelian($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);


        $data_item_stok = AktPembelianDetail::dataItemStok();
        $akt_pembelian = AktPembelian::findOne($model->id_pembelian);

        if ($model->load(Yii::$app->request->post())) {

            $count_barang = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->andWhere(['id_item_stok' => $model->id_item_stok])->count();

            $item_stok = AktItemStok::findOne($model->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);

            if ($model->id_item_stok == $model_sebelumnya->id_item_stok) {
                # code...
                $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                $model->total = ($model->qty * $model->harga) - $model_diskon_a;
                $model->save();
                Yii::$app->session->setFlash('success', [['Perhatian!', 'Perubahan ' . $item->nama_item . ' Berhasil di Simpan ke Data Barang pembelian']]);
            } else {
                # code...
                if ($count_barang == 0) {
                    # code...
                    $model_diskon_a = ($model->diskon > 0) ? (($model->qty * $model->harga) * $model->diskon) / 100 : 0;
                    $model->total = ($model->qty * $model->harga) - $model_diskon_a;
                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil Disimpan ke Data Barang pembelian']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian!', '' . $item->nama_item . ' Sudah Ada Di Order pembelian : ' . $akt_pembelian->no_order_pembelian]]);
                }
            }


            return $this->redirect(['akt-pembelian-pembelian/view', 'id' => $model->id_pembelian]);
        }
        return $this->render('update_langsung', [
            'model' => $model,
            'akt_pembelian' => $akt_pembelian,
            'data_item_stok' => $data_item_stok,
        ]);
    }

    /**
     * Deletes an existing AktPembelianDetail model.
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

    public function actionDeleteFromOrderPembelian($id, $type)
    {
        $model = $this->findModel($id);
        $model->delete();

        $item_stok = AktItemStok::findOne($model->id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil Dihapus dari Data Barang Pembelian']]);

        if ($type == 'order_pembelian') {
            $url = 'akt-pembelian/view';
        } else if ($type == 'pembelian_langsung') {
            $url = 'akt-pembelian-pembelian/view';
        }
        return $this->redirect([$url, 'id' => $model->id_pembelian]);
    }


    public function actionDeleteFromDataPembelian($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        # total pembelian barang termasuk yang barusan di add, makanya di taruh di bawah model->save
        $query_sum = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
        $total_pembelian_barang = $query_sum->sum('total');

        # get data pembelian, 
        $data_pembelian = AktPembelian::find()->where(['id_pembelian' => $model->id_pembelian])->one();
        $diskon = ($data_pembelian->diskon > 0) ? ($data_pembelian->diskon * $total_pembelian_barang) / 100 : 0;
        $pajak = ($data_pembelian->pajak == 1) ? (($total_pembelian_barang - $diskon) * 10) / 100 : 0;
        $data_pembelian->total = (($total_pembelian_barang - $diskon) + $pajak) + $data_pembelian->ongkir;
        $data_pembelian->save(FALSE);

        $item_stok = AktItemStok::findOne($model->id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        Yii::$app->session->setFlash('success', [['Perhatian!', '' . $item->nama_item . ' Berhasil Dihapus dari Data Barang pembelian']]);
        return $this->redirect(['akt-pembelian-pembelian/view', 'id' => $model->id_pembelian]);
    }

    /**
     * Finds the AktPembelianDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPembelianDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPembelianDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
