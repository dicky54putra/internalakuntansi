<?php

namespace backend\controllers;

use Yii;
use backend\models\AktCabang;
use backend\models\AktCabangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\Foto;

/**
 * AktCabangController implements the CRUD actions for AktCabang model.
 */
class AktCabangController extends Controller
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
     * Lists all AktCabang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktCabangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktCabang model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $id, "nama_tabel" => "cabang"])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'foto'  => $foto,
        ]);
    }

    public function actionUpload()
    {
        $model = new Foto();

        if (Yii::$app->request->isPost) {


            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');

            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        } else {
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        }
    }

    /**
     * Creates a new AktCabang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktCabang();

        $total = AktCabang::find()->count();
        $nomor = 'CB' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cabang]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Updates an existing AktCabang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->kode_cabang;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cabang]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
        ]);
    }

    /**
     * Deletes an existing AktCabang model.
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
     * Finds the AktCabang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktCabang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktCabang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
