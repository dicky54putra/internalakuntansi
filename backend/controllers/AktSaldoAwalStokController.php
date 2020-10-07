<?php

namespace backend\controllers;

use Yii;
use backend\models\AktSaldoAwalStok;
use backend\models\AktItem;
use backend\models\AktSaldoAwalStokDetail;
use backend\models\AktSaldoAwalStokSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * AktSaldoAwalStokController implements the CRUD actions for AktSaldoAwalStok model.
 */
class AktSaldoAwalStokController extends Controller
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
     * Lists all AktSaldoAwalStok models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktSaldoAwalStokSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktSaldoAwalStok model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model_detail = new AktSaldoAwalStokDetail();
        $data_item = ArrayHelper::map(
            AktItem::find()
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item', 'nama_item'
        );
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model_detail' => $model_detail,
            'data_item' => $data_item
        ]);
    }

    /**
     * Creates a new AktSaldoAwalStok model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLevelHarga() {
        $country_id = $_POST['depdrop_parents'][0];
        $state = Yii::$app->db->createCommand("
        SELECT akt_item_stok.id_item_stok, akt_gudang.nama_gudang
        FROM akt_item_stok
        LEFT JOIN akt_gudang ON akt_gudang.id_gudang = akt_item_stok.id_gudang
        WHERE akt_item_stok.id_item = '$country_id'")->query();
        $all_state = array();
        $i = 0;
        foreach ($state as $value) {
            $all_state[$i]['id'] = empty($value['id_item_stok']) ? 0 : $value['id_item_stok'];
            $all_state[$i]['name'] = empty($value['nama_gudang']) ? 'Data Kosong' : $value['nama_gudang'];
            $i++;
        }
        
        echo Json::encode(['output' => $all_state, 'selected' => '']);
        return;
    }
    public function actionCreate()
    {
        $model = new AktSaldoAwalStok();
        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_transaksi FROM `akt_saldo_awal_stok` ORDER by no_transaksi DESC LIMIT 1")->queryScalar();

        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7,4);
            if($bulanNoUrut !== date('ym') ) {
                $kode = 'ST' . date('ym') . '001';
            } else {
                // echo $noUrut; die;
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
                
                $no_transaksi = "ST" . date('ym') . $noUrut_2;
                $kode = $no_transaksi;
            }
            
        } else {
            # code...
            $kode = 'ST' . date('ym') . '001';
        }
        $model->no_transaksi = $kode;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_saldo_awal_stok]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AktSaldoAwalStok model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_saldo_awal_stok]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktSaldoAwalStok model.
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
     * Finds the AktSaldoAwalStok model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktSaldoAwalStok the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktSaldoAwalStok::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
