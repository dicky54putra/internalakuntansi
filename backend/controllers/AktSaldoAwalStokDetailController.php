<?php

namespace backend\controllers;

use Yii;
use backend\models\AktSaldoAwalStokDetail;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktSaldoAwalStokDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AktSaldoAwalStokDetailController implements the CRUD actions for AktSaldoAwalStokDetail model.
 */
class AktSaldoAwalStokDetailController extends Controller
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
     * Lists all AktSaldoAwalStokDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktSaldoAwalStokDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktSaldoAwalStokDetail model.
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
     * Creates a new AktSaldoAwalStokDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktSaldoAwalStokDetail();

        
        if ($model->load(Yii::$app->request->post())) {
            $id_item_stok =  Yii::$app->request->post('AktSaldoAwalStokDetail')['id_item_stok'];
            $qty =  Yii::$app->request->post('AktSaldoAwalStokDetail')['qty'];
            $item = AktItemStok::findOne($id_item_stok);
            $item->qty = $item->qty + $qty;
            $item->save(false);
            $model->save();
            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Ditambah']]);
            return $this->redirect(['akt-saldo-awal-stok/view', 'id' => $model->id_saldo_awal_stok]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktSaldoAwalStokDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_qty = AktSaldoAwalStokDetail::findOne($id);

        $data_item = ArrayHelper::map(
            AktItem::find()
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item', 'nama_item'
        );

        $data_level = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok",'akt_gudang.nama_gudang'])
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->where(['akt_item_stok.id_item_stok' => $model->id_item_stok])
                ->asArray()
                ->all(),
            'id_item_stok','nama_gudang'
        );

        if ($model->load(Yii::$app->request->post())) {
            $qty =  Yii::$app->request->post('AktSaldoAwalStokDetail')['qty'];
            $id_item_stok =  Yii::$app->request->post('AktSaldoAwalStokDetail')['id_item_stok'];
            $item = AktItemStok::findOne($id_item_stok);

            if($qty > $old_qty->qty ) {
                $_stok = $qty - $old_qty->qty;
                $item->qty = $item->qty + $_stok;
            } else {
                $_stok = $old_qty->qty - $qty;
                $item->qty = $item->qty - $_stok;
            }
            $item->save(false);
            $model->save();
            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Diubah']]);
            return $this->redirect(['akt-saldo-awal-stok/view', 'id' => $model->id_saldo_awal_stok]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_item' => $data_item,
            'data_level' => $data_level
        ]);
    }

    /**
     * Deletes an existing AktSaldoAwalStokDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $item = AktItemStok::findOne($model->id_item_stok);
        $item->qty = $item->qty - $model->qty;
        $item->save(false); 
        $model->delete();
        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Dihapus']]);
        return $this->redirect(['akt-saldo-awal-stok/view', 'id' => $model->id_saldo_awal_stok]);
    }

    /**
     * Finds the AktSaldoAwalStokDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktSaldoAwalStokDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktSaldoAwalStokDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
