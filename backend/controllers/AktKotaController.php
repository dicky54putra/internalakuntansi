<?php

namespace backend\controllers;

use Yii;
use backend\models\AktKota;
use backend\models\AktKotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktKotaController implements the CRUD actions for AktKota model.
 */
class AktKotaController extends Controller
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
     * Lists all AktKota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktKotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktKota model.
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
     * Creates a new AktKota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktKota();

        $total = AktKota::find()->count();
        $nomor = "KT" . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post())) {
            $create_in_item =  Yii::$app->request->post('create-in-item');
            $update_in_item =  Yii::$app->request->post('update-in-item');
            $id_update_alamat =  Yii::$app->request->post('id-update-alamat');
            $id =  Yii::$app->request->post('id');

            $create_in_pegawai =  Yii::$app->request->post('create-in-pegawai');
            $update_in_pegawai =  Yii::$app->request->post('update-in-pegawai');
            $id_update_pegawai =  Yii::$app->request->post('id-update-pegawai');

            $create_in_sales =  Yii::$app->request->post('create-in-sales');
            $update_in_sales =  Yii::$app->request->post('update-in-sales');
            $id_update_sales =  Yii::$app->request->post('id-update-sales');

            if(isset($create_in_item)) {
                $model->save();
                return $this->redirect(['akt-mitra-bisnis-alamat/create', 'id' => $id]);
            } else if (isset($update_in_item)) {
                $model->save();
                return $this->redirect(['akt-mitra-bisnis-alamat/update', 'id' => $id_update_alamat]);
            }  else if (isset($create_in_pegawai)) {
                $model->save();
                return $this->redirect(['akt-pegawai/create']);
            } else if (isset($update_in_pegawai)) {
                $model->save();
                return $this->redirect(['akt-pegawai/update', 'id' => $id_update_pegawai]);
            } else if (isset($create_in_sales)) {
                $model->save();
                return $this->redirect(['akt-sales/create']);
            } else if (isset($update_in_sales)) {
                $model->save();
                return $this->redirect(['akt-sales/update', 'id' => $id_update_sales]);
            }  else  {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id_kota]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Updates an existing AktKota model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->kode_kota;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_kota]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Deletes an existing AktKota model.
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
     * Finds the AktKota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktKota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktKota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
