<?php

namespace backend\controllers;

use Yii;
use backend\models\ItemPembelianHartaTetap;
use backend\models\ItemPembelianHartaTetapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktHartaTetap;
use yii\helpers\ArrayHelper;

/**
 * ItemPembelianHartaTetapController implements the CRUD actions for ItemPembelianHartaTetap model.
 */
class ItemPembelianHartaTetapController extends Controller
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
     * Lists all ItemPembelianHartaTetap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemPembelianHartaTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemPembelianHartaTetap model.
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
     * Creates a new ItemPembelianHartaTetap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemPembelianHartaTetap();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_item_pembelian_harta_tetap]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ItemPembelianHartaTetap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $id_item_pembelian_harta_tetap)
    {
        $model = $this->findModel($id_item_pembelian_harta_tetap);

            $array_item = ArrayHelper::map(
            AktHartaTetap::find()
                // ->select(["akt_harta_tetap.kode", "akt_harta_tetap.nama"])
                // ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                // ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                // ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_harta_tetap',
            function ($model) {
                return 'Kode : ' . $model['kode'] . ' - Nama : ' . $model['nama'];
            }
        );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-pembelian-harta-tetap/view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
            'array_item' => $array_item,
        ]);
    }

    /**
     * Deletes an existing ItemPembelianHartaTetap model.
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
     * Finds the ItemPembelianHartaTetap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemPembelianHartaTetap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemPembelianHartaTetap::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
