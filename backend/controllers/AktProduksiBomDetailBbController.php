<?php

namespace backend\controllers;

use Yii;
use backend\models\AktProduksiBomDetailBb;
use backend\models\AktProduksiBomDetailBbSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktItemStok;

/**
 * AktProduksiBomDetailBbController implements the CRUD actions for AktProduksiBomDetailBb model.
 */
class AktProduksiBomDetailBbController extends Controller
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
     * Lists all AktProduksiBomDetailBb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktProduksiBomDetailBbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktProduksiBomDetailBb model.
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
     * Creates a new AktProduksiBomDetailBb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktProduksiBomDetailBb();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_produksi_bom_detail_bb]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktProduksiBomDetailBb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $qty_cek =  Yii::$app->db->createCommand("SELECT qty FROM akt_produksi_bom_detail_bb WHERE id_produksi_bom ='$model->id_produksi_bom' AND id_produksi_bom_detail_bb = '$id'")->queryScalar();
        $model_item = new AktItemStok;


        if ($model->load(Yii::$app->request->post())) {
            $id_item = Yii::$app->request->post('AktProduksiBomDetailBb')['id_item'];
            $qty = Yii::$app->request->post('AktProduksiBomDetailBb')['qty'];
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$model->id_item'")->queryScalar();
            if($qty > $cek_qty ) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            } else {

                if($qty > $qty_cek ) {
                    $_stok = $qty - $qty_cek;
                    $stok = $cek_qty - $_stok;
                } else {
                    $_stok = $qty_cek - $qty;
                    $stok = $cek_qty + $_stok;
                }
                $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$id_item'")->execute();
                $model->save();
                return $this->redirect(['akt-produksi-bom/view', 'id' => $model->id_produksi_bom]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_item' => $model_item
        ]);
    }

    /**
     * Deletes an existing AktProduksiBomDetailBb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['akt-produksi-bom/view', 'id' => $model->id_produksi_bom]);
    }

    /**
     * Finds the AktProduksiBomDetailBb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktProduksiBomDetailBb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktProduksiBomDetailBb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
