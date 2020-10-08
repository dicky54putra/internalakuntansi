<?php

namespace backend\controllers;

use Yii;
use backend\models\AktKelompokHartaTetap;
use backend\models\AktKelompokHartaTetapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktKelompokHartaTetapController implements the CRUD actions for AktKelompokHartaTetap model.
 */
class AktKelompokHartaTetapController extends Controller
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
     * Lists all AktKelompokHartaTetap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktKelompokHartaTetapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktKelompokHartaTetap model.
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
     * Creates a new AktKelompokHartaTetap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktKelompokHartaTetap();

        $id_kelompok_harta_tetap = AktKelompokHartaTetap::find()->select(['max(id_kelompok_harta_tetap) as id_kelompok_harta_tetap'])->one();
        $nomor_sebelumnya = AktKelompokHartaTetap::find()->select(['kode'])->where(['id_kelompok_harta_tetap' => $id_kelompok_harta_tetap])->one();
        if (!empty($nomor_sebelumnya->kode)) {
            # code...
            $noUrut = (int) substr($nomor_sebelumnya->kode, 2);
            if ($noUrut <= 999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
            } elseif ($noUrut <= 9999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%04s", $noUrut);
            } elseif ($noUrut <= 99999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%05s", $noUrut);
            }
            $kode = "KH" . $noUrut_2;
            $kode = $kode;
        } else {
            # code...
            $kode = 'KH001';
        }

        $model->kode = $kode;

        if ($model->load(Yii::$app->request->post())) {

            $create = Yii::$app->request->post('create-in-harta-tetap');
            $update = Yii::$app->request->post('update-in-harta-tetap');
            $id = Yii::$app->request->post('id');

            if(isset($create)) {
                $model->save();
                return $this->redirect(['akt-harta-tetap/create']);
            } else if (isset($update)) {
                $model->save();
                return $this->redirect(['akt-harta-tetap/update', 'id' => $id]);
            } else {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id_kelompok_harta_tetap]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktKelompokHartaTetap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_kelompok_harta_tetap]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktKelompokHartaTetap model.
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
     * Finds the AktKelompokHartaTetap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktKelompokHartaTetap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktKelompokHartaTetap::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
