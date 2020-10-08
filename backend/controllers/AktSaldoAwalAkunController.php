<?php

namespace backend\controllers;

use Yii;
use backend\models\AktSaldoAwalAkun;
use backend\models\AktAkun;
use backend\models\AktSaldoAwalAkunDetail;
use backend\models\AktSaldoAwalAkunSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Query;
/**
 * AktSaldoAwalAkunController implements the CRUD actions for AktSaldoAwalAkun model.
 */
class AktSaldoAwalAkunController extends Controller
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
     * Lists all AktSaldoAwalAkun models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktSaldoAwalAkunSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktSaldoAwalAkun model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model_detail = new AktSaldoAwalAkunDetail();
        $detail = (new Query())->select('id_akun')->from('akt_saldo_awal_akun_detail')->where(['id_saldo_awal_akun' => $id]);
        $data_akun = ArrayHelper::map(AktAkun::find()->where(['NOT IN', 'id_akun', $detail])->andWhere(['!=','nama_akun','kas'])->all(), 'id_akun','nama_akun');
        $model_detail->id_saldo_awal_akun = $model->id_saldo_awal_akun;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_detail' => $model_detail,
            'data_akun' =>$data_akun
        ]);
    }

    public function actionGetSaldoNormal($id)
    {
        $akun = AktAkun::find()->where(['id_akun' => $id])->one();
        echo Json::encode($akun);
    }

    /**
     * Creates a new AktSaldoAwalAkun model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktSaldoAwalAkun();

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_jurnal FROM `akt_saldo_awal_akun` ORDER by no_jurnal DESC LIMIT 1")->queryScalar();
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7,4);
            if($bulanNoUrut !== date('ym') ) {
                $kode = 'SA' . date('ym') . '001';
            } else {
                if ($noUrut <= 999) {
                    $noUrut++;
                    $noUrut_2 = sprintf("%03s", $noUrut);
                } elseif ($noUrut <= 9999) {
                    $noUrut++;
                    $noUrut_2 = sprintf("%04s", $noUrut);
                } elseif ($noUrut <= 99999) {
                    $noUrut++;
                    $noUrut_2 = sprintf("%05s", $noUrut);
                }
                
                $no_jurnal = "SA" . date('ym') . $noUrut_2;
                $kode = $no_jurnal;
            }
            
        } else {
            # code...
            $kode = 'SA' . date('ym') . '001';
        }
        $model->no_jurnal = $kode;

        if ($model->load(Yii::$app->request->post())) {
            $kode_post = Yii::$app->request->post('AktSaldoAwalAkun')['no_jurnal'];
            $substr_kode = substr($kode_post, -7,2);
            $count = Yii::$app->db->createCommand("SELECT COUNT(id_saldo_awal_akun) FROM akt_saldo_awal_akun")->queryScalar();

            if($count == 0 ) {
                $model->save();
                return $this->redirect(['view', 'id' => $model->id_saldo_awal_akun]);
            } else {
                if($substr_kode == date('y')) {
                    Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak dapat menambah saldo awal akun baru, ditahun yang sama!']]);
                } else {
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id_saldo_awal_akun]);
                }
            }
           
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktSaldoAwalAkun model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_saldo_awal_akun]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktSaldoAwalAkun model.
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
     * Finds the AktSaldoAwalAkun model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktSaldoAwalAkun the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktSaldoAwalAkun::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
