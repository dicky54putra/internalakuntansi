<?php

namespace backend\controllers;

use backend\models\AktAkun;
use Yii;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetailSearch;
use backend\models\AktKasBank;
use backend\models\AktHistoryTransaksi;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktJurnalUmumDetailController implements the CRUD actions for AktJurnalUmumDetail model.
 */
class AktJurnalUmumDetailController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new AktJurnalUmumDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktJurnalUmumDetail model.
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
     * Creates a new AktJurnalUmumDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktJurnalUmumDetail();
        $model->id_jurnal_umum = $_GET['id'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateFromJurnalUmum()
    {
        $model_id_jurnal_umum = Yii::$app->request->post('AktJurnalUmumDetail')['id_jurnal_umum'];
        $model_id_akun = Yii::$app->request->post('AktJurnalUmumDetail')['id_akun'];
        $model_debit = Yii::$app->request->post('AktJurnalUmumDetail')['debit'];
        $model_kredit = Yii::$app->request->post('AktJurnalUmumDetail')['kredit'];
        $model_keterangan = Yii::$app->request->post('AktJurnalUmumDetail')['keterangan'];

        $post_kas_bank = Yii::$app->request->post('detail-kas');


        $post_kas_bank = Yii::$app->request->post('detail-kas');

        if ($model_id_akun == 1) {
            if (empty($post_kas_bank)) {
                Yii::$app->session->setFlash("danger", "Jika akun kas, kas bank harus diisi");
                return $this->redirect(['akt-jurnal-umum/view', 'id' => $model_id_jurnal_umum]);
            }
        }


        $model = new AktJurnalUmumDetail();
        $model->id_jurnal_umum = $model_id_jurnal_umum;
        $model->id_akun = $model_id_akun;
        $model->debit = $model_debit;
        $model->kredit = $model_kredit;
        $model->keterangan = $model_keterangan;




        $akun = AktAkun::find()->where(['id_akun' => $model_id_akun])->one();
        $kas_bank = AktKasBank::findOne($post_kas_bank);

        if ($akun->saldo_normal == 1) {
            if ($model_debit > 0 && $model_kredit == 0) {
                if (strtolower($akun->nama_akun) == 'kas') {
                    $kas_bank->saldo = $kas_bank->saldo + $model_debit - $model_kredit;
                    $kas_bank->save(false);
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $model_debit;
                }
            } elseif ($model_debit == 0 && $model_kredit > 0) {
                if (strtolower($akun->nama_akun) == 'kas') {
                    if ($model_kredit > $kas_bank->saldo) {
                        Yii::$app->session->setFlash("danger", "Saldo tidak mencukupi");
                        return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
                    } else {
                        $kas_bank->saldo = $kas_bank->saldo + $model_debit - $model_kredit;
                        $kas_bank->save(false);
                    }
                } else {
                    if ($akun->saldo_akun >= $model_kredit) {
                        $akun->saldo_akun = $akun->saldo_akun - $model_kredit;
                    } else {
                        Yii::$app->session->setFlash("danger", "Saldo tidak mencukupi");
                        return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
                    }
                }
            }
        } elseif ($akun->saldo_normal == 2) {
            // kredit
            if ($model_kredit > 0 && $model_debit == 0) {
                $akun->saldo_akun = $akun->saldo_akun + $model_kredit;
            } elseif ($model_kredit == 0 && $model_debit > 0) {
                if (strtolower($akun->nama_akun) == 'kas') {
                    if ($model_kredit > $kas_bank->saldo) {
                        Yii::$app->session->setFlash("danger", "Saldo tidak mencukupi");
                        return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
                    } else {
                        $kas_bank->saldo = $kas_bank->saldo + $model_debit - $model_kredit;
                        $kas_bank->save(false);
                    }
                } else {
                    if ($akun->saldo_akun >= $model_debit) {
                        $akun->saldo_akun = $akun->saldo_akun - $model_debit;
                    } else {
                        Yii::$app->session->setFlash("danger", "Saldo tidak mencukupi");
                        return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
                    }
                }
            }
        }
        $akun->save(false);
        $model->save(FALSE);

        if ($post_kas_bank != null) {
            $history_transaksi = new AktHistoryTransaksi();
            $history_transaksi->nama_tabel = 'akt_kas_bank';
            $history_transaksi->id_tabel = $post_kas_bank;
            $history_transaksi->id_jurnal_umum = $model->id_jurnal_umum_detail;
            $history_transaksi->save(false);
        }



        return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
    }


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
        $akun = AktAkun::find()->where(['id_akun' => $model->id_akun])->one();
        if (strtolower($akun->nama_akun) == 'kas') {
            $history_transaksi = AktHistoryTransaksi::find()->where(['id_jurnal_umum' => $model->id_jurnal_umum_detail])->andWhere(['nama_tabel' => 'akt_kas_bank'])->one();
            $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $history_transaksi['id_tabel']])->one();
            if ($akt_kas_bank) {
                $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->debit + $model->kredit;
                $akt_kas_bank->save(false);
            }
            $history_transaksi->delete();
        } else {
            if ($akun->saldo_normal == 1 && $model->debit > 0 || $model->debit < 0) {
                $akun->saldo_akun = $akun->saldo_akun - $model->debit;
            } else if ($akun->saldo_normal == 1 && $model->kredit > 0 || $model->kredit < 0) {
                $akun->saldo_akun = $akun->saldo_akun + $model->kredit;
            } else if ($akun->saldo_normal == 2 && $model->kredit > 0 || $model->kredit < 0) {
                $akun->saldo_akun = $akun->saldo_akun - $model->kredit;
            } else if ($akun->saldo_normal == 2 && $model->debit > 0 || $model->debit < 0) {
                $akun->saldo_akun = $akun->saldo_akun + $model->debit;
            }
            // die;
        }

        $akun->save(false);
        $model->delete();

        return $this->redirect(['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]);
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
