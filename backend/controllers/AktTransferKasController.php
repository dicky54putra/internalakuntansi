<?php

namespace backend\controllers;

use Yii;
use backend\models\AktTransferKas;
use backend\models\AktTransferKasSearch;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * AktTransferKasController implements the CRUD actions for AktTransferKas model.
 */
class AktTransferKasController extends Controller
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
     * Lists all AktTransferKas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktTransferKasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktTransferKas model.
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
     * Creates a new AktTransferKas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktTransferKas();
        $total = AktTransferKas::find()->count();
        $nomor = 'TK' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);
        $model_kas = new AktKasBank;


        if ($model->load(Yii::$app->request->post())) {
            $kas_before = AktKasBank::find()->where(['id_kas_bank' => $model->id_asal_kas])->one();
            $kas_after = AktKasBank::find()->where(['id_kas_bank' => $model->id_tujuan_kas])->one();

            if ($model->jumlah1 > $kas_before->saldo) {
                Yii::$app->session->setFlash('danger', [['Gagal!', 'Uang yang anda transfer melebihi saldo! atau Uang kas tidak boleh sama!']]);
                return $this->redirect(['create']);
            } else if ($model->id_asal_kas == $model->id_tujuan_kas) {
                Yii::$app->session->setFlash('danger', [['Gagal!', 'Uang kas tidak boleh sama!']]);
                return $this->redirect(['create']);
            } else {
                $kas_before->saldo = $kas_before->saldo - $model->jumlah1;
                $kas_after->saldo = $kas_after->saldo + $model->jumlah1;
                $kas_before->save(false);
                $kas_after->save(false);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_transfer_kas]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
            'modal_kas' => $model_kas
        ]);
    }

    /**
     * Updates an existing AktTransferKas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $nomor = $model->no_transfer_kas;
        $model_kas = new AktKasBank;
        if ($model->load(Yii::$app->request->post())) {
            $kas_before = AktKasBank::find()->where(['id_kas_bank' => $model->id_asal_kas])->one();
            $kas_after = AktKasBank::find()->where(['id_kas_bank' => $model->id_tujuan_kas])->one();

            $sebelum = $kas_before->saldo + $model_sebelumnya->jumlah1;
            // echo $sebelum;
            // die;
            if ($model->jumlah1 > $sebelum) {
                Yii::$app->session->setFlash('danger', [['Gagal!', 'Uang yang anda transfer melebihi saldo!']]);
                return $this->redirect(['update', 'id' => $model->id_transfer_kas]);
            } else if ($model->id_asal_kas == $model->id_tujuan_kas) {
                Yii::$app->session->setFlash('danger', [['Gagal!', 'Uang kas tidak boleh sama!']]);
                return $this->redirect(['update', 'id' => $model->id_transfer_kas]);
            } else {
                if ($model_sebelumnya->jumlah1 > $model->jumlah1) {
                    $selisih_form = $model_sebelumnya->jumlah1 - $model->jumlah1;
                    $kas_before->saldo = $kas_before->saldo + $selisih_form;
                    $kas_after->saldo = $kas_after->saldo - $selisih_form;
                } else {
                    $selisih_form = $model->jumlah1 - $model_sebelumnya->jumlah1;
                    $kas_before->saldo = $kas_before->saldo - $selisih_form;
                    $kas_after->saldo = $kas_after->saldo + $selisih_form;
                }
                $kas_before->save(false);
                $kas_after->save(false);
            }
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id_transfer_kas]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'modal_kas' => $model_kas
        ]);
    }

    /**
     * Deletes an existing AktTransferKas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $kas_before = AktKasBank::find()->where(['id_kas_bank' => $model->id_asal_kas])->one();
        $kas_after = AktKasBank::find()->where(['id_kas_bank' => $model->id_tujuan_kas])->one();

        $kas_before->saldo = $kas_before->saldo + $model->jumlah1;
        $kas_after->saldo = $kas_after->saldo - $model->jumlah1;
        $kas_before->save(false);
        $kas_after->save(false);

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktTransferKas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktTransferKas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktTransferKas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionKas($id)
    {
        $kas_bank = AktKasBank::find()->where(['id_kas_bank' => $id])->one();
        $mata_uang = AktMataUang::find()->where(['id_mata_uang' => $kas_bank->id_mata_uang])->one();
        // $kas_bank = Yii::$app->db->createCommand("SELECT akt_mata_uang.kurs FROM akt_kas_bank LEFT JOIN akt_mata_uang ON akt_mata_uang.id_mata_uang = akt_kas_bank.id_mata_uang WHERE id_kas_bank = '$id'")->queryScalar();
        echo Json::encode($mata_uang);
    }
}
