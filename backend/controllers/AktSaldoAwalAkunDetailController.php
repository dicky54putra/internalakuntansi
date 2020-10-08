<?php

namespace backend\controllers;

use Yii;
use backend\models\AktSaldoAwalAkunDetail;
use backend\models\AktSaldoAwalAkunDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\JurnalTransaksiDetail;

/**
 * AktSaldoAwalAkunDetailController implements the CRUD actions for AktSaldoAwalAkunDetail model.
 */
class AktSaldoAwalAkunDetailController extends Controller
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
     * Lists all AktSaldoAwalAkunDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktSaldoAwalAkunDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktSaldoAwalAkunDetail model.
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
     * Creates a new AktSaldoAwalAkunDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktSaldoAwalAkunDetail();

        if ($model->load(Yii::$app->request->post())) {

            $debet = Yii::$app->request->post('AktSaldoAwalAkunDetail')['debet'];
            $kredit = Yii::$app->request->post('AktSaldoAwalAkunDetail')['kredit'];
            $id_akun = Yii::$app->request->post('AktSaldoAwalAkunDetail')['id_akun'];

            if ($debet != null && $kredit != null) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak dapat menambahkan debet dan kredit sekaligus!']]);
            } else {
                $find_akun = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $id_akun])->count();
                if ($find_akun > 0) {
                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Akun ini sudah ada']]);
                } else {
                    // membuat jurnal umum
                    $jurnal_umum = new AktJurnalUmum();
                    $akt_jurnal_umum = AktJurnalUmum::find()->select(["no_jurnal_umum"])->orderBy("id_jurnal_umum DESC")->limit(1)->one();
                    if (!empty($akt_jurnal_umum->no_jurnal_umum)) {
                        # code...
                        $no_bulan = substr($akt_jurnal_umum->no_jurnal_umum, 2, 4);
                        if ($no_bulan == date('ym')) {
                            # code...
                            $noUrut = substr($akt_jurnal_umum->no_jurnal_umum, -3);
                            $noUrut++;
                            $noUrut_2 = sprintf("%03s", $noUrut);
                            $no_jurnal_umum = 'JU' . date('ym') . $noUrut_2;
                        } else {
                            # code...
                            $no_jurnal_umum = 'JU' . date('ym') . '001';
                        }
                    } else {
                        # code...
                        $no_jurnal_umum = 'JU' . date('ym') . '001';
                    }

                    $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
                    $jurnal_umum->tanggal = date('Y-m-d');
                    $jurnal_umum->tipe = 1;

                    $jurnal_umum->save(false);

                    // Create Jurnal Umum detail
                    $jurnal_transaksi = JurnalTransaksiDetail::find()->innerJoin('jurnal_transaksi', 'jurnal_transaksi_detail.id_jurnal_transaksi = jurnal_transaksi.id_jurnal_transaksi')
                        ->where(['nama_transaksi' => 'Set Saldo Awal Kas'])->all();
                    // var_dump($jurnal_transaksi);

                    foreach ($jurnal_transaksi as $k) {
                        $jurnal_umum_detail = new AktJurnalUmumDetail();
                        $akun = AktAkun::findOne($k->id_akun);
                        $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                        $jurnal_umum_detail->id_akun = $k->id_akun;

                        if ($model->kredit > 0) {
                            $isian = $model->kredit;
                        } elseif ($model->debet > 0) {
                            $isian = $model->debet;
                        }


                        if ($k->tipe == 'K') {
                            if ($akun->saldo_normal == 1) {
                                $jurnal_umum_detail->kredit = $isian;
                                $jurnal_umum_detail->debit =  0;
                            } else if ($akun->saldo_normal == 2) {
                                $jurnal_umum_detail->kredit = $isian;
                                $jurnal_umum_detail->debit =  0;
                            }
                            // var_dump($k->tipe);
                            // var_dump($k->id_akun);
                            // var_dump($model->debet);
                        } else if ($k->tipe == 'D') {
                            if ($akun->saldo_normal == 1) {
                                $jurnal_umum_detail->debit =  $isian;
                                $jurnal_umum_detail->kredit =  0;
                            } else if ($akun->saldo_normal == 2) {
                                $jurnal_umum_detail->debit = $isian;
                                $jurnal_umum_detail->kredit =  0;
                            }
                        }
                        $jurnal_umum_detail->save(false);
                    }

                    $model_akun = AktAkun::findOne($id_akun);
                    if ($debet != null) {
                        $model_akun->saldo_akun = $debet;
                    } else if ($kredit != null) {
                        $model_akun->saldo_akun = $kredit;
                    }
                    $model_akun->save(false);
                    $model->save();
                }
            }
            return $this->redirect(['akt-saldo-awal-akun/view', 'id' => $model->id_saldo_awal_akun]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktSaldoAwalAkunDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_akun = AktSaldoAwalAkunDetail::find()->where(['id_saldo_awal_akun_detail' => $id])->one();
        $data_akun = ArrayHelper::map(AktAkun::find()->all(), 'id_akun', 'nama_akun');
        if ($model->load(Yii::$app->request->post())) {
            $debet = Yii::$app->request->post('AktSaldoAwalAkunDetail')['debet'];
            $kredit = Yii::$app->request->post('AktSaldoAwalAkunDetail')['kredit'];
            $id_akun = Yii::$app->request->post('AktSaldoAwalAkunDetail')['id_akun'];
            if ($debet != null && $kredit != null) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak dapat menambahkan debet dan kredit sekaligus!']]);
            } else {

                if ($old_akun->id_akun != $model->id_akun) {
                    $find_akun = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $id_akun])->count();
                    if ($find_akun > 0) {
                        Yii::$app->session->setFlash('danger', [['Perhatian!', 'Akun ini sudah ada']]);
                        return $this->redirect(['akt-saldo-awal-akun-detail/update', 'id' => $id]);
                    }
                } else {
                    $model_akun = AktAkun::findOne($id_akun);
                    if ($debet != null) {
                        $model_akun->saldo_akun = $debet;
                    } else if ($kredit != null) {
                        $model_akun->saldo_akun = $kredit;
                    }
                    $model_akun->save(false);
                    $model->save();
                    return $this->redirect(['akt-saldo-awal-akun/view', 'id' => $model->id_saldo_awal_akun]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'data_akun' => $data_akun
        ]);
    }

    /**
     * Deletes an existing AktSaldoAwalAkunDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model_akun = AktAkun::findOne($model->id_akun);
        $model_akun->saldo_akun = 0;
        $model_akun->save(false);
        $model->delete();
        return $this->redirect(['akt-saldo-awal-akun/view', 'id' => $model->id_saldo_awal_akun]);
    }

    /**
     * Finds the AktSaldoAwalAkunDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktSaldoAwalAkunDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktSaldoAwalAkunDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
