<?php

namespace backend\controllers;

use Yii;
use backend\models\AktOrderPembelian;
use backend\models\AktOrderPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\models\Foto;
use backend\models\ItemOrderPembelian;
use backend\models\AktItemStok;
use backend\models\AktItem;
use yii\helpers\Json;
// use yii\helpers\ArrayHelper;


/**
 * AktOrderPembelianController implements the CRUD actions for AktOrderPembelian model.
 */
class AktOrderPembelianController extends Controller
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
     * Lists all AktOrderPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktOrderPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktOrderPembelian model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if (Yii::$app->request->get('aksi') == 'save') {

            $simpan = new ItemOrderPembelian();
            $simpan->id_order_pembelian = $id;
            $simpan->id_item_stok = Yii::$app->request->post('id_item_stok');
            $simpan->quantity = Yii::$app->request->post('quantity');
            // $simpan->id_satuan = Yii::$app->request->post("satuan");
            $simpan->harga = Yii::$app->request->post("harga");
            $simpan->diskon = Yii::$app->request->post("diskon");

            // $simpan->qty_terkirim = Yii::$app->request->post("qty_terkirim");
            // $simpan->qty_order_back = Yii::$app->request->post("qty_order_back");
            // $simpan->id_departement = Yii::$app->request->post("departement");
            // $simpan->id_proyek = Yii::$app->request->post('proyek');
            $simpan->keterangan = Yii::$app->request->post("keterangan");
            // $simpan->req_date = Yii::$app->request->post('req_date');
            $simpan->save(false);


            Yii::$app->session->setFlash("success", "Detail Item Ditambahkan");

            return $this->redirect(['view', 'id' => $id]);
        }

        if (Yii::$app->request->get('aksi') == 'input_alamat') {

            $save = AktOrderPembelian::find()->where(['id_order_pembelian' => $id])->one();
            $save->alamat_bayar = Yii::$app->request->post("alamat_bayar");
            $save->alamat_kirim = Yii::$app->request->post("alamat_kirim");

            // echo Yii::$app->request->post("alamat_bayar");

            // exit();
            $save->save(false);


            Yii::$app->session->setFlash("success", "Alamat Ditambahkan");

            return $this->redirect(['view', 'id' => $id]);
        }

        if (Yii::$app->request->get('action') == "delete_item") {

            ItemOrderPembelian::deleteAll(["id_item_order_pembelian" => Yii::$app->request->get('id_item_order_pembelian')]);

            Yii::$app->session->setFlash("success", "Data item berhasil dihapus");

            return $this->redirect(['view', 'id' => $id]);
        }

        $daftar_item = ItemOrderPembelian::find()->where(['id_order_pembelian' => $id])->all();

        $array_item = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $id, "nama_tabel" => "order-pembelian"])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'foto'  => $foto,
            'array_item' => $array_item,
            'daftar_item' => $daftar_item,
        ]);
    }

    public function actionGetHargaItem($id)
    {
        $item_stok = AktItemStok::find()->where(['id_item_stok' => $id])->one();
        echo Json::encode($item_stok);
    }

    public function actionUpload()
    {
        $model = new Foto();

        if (Yii::$app->request->isPost) {


            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');

            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        } else {
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        }
    }

    /**
     * Creates a new AktOrderPembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktOrderPembelian();

        $total = AktOrderPembelian::find()->count();

        $nomor = "PO" . date('Y') . str_pad($total + 1, 3, "0", STR_PAD_LEFT);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_order_pembelian]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Updates an existing AktOrderPembelian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->no_order;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_order_pembelian]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Deletes an existing AktOrderPembelian model.
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
     * Finds the AktOrderPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktOrderPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktOrderPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
