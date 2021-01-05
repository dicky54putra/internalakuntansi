<?php

namespace backend\controllers;

use Yii;
use backend\models\AktReturPembelianDetail;
use backend\models\AktReturPembelianDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktPembelianDetail;
use backend\models\AktReturPembelian;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use backend\models\AktItemStok;
use backend\models\AktItem;

/**
 * AktReturPembelianDetailController implements the CRUD actions for AktReturPembelianDetail model.
 */
class AktReturPembelianDetailController extends Controller
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
     * Lists all AktReturPembelianDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktReturPembelianDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktReturPembelianDetail model.
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
     * Creates a new AktReturPembelianDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktReturPembelianDetail();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_retur_pembelian_detail]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionGetQtyPembelianDetail($id)
    {
        $pembelian_detail = AktPembelianDetail::find()->select(['qty'])->where(['id_pembelian_detail' => $id])->one();
        $retur_pembelian_detail = Yii::$app->db->createCommand("SELECT SUM('$pembelian_detail->qty' - retur)  from akt_retur_pembelian_detail WHERE id_pembelian_detail = '$id'")->queryScalar();

        $data = array(
            'qty_pembelian' => $pembelian_detail,
            'qty_retur' => $retur_pembelian_detail
        );
        echo Json::encode($data);
    }

    public function actionCreateFromReturPembelian()
    {
        $model_id_retur_pembelian = Yii::$app->request->post('AktReturPembelianDetail')['id_retur_pembelian'];
        $model_id_pembelian_detail = Yii::$app->request->post('AktReturPembelianDetail')['id_pembelian_detail'];
        $model_qty = Yii::$app->request->post('AktReturPembelianDetail')['qty'];
        $model_retur = Yii::$app->request->post('AktReturPembelianDetail')['retur'];
        $model_keterangan = Yii::$app->request->post('AktReturPembelianDetail')['keterangan'];

        $model = new AktReturPembelianDetail();
        $model->id_retur_pembelian = $model_id_retur_pembelian;
        $model->id_pembelian_detail = $model_id_pembelian_detail;
        $model->qty = $model_qty;
        $model->retur = $model_retur;
        $model->keterangan = $model_keterangan;

        $count_retur_pembelian_detail = AktReturPembelianDetail::find()->where(['id_retur_pembelian' => $model_id_retur_pembelian])->andWhere(['id_pembelian_detail' => $model_id_pembelian_detail])->count();

        $pembelian_detail = AktPembelianDetail::findOne($model_id_pembelian_detail);
        $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        if ($model_retur > $model_qty) {
            Yii::$app->session->setFlash('danger', [['Perhatian !', ' Jumlah retur tidak boleh melebihi qty pembelian!']]);
        } else {
            if ($count_retur_pembelian_detail == 0) {
                # code...
                $model->save();
                Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil Tersimpan di Data Retur Barang Pembelian']]);
            } else {
                # code...
                Yii::$app->session->setFlash('danger', [['Perhatian !', '' . $item->nama_item . ' Sudah Terdaftar di Data Retur Barang Pembelian']]);
            }
        }

        return $this->redirect(['akt-retur-pembelian/view', 'id' => $model->id_retur_pembelian]);
    }

    /**
     * Updates an existing AktReturPembelianDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $akt_retur_pembelian = AktReturPembelian::findOne($model->id_retur_pembelian);


        $data_pembelian_detail = ArrayHelper::map(
            AktPembelianDetail::find()
                ->select(["akt_pembelian_detail.id_pembelian_detail", "akt_item.nama_item", "akt_pembelian_detail.qty"])
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok")
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->where(['id_pembelian' => $akt_retur_pembelian->id_pembelian])
                ->asArray()
                ->all(),
            'id_pembelian_detail',
            function ($model) {
                $sum_retur_detail = Yii::$app->db->createCommand("SELECT SUM(retur) as retur FROM akt_retur_pembelian_detail WHERE id_pembelian_detail = '$model[id_pembelian_detail]'")->queryScalar();
                $qty = $model['qty'] - $sum_retur_detail;
                return $model['nama_item'] . ', Qty pembelian : ' . $qty;
            }
        );

        if ($model->load(Yii::$app->request->post())) {

            $query_retur_pembelian =  AktReturPembelianDetail::find()->where(['id_retur_pembelian' => $model->id_retur_pembelian]);
            $count_retur_pembelian_detail = $query_retur_pembelian->andWhere(['id_pembelian_detail' => $model->id_pembelian_detail])->count();
            $sum_retur_pembelian = Yii::$app->db->createCommand("SELECT SUM(retur) FROM akt_retur_pembelian_detail WHERE id_retur_pembelian = '$model->id_retur_pembelian'")->queryScalar();


            $pembelian_detail = AktPembelianDetail::findOne($model->id_pembelian_detail);
            $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);


            if ($model->retur > $model->qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian !', ' Jumlah retur tidak boleh melebihi qty pembelian!']]);
            } else {
                if ($model->id_pembelian_detail == $model_sebelumnya->id_pembelian_detail) {
                    # code...
                    $model->save();
                    Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data ' . $item->nama_item . ' Berhasil Tersimpan di Data Retur Barang pembelian']]);
                } else {
                    # code...
                    if ($count_retur_pembelian_detail == 0) {
                        # code...
                        $model->save();
                        Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil Tersimpan di Data Retur Barang pembelian']]);
                    } else {
                        # code...
                        Yii::$app->session->setFlash('danger', [['Perhatian !', '' . $item->nama_item . ' Sudah Terdaftar di Data Retur Barang pembelian']]);
                    }
                }
            }



            return $this->redirect(['akt-retur-pembelian/view', 'id' => $model->id_retur_pembelian]);
        }

        return $this->render('update', [
            'model' => $model,
            'akt_retur_pembelian' => $akt_retur_pembelian,
            'data_pembelian_detail' => $data_pembelian_detail,
        ]);
    }

    /**
     * Deletes an existing AktReturPembelianDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        $pembelian_detail = AktPembelianDetail::findOne($model->id_pembelian_detail);
        $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
        $item = AktItem::findOne($item_stok->id_item);

        Yii::$app->session->setFlash('success', [['Perhatian !', '' . $item->nama_item . ' Berhasil Terhapus dari Data Retur Barang Pembelian']]);
        return $this->redirect(['akt-retur-pembelian/view', 'id' => $model->id_retur_pembelian]);
    }

    /**
     * Finds the AktReturPembelianDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktReturPembelianDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktReturPembelianDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
