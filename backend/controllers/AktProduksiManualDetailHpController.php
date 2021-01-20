<?php

namespace backend\controllers;

use Yii;
use backend\models\AktProduksiManualDetailHp;
use backend\models\AktItemStok;
use backend\models\AktProduksiManualDetailHpSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktProduksiManualDetailHpController implements the CRUD actions for AktProduksiManualDetailHp model.
 */
class AktProduksiManualDetailHpController extends Controller
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
     * Lists all AktProduksiManualDetailHp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktProduksiManualDetailHpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktProduksiManualDetailHp model.
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
     * Creates a new AktProduksiManualDetailHp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktProduksiManualDetailHp();
        $id_produksi_manual = $_GET['id'];
        $model_item = new AktItemStok;
        if ($model->load(Yii::$app->request->post())) {
            $id_item_stok = Yii::$app->request->post('AktProduksiManualDetailHp')['id_item_stok'];
            $qty = Yii::$app->request->post('AktProduksiManualDetailHp')['qty'];
            $cek_db_item = Yii::$app->db->createCommand("SELECT id_item_stok FROM akt_produksi_manual_detail_hp WHERE id_produksi_manual = '$id_produksi_manual' AND id_item_stok = '$id_item_stok'")->queryScalar();
            if($cek_db_item != NULL ) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item ini sudah ada!']]);
            } 
            else {
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
     * Updates an existing AktProduksiManualDetailHp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_item =  Yii::$app->db->createCommand("SELECT id_item_stok FROM akt_produksi_manual_detail_hp WHERE id_produksi_manual ='$model->id_produksi_manual' AND id_produksi_manual_detail_hp = '$id'")->queryScalar();
        $model_item = new AktItemStok;
        if ($model->load(Yii::$app->request->post())) {

            $id_item_stok = Yii::$app->request->post('AktProduksiManualDetailHp')['id_item_stok'];
            $cek_db_item = Yii::$app->db->createCommand("SELECT id_item_stok FROM akt_produksi_manual_detail_hp WHERE id_produksi_manual = '$model->id_produksi_manual' AND id_item_stok = '$id_item_stok'")->queryScalar();

            if($cek_db_item != NULL ) {
                if($cek_db_item == $old_item ) {
                    $model->save();
                    return $this->redirect(['akt-produksi-manual/view', 'id' => $model->id_produksi_manual]);     
                } else {
                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item ini sudah ada!']]);
                }
            }  else {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item ini sudah ada!']]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'model_item' => $model_item,
            'id_produksi_manual' => $model->id_produksi_manual
        ]);
    }

    /**
     * Deletes an existing AktProduksiManualDetailHp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['akt-produksi-manual/view', 'id' => $model->id_produksi_manual]);
    }

    /**
     * Finds the AktProduksiManualDetailHp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktProduksiManualDetailHp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktProduksiManualDetailHp::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
