<?php

namespace backend\controllers;

use Yii;
use backend\models\AktTransferStokDetail;
use backend\models\AktTransferStokDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktTransferStok;

/**
 * AktTransferStokDetailController implements the CRUD actions for AktTransferStokDetail model.
 */
class AktTransferStokDetailController extends Controller
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
     * Lists all AktTransferStokDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktTransferStokDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktTransferStokDetail model.
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
     * Creates a new AktTransferStokDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktTransferStokDetail();
        $model->id_transfer_stok = $_GET['id'];
        $model->qty = 0;

        $akt_transfer_stok = AktTransferStok::findOne($_GET['id']);

        // $data_item = ArrayHelper::map(
        //     AktItem::find()
        //         ->select(["akt_item.nama_item", "akt_item.id_item", "akt_item_stok.qty"])
        //         ->leftJoin("akt_item_stok", "akt_item_stok.id_item = akt_item.id_item")
        //         ->where("akt_item_stok.id_gudang IN ($akt_transfer_stok->id_gudang_asal, $akt_transfer_stok->id_gudang_tujuan)")
        //         ->groupBy("akt_item_stok.id_item")
        //         ->having("count(*) = 2")
        //         ->orderBy("akt_item.nama_item")
        //         ->asArray()
        //         ->all(),
        //     'id_item',
        //     function ($model) {
        //         return $model['nama_item'];
        //     }
        // );

        if ($model->load(Yii::$app->request->post())) {

            $count_gudang_asal = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_asal])->count();
            $count_gudang_tujuan = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_tujuan])->count();

            if ($count_gudang_asal != 0) {
                # code...
                if ($count_gudang_tujuan != 0) {
                    # code...
                    $item_stok_asal = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_asal])->one();
                    $item = AktItem::find()->where(['id_item' => $item_stok_asal->id_item])->one();

                    if ($model->qty > $item_stok_asal->qty) {
                        # code...
                        Yii::$app->session->setFlash('danger', [['Perhatian!', 'Qty Barang ' . $item->nama_item . ' Yang Di Inputkan Melebihi Stok Di Gudang Asal. <br>Sisa Stok Barang ' . $item->nama_item . ' Di Gudang Asal = ' . $item_stok_asal->qty]]);
                        return $this->redirect(['akt-transfer-stok-detail/create', 'id' => $model->id_transfer_stok]);
                    } else {
                        # code...
                        $item_stok_asal->qty = $item_stok_asal->qty - $model->qty;
                        $item_stok_asal->save(FALSE);

                        $item_stok_tujuan = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_tujuan])->one();
                        $item_stok_tujuan->qty = $item_stok_tujuan->qty + $model->qty;
                        $item_stok_tujuan->save(FALSE);

                        $model->save();

                        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
                        return $this->redirect(['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]);
                    }
                } else {
                    # code...
                    $item = AktItem::find()->where(['id_item' => $model->id_item])->one();

                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Barang ' . $item->nama_item . ' Tidak Memiliki Gudang Tujuan']]);
                    return $this->redirect(['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]);
                }
            } else {
                # code...
                $item = AktItem::find()->where(['id_item' => $model->id_item])->one();

                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Barang ' . $item->nama_item . ' Tidak Memiliki Gudang Asal']]);
                return $this->redirect(['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'akt_transfer_stok' => $akt_transfer_stok,
            'data_item' => $data_item,
        ]);
    }

    /**
     * Updates an existing AktTransferStokDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $akt_transfer_stok = AktTransferStok::findOne($model->id_transfer_stok);

        $data_item = ArrayHelper::map(
            AktItem::find()
                ->select(["akt_item.nama_item", "akt_item.id_item"])
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

        if ($model->load(Yii::$app->request->post())) {

            if ($model->id_item == $model_sebelumnya->id_item) {
                # code...
                $count_gudang_asal = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_asal])->count();
                $count_gudang_tujuan = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_tujuan])->count();

                if ($count_gudang_asal != 0) {
                    # code...
                    if ($count_gudang_tujuan != 0) {
                        # code...
                        $item_stok_asal = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_asal])->one();
                        $item = AktItem::find()->where(['id_item' => $item_stok_asal->id_item])->one();

                        if ($model->qty > $item_stok_asal->qty) {
                            # code...
                            Yii::$app->session->setFlash('danger', [['Perhatian!', 'Qty Barang ' . $item->nama_item . ' Yang Di Inputkan Melebihi Stok Di Gudang Asal. <br>Sisa Stok Barang ' . $item->nama_item . ' Di Gudang Asal = ' . $item_stok_asal->qty]]);
                            return $this->redirect(['akt-transfer-stok-detail/create', 'id' => $model->id_transfer_stok]);
                        } else {
                            # code...
                            $item_stok_asal->qty = $item_stok_asal->qty - $model->qty;
                            $item_stok_asal->save(FALSE);

                            $item_stok_tujuan = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_tujuan])->one();
                            $item_stok_tujuan->qty = $item_stok_tujuan->qty + $model->qty;
                            $item_stok_tujuan->save(FALSE);

                            $model->save();

                            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Diubah']]);
                            return $this->redirect(['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]);
                        }
                    } else {
                        # code...
                        $item = AktItem::find()->where(['id_item' => $model->id_item])->one();

                        Yii::$app->session->setFlash('danger', [['Perhatian!', 'Barang ' . $item->nama_item . ' Tidak Memiliki Gudang Tujuan']]);
                        return $this->redirect(['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]);
                    }
                } else {
                    # code...
                    $item = AktItem::find()->where(['id_item' => $model->id_item])->one();

                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Barang ' . $item->nama_item . ' Tidak Memiliki Gudang Asal']]);
                    return $this->redirect(['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]);
                }
            } else {
                # code...
            }
        }

        return $this->render('update', [
            'model' => $model,
            'akt_transfer_stok' => $akt_transfer_stok,
            'data_item' => $data_item,
        ]);
    }

    /**
     * Deletes an existing AktTransferStokDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $akt_transfer_stok = AktTransferStok::findOne($model->id_transfer_stok);

        $update_gudang_tujuan = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_tujuan])->one();
        $update_gudang_tujuan->qty = $update_gudang_tujuan->qty - $model->qty;
        $update_gudang_tujuan->save(FALSE);

        $update_gudang_asal = AktItemStok::find()->where(['id_item' => $model->id_item])->andWhere(['id_gudang' => $akt_transfer_stok->id_gudang_asal])->one();
        $update_gudang_asal->qty = $update_gudang_asal->qty + $model->qty;
        $update_gudang_asal->save(FALSE);

        $model->delete();

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Dihapus']]);
        return $this->redirect(['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]);
    }

    /**
     * Finds the AktTransferStokDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktTransferStokDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktTransferStokDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
