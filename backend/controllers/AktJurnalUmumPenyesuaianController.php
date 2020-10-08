<?php

namespace backend\controllers;

use Yii;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktJurnalUmumSearch;
use backend\models\AktJurnalUmumDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktAkun;
use yii\helpers\ArrayHelper;

/**
 * AktJurnalUmumController implements the CRUD actions for AktJurnalUmum model.
 */
class AktJurnalUmumPenyesuaianController extends Controller
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
     * Lists all AktJurnalUmum models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktJurnalUmumSearch();
        $dataProvider = $searchModel->searchAktJurnalUmumPenyesuaian(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktJurnalUmum model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $model_jurnal_umum_detail = new AktJurnalUmumDetail();
        $model_jurnal_umum_detail->id_jurnal_umum = $model->id_jurnal_umum;
        $model_jurnal_umum_detail->debit = 0;
        $model_jurnal_umum_detail->kredit = 0;

        $data_akun = ArrayHelper::map(
            AktAkun::find()
                // ->where(['jenis' => 2])
                ->all(),
            'id_akun',
            function ($model) {
                return $model['kode_akun'] . ' - ' . $model['nama_akun'];
            }
        );

        return $this->render('view', [
            'model' => $model,
            'model_jurnal_umum_detail' => $model_jurnal_umum_detail,
            'data_akun' => $data_akun,
        ]);
    }

    /**
     * Creates a new AktJurnalUmum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktJurnalUmum();

        $akt_jurnal_umum = AktJurnalUmum::find()->select(["no_jurnal_umum"])->orderBy("id_jurnal_umum DESC")->limit(1)->one();
        if (!empty($akt_jurnal_umum->no_jurnal_umum)) {
            # code...
            $no_bulan = substr($akt_jurnal_umum->no_jurnal_umum, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_jurnal_umum->no_jurnal_umum, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_jurnal_umum = 'JP' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_jurnal_umum = 'JP' . date('ym') . '001';
            }
        } else {
            # code...
            $no_jurnal_umum = 'JP' . date('ym') . '001';
        }

        $model->no_jurnal_umum = $no_jurnal_umum;
        $model->tanggal = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_jurnal_umum]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktJurnalUmum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_jurnal_umum]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktJurnalUmum model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktJurnalUmum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktJurnalUmum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktJurnalUmum::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
