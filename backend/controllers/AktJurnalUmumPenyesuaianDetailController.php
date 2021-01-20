<?php

namespace backend\controllers;

use backend\models\AktAkun;
use Yii;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktJurnalUmumDetailController implements the CRUD actions for AktJurnalUmumDetail model.
 */
class AktJurnalUmumPenyesuaianDetailController extends Controller
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
     * Lists all AktJurnalUmumDetail models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new AktJurnalUmumDetailSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    // /**
    //  * Displays a single AktJurnalUmumDetail model.
    //  * @param integer $id
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new AktJurnalUmumDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new AktJurnalUmumDetail();
    //     $model->id_jurnal_umum = $_GET['id'];

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionCreateFromJurnalUmumPenyesuaian()
    {
        $model_id_jurnal_umum = Yii::$app->request->post('AktJurnalUmumDetail')['id_jurnal_umum'];
        $model_id_akun = Yii::$app->request->post('AktJurnalUmumDetail')['id_akun'];
        $model_debit = Yii::$app->request->post('AktJurnalUmumDetail')['debit'];
        $model_kredit = Yii::$app->request->post('AktJurnalUmumDetail')['kredit'];
        $model_keterangan = '-';

        $model = new AktJurnalUmumDetail();
        $model->id_jurnal_umum = $model_id_jurnal_umum;
        $model->id_akun = $model_id_akun;
        $model->debit = $model_debit;
        $model->kredit = $model_kredit;
        $model->keterangan = $model_keterangan;
        $model->save(FALSE);

        return $this->redirect(['akt-jurnal-umum-penyesuaian/view', 'id' => $model->id_jurnal_umum]);
    }

    /**
     * Updates an existing AktJurnalUmumDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);
    //     $model_sebelumnya = $this->findModel($id);

    //     $akt_jurnal_umum = AktJurnalUmum::findOne($model->id_jurnal_umum);

    //     if ($model->load(Yii::$app->request->post())) {
    //         $akun = AktAkun::find()->where(['id_akun' => $model->id_akun])->one();

    //         // inputan debit
    //         if ($model->debit > 0 && $model->kredit == 0) {
    //             if ($model_sebelumnya->debit >= $model->debit) {
    //                 $selisih = $model_sebelumnya->debit - $model->debit;
    //                 $akun->saldo_akun = $akun->saldo_akun - $selisih;
    //             } else if ($model_sebelumnya->debit < $model->debit) {
    //                 $selisih = $model->debit - $model_sebelumnya->debit;
    //                 $akun->saldo_akun = $akun->saldo_akun + $selisih;
    //             }
    //         } elseif ($model->debit == 0 && $model->kredit > 0) {
    //             if ($akun->saldo_akun >= $model->kredit) {
    //                 if ($model_sebelumnya->kredit >= $model->kredit) {
    //                     $selisih = $model_sebelumnya->kredit - $model->kredit;
    //                     $akun->saldo_akun = $akun->saldo_akun + $selisih;
    //                 } else if ($model_sebelumnya->kredit < $model->kredit) {
    //                     $selisih = $model->kredit - $model_sebelumnya->kredit;
    //                     $akun->saldo_akun = $akun->saldo_akun - $selisih;
    //                 }
    //             } else {
    //                 Yii::$app->session->setFlash("danger", "Saldo tidak mencukupi");
    //             }
    //         }
    //         $akun->save(false);
    //         $model->save();
    //         return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //         'akt_jurnal_umum' => $akt_jurnal_umum,
    //     ]);
    // }

    /**
     * Deletes an existing AktJurnalUmumDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['akt-jurnal-umum-penyesuaian/view', 'id' => $model->id_jurnal_umum]);
    }

    /**
     * Finds the AktJurnalUmumDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktJurnalUmumDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktJurnalUmumDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
