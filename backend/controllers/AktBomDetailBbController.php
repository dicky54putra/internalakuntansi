<?php

namespace backend\controllers;

use Yii;
use backend\models\AktBomDetailBb;
use backend\models\AktItemStok;
use backend\models\AktBomDetailBbSearch;
use backend\models\AktProduksiBom;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktBomDetailBbController implements the CRUD actions for AktBomDetailBb model.
 */
class AktBomDetailBbController extends Controller
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
     * Lists all AktBomDetailBb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktBomDetailBbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktBomDetailBb model.
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
     * Creates a new AktBomDetailBb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktBomDetailBb();
        $id_bom = $_GET['id'];
        $model_item = new AktItemStok;

        $model->id_bom = $id_bom;
        if ($model->load(Yii::$app->request->post())) {
            $id_item = Yii::$app->request->post('AktBomDetailBb')['id_item'];
            $qty = Yii::$app->request->post('AktBomDetailBb')['qty'];

            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$id_item'")->queryScalar();
            $cek_item =  Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_bom WHERE id_bom = '$_GET[id]' AND id_item = '$id_item'")->queryScalar();

            if ($qty > $cek_qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            } else if ($cek_item > 0) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item yang diinputkan tidak boleh sama dengan, item yang diinputkan pada B.o.M!']]);
            } else {
                $stok = $cek_qty - $qty;
                $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$id_item'")->execute();
                $model->save();
                return $this->redirect(['akt-bom/view', 'id' => $id_bom]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'id_bom' => $_GET['id'],
            'model_item' => $model_item
        ]);
    }

    /**
     * Updates an existing AktBomDetailBb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $qty_cek =  Yii::$app->db->createCommand("SELECT qty FROM akt_bom_detail_bb WHERE id_bom ='$model->id_bom' AND id_bom_detail_bb = '$id'")->queryScalar();
        $model_item = new AktItemStok;
        if ($model->load(Yii::$app->request->post())) {
            $id_item_stok = Yii::$app->request->post('AktBomDetailBb')['id_item_stok'];
            $cek_item =  Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_bom WHERE id_bom = '$model->id_bom' AND id_item_stok = '$id_item_stok'")->queryScalar();

            $qty = Yii::$app->request->post('AktBomDetailBb')['qty'];
            // $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item = '$model->id_item'")->queryScalar();
            $cek_qty = AktItemStok::find()->where(['id_item_stok' => $id_item_stok])->one();
            if ($qty > $cek_qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            } else if ($cek_item > 0) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item yang diinputkan tidak boleh sama dengan, item yang diinputkan pada B.o.M!']]);
            } else {

                // if ($qty > $qty_cek) {
                //     $_stok = $qty - $qty_cek;
                //     $stok = $cek_qty - $_stok;
                // } else {
                //     $_stok = $qty_cek - $qty;
                //     $stok = $cek_qty + $_stok;
                // }
                // $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$id_item'")->execute();
                $model->save();
                return $this->redirect(['akt-bom/view', 'id' => $model->id_bom]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'id_bom' => $model->id_bom,
            'model_item' => $model_item
        ]);
    }

    public function actionUpdateProduksi($id)
    {
        $model = $this->findModel($id);
        // echo $model->id_bom;
        // die;

        $produksi = AktProduksiBom::find()->where(['id_bom' => $model->id_bom])->one();
        $qty_cek =  Yii::$app->db->createCommand("SELECT qty FROM akt_bom_detail_bb WHERE id_bom ='$model->id_bom' AND id_bom_detail_bb = '$id'")->queryScalar();
        $model_item = new AktItemStok;
        if ($model->load(Yii::$app->request->post())) {
            $id_item = Yii::$app->request->post('AktBomDetailBb')['id_item'];
            $cek_item =  Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_bom WHERE id_bom = '$model->id_bom' AND id_item = '$id_item'")->queryScalar();

            $qty = Yii::$app->request->post('AktBomDetailBb')['qty'];
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item = '$model->id_item'")->queryScalar();
            if ($qty > $cek_qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            } else if ($cek_item > 0) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item yang diinputkan tidak boleh sama dengan, item yang diinputkan pada B.o.M!']]);
            } else {

                // if ($qty > $qty_cek) {
                //     $_stok = $qty - $qty_cek;
                //     $stok = $cek_qty - $_stok;
                // } else {
                //     $_stok = $qty_cek - $qty;
                //     $stok = $cek_qty + $_stok;
                // }
                // $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$id_item'")->execute();
                $model->save();
                return $this->redirect(['akt-peoduksi-bom/view', 'id' => $produksi->id_produksi_bom]);
            }
        }
        return $this->render('update_produksi', [
            'model' => $model,
            'id_bom' => $model->id_bom,
            'model_item' => $model_item,
            'produksi' => $produksi
        ]);
    }

    /**
     * Deletes an existing AktBomDetailBb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // $qty = $model->qty;
        // $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$model->id_item'")->queryScalar();
        // $stok = $cek_qty + $qty;
        // $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$model->id_item'")->execute();
        $model->delete();
        return $this->redirect(['akt-bom/view', 'id' => $model->id_bom]);
    }

    public function actionDelete2($id)
    {
        $model = $this->findModel($id);
        // $qty = $model->qty;
        // $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$model->id_item'")->queryScalar();

        $produksi = AktProduksiBom::find()->where(['id_bom' => $model->id_bom])->one();
        // $stok = $cek_qty + $qty;
        // $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$model->id_item'")->execute();
        $model->delete();
        return $this->redirect(['akt-produksi-bom/view', 'id' => $produksi->id_produksi_bom]);
    }

    /**
     * Finds the AktBomDetailBb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktBomDetailBb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktBomDetailBb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
