<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenyesuaianStokDetail;
use backend\models\AktPenyesuaianStokDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktItemStok;
use backend\models\AktGudang;
use backend\models\AktPenyesuaianStok;
use yii\helpers\ArrayHelper;

/**
 * AktPenyesuaianStokDetailController implements the CRUD actions for AktPenyesuaianStokDetail model.
 */
class AktPenyesuaianStokDetailController extends Controller
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
     * Lists all AktPenyesuaianStokDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenyesuaianStokDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenyesuaianStokDetail model.
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
     * Creates a new AktPenyesuaianStokDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelName = new AktPenyesuaianStok();
        $model = new AktPenyesuaianStokDetail();
        $model->qty = 0;

        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item ASC")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return $model['nama_item'] . ' - Gudang : ' . $model['nama_gudang'];
            }
        );

        $id_penyesuaian_stok = Yii::$app->request->post('AktPenyesuaianStokDetail')['id_penyesuaian_stok'];
        $akt_penyesuaian_stok = AktPenyesuaianStok::findOne($id_penyesuaian_stok);

        $total_hpp = 0;


        if ($model->load(Yii::$app->request->post())) {
            $id_item_stok = Yii::$app->request->post('AktPenyesuaianStokDetail')['id_item_stok'];
            $item_stok = AktItemStok::findOne($id_item_stok);

            $hpp = $item_stok->hpp * $model->qty;
            $total_hpp += $hpp;

            if ($akt_penyesuaian_stok['tipe_penyesuaian'] == 0) {
                $item_stok->qty = $item_stok->qty - $model->qty;
            } else if ($akt_penyesuaian_stok['tipe_penyesuaian'] == 1) {
                $item_stok->qty = $item_stok->qty + $model->qty;
            }


            $jurnal_transaksi_detail = $modelName->getJurnalTransaksi();
            $akt_history_transaksi = $model->getHistoryTransaksi($akt_penyesuaian_stok['id_penyesuaian_stok']);


            foreach ($jurnal_transaksi_detail as $jt) {

                $jurnal_umum_detail = $model->getJurnalUmumDetail($jt->id_akun, $akt_history_transaksi['id_jurnal_umum']);
                $akun = $model->getDataTable("AktAkun", 'id_akun', $jt->id_akun);

                // PENAMBAHAN dan DEBIT
                if ($akt_penyesuaian_stok['tipe_penyesuaian'] == 1 && $akun->saldo_normal == 1) {
                    $jurnal_umum_detail->debit = $jurnal_umum_detail->debit + $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun + $total_hpp;
                }
                // PENAMBAHAN DAN KREDIT
                elseif ($akt_penyesuaian_stok['tipe_penyesuaian'] == 1 && $akun->saldo_normal == 2) {
                    $jurnal_umum_detail->debit = $jurnal_umum_detail->debit - $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun - $total_hpp;
                }
                // PENGURANGAN dan DEBIT
                elseif ($akt_penyesuaian_stok['tipe_penyesuaian'] == 0 && $akun->saldo_normal == 1) {
                    $jurnal_umum_detail->kredit = $jurnal_umum_detail->kredit - $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun - $total_hpp;
                }

                // PENGURANGAN dan KREDIT
                elseif ($akt_penyesuaian_stok['tipe_penyesuaian'] == 0 && $akun->saldo_normal == 2) {
                    $jurnal_umum_detail->kredit = $jurnal_umum_detail->kredit + $total_hpp;
                    $akun->saldo_akun = $akun->saldo_akun + $total_hpp;
                }

                $akun->save(false);
                $jurnal_umum_detail->save(false);
            }

            $item_stok->save(false);
            $model->save();

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
            return $this->redirect(['akt-penyesuaian-stok/view', 'id' => $model->id_penyesuaian_stok]);
        }

        return $this->render('create', [
            'model' => $model,
            'data_item_stok' => $data_item_stok,
            'akt_penyesuaian_stok' => $akt_penyesuaian_stok,
        ]);
    }

    /**
     * Updates an existing AktPenyesuaianStokDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_sebelumnya = $this->findModel($id);

        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item ASC")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return $model['nama_item'] . ' - Gudang : ' . $model['nama_gudang'];
            }
        );


        $akt_penyesuaian_stok = AktPenyesuaianStok::findOne($model->id_penyesuaian_stok);

        if ($model->load(Yii::$app->request->post())) {



            $model->save();

            Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Disimpan']]);
            return $this->redirect(['akt-penyesuaian-stok/view', 'id' => $model->id_penyesuaian_stok]);
        }

        return $this->render('update', [
            'model' => $model,
            'data_item_stok' => $data_item_stok,
            'akt_penyesuaian_stok' => $akt_penyesuaian_stok,
        ]);
    }

    /**
     * Deletes an existing AktPenyesuaianStokDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $modelName = new AktPenyesuaianStokDetail();
        $model = $this->findModel($id);
        $akt_penyesuaian_stok = AktPenyesuaianStok::findOne($model->id_penyesuaian_stok);
        $update_stok = AktItemStok::find()->where(['id_item_stok' => $model->id_item_stok])->one();

        if ($akt_penyesuaian_stok['tipe_penyesuaian'] == 0) {
            $update_stok->qty = $update_stok->qty + $model->qty;
        } else if ($akt_penyesuaian_stok['tipe_penyesuaian'] == 1) {
            $update_stok->qty = $update_stok->qty - $model->qty;
        }

        $update_stok->save(FALSE);

        $hpp = $model->qty * $update_stok->hpp;
        $akt_history_transaksi = $modelName->getHistoryTransaksi($model->id_penyesuaian_stok);
        $jurnal_umum_detail = $modelName->getDataTable('AktJurnalUmumDetail', 'id_jurnal_umum', $akt_history_transaksi['id_jurnal_umum'], 'all');


        foreach ($jurnal_umum_detail as $ju) {
            $akun = $modelName->getDataTable('AktAkun', 'id_akun', $ju->id_akun);
            if ($ju->debit > 0) {
                $ju->debit = $ju->debit - $hpp;
                $akun->saldo_akun = $akun->saldo_akun - $hpp;
            } elseif ($ju->kredit > 0 || $ju->kredit < 0) {
                $ju->kredit = $ju->kredit + $hpp;
                $akun->saldo_akun = $akun->saldo_akun + $hpp;
            }

            $akun->save(false);
            $ju->save(false);
        }


        $model->delete();

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Dihapus']]);
        return $this->redirect(['akt-penyesuaian-stok/view', 'id' => $model->id_penyesuaian_stok]);
    }

    /**
     * Finds the AktPenyesuaianStokDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPenyesuaianStokDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPenyesuaianStokDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
