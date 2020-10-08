<?php

namespace backend\controllers;

use Yii;
use backend\models\AktProduksiManualDetailBb;
use backend\models\AktProduksiManualDetailBbSearch;
use yii\web\Controller;
use backend\models\AktItemStok;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktProduksiManualDetailBbController implements the CRUD actions for AktProduksiManualDetailBb model.
 */
class AktProduksiManualDetailBbController extends Controller
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
     * Lists all AktProduksiManualDetailBb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktProduksiManualDetailBbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktProduksiManualDetailBb model.
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
     * Creates a new AktProduksiManualDetailBb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktProduksiManualDetailBb();
        $model_item = new AktItemStok;
        $id_produksi_manual = $_GET['id'];
        if ($model->load(Yii::$app->request->post())) {

            $id_item_stok = Yii::$app->request->post('AktProduksiManualDetailBb')['id_item_stok'];
            $qty = Yii::$app->request->post('AktProduksiManualDetailBb')['qty'];
            $cek_db_item = Yii::$app->db->createCommand("SELECT id_item_stok FROM akt_produksi_manual_detail_bb WHERE id_produksi_manual = '$id_produksi_manual' AND id_item_stok = '$id_item_stok'")->queryScalar();
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$id_item_stok'")->queryScalar();
            if($cek_db_item != NULL ) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item ini sudah ada!']]);
            } else if ( $qty > $cek_qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            }
            else {
                $stok = $cek_qty - $qty;
                $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$id_item_stok'")->execute();
                $model->save();
                return $this->redirect(['akt-produksi-manual/view', 'id' => $id_produksi_manual]);
            }            
        }

        return $this->render('create', [
            'model' => $model,
            'model_item' => $model_item,
            'id_produksi_manual' => $id_produksi_manual
        ]);
    }

    /**
     * Updates an existing AktProduksiManualDetailBb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_item =  Yii::$app->db->createCommand("SELECT id_item_stok FROM akt_produksi_manual_detail_bb WHERE id_produksi_manual ='$model->id_produksi_manual' AND id_produksi_manual_detail_bb = '$id'")->queryScalar();

        $qty_cek =  Yii::$app->db->createCommand("SELECT qty FROM akt_produksi_manual_detail_bb WHERE id_produksi_manual ='$model->id_produksi_manual' AND id_produksi_manual_detail_bb = '$id'")->queryScalar();

        $model_item = new AktItemStok;
        if ($model->load(Yii::$app->request->post())) {
            $id_item_stok = Yii::$app->request->post('AktProduksiManualDetailBb')['id_item_stok'];
            $cek_db_item = Yii::$app->db->createCommand("SELECT id_item_stok FROM akt_produksi_manual_detail_bb WHERE id_produksi_manual = '$model->id_produksi_manual' AND id_item_stok = '$id_item_stok'")->queryScalar();
            $qty = Yii::$app->request->post('AktProduksiManualDetailBb')['qty'];
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$id_item_stok'")->queryScalar();
            if($cek_db_item != NULL ) {
                if($cek_db_item == $old_item ) {
                    if ( $qty > $cek_qty) {
                        Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
                    } else {
                        if($qty > $qty_cek ) {
                            $_stok = $qty - $qty_cek;
                            $stok = $cek_qty - $_stok;
                        } else {
                            $_stok = $qty_cek - $qty;
                            $stok = $cek_qty + $_stok;
                        }
                        $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$id_item_stok'")->execute();
                        $model->save();
                        return $this->redirect(['akt-produksi-manual/view', 'id' => $model->id_produksi_manual]);
                    }
                } else {
                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item ini sudah ada!']]);
                }
            } 

            
        }
        return $this->render('update', [
            'model' => $model,
            'model_item' => $model_item,
            'id_produksi_manual' => $model->id_produksi_manual
        ]);
    }

    /**
     * Deletes an existing AktProduksiManualDetailBb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = qty + '$model->qty' WHERE id_item_stok = '$model->id_item_stok'")->execute();
        $model->delete();
        return $this->redirect(['akt-produksi-manual/view', 'id' => $model->id_produksi_manual]);
    }

    /**
     * Finds the AktProduksiManualDetailBb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktProduksiManualDetailBb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktProduksiManualDetailBb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
