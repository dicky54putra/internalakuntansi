<?php

namespace backend\controllers;

use Yii;
use backend\models\ItemOrderPembelian;
use backend\models\ItemOrderPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\models\AktItemStok;

/**
 * ItemOrderPembelianController implements the CRUD actions for ItemOrderPembelian model.
 */
class ItemOrderPembelianController extends Controller
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
     * Lists all ItemOrderPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemOrderPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemOrderPembelian model.
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
     * Creates a new ItemOrderPembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemOrderPembelian();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_item_order_pembelian]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ItemOrderPembelian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $id_item_order_pembelian)
    {
        $model = $this->findModel($id_item_order_pembelian);

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-order-pembelian/view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
            'array_item' => $array_item,
        ]);
    }

    /**
     * Deletes an existing ItemOrderPembelian model.
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
     * Finds the ItemOrderPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemOrderPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemOrderPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
