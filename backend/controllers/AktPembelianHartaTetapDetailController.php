<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelianHartaTetapDetail;
use backend\models\AktPembelianHartaTetapDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AktPembelianHartaTetapDetailController implements the CRUD actions for AktPembelianHartaTetapDetail model.
 */
class AktPembelianHartaTetapDetailController extends Controller
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
    public function actionCreate()
    {
        $model = new AktPembelianHartaTetapDetail();

        if ($model->load(Yii::$app->request->post())) {
            $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT kode_pembelian FROM akt_pembelian_harta_tetap_detail ORDER by kode_pembelian DESC LIMIT 1")->queryScalar();

            if (empty($nomor_sebelumnya)) {
                # code...
                $kode = 'HT' . date('ym') . '001';
            } else {
                $noUrut = (int) substr($nomor_sebelumnya, 6);
                $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
                // echo $bulanNoUrut; die;
                if ($bulanNoUrut !== date('ym')) {
                    $kode = 'HT' . date('ym') . '001';
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

                    $no_pembelian_harta_tetap = "HT" . date('ym') . $noUrut_2;
                    $kode = $no_pembelian_harta_tetap;
                }
            }



            $diskon = $model->harga * $model->diskon / 100;
            $total = $model->harga - $diskon;
            $model->total = $total;
            $model->kode_pembelian = $kode;
            $model->qty = 1;
            $model->save(false);

            return $this->redirect(['akt-pembelian-harta-tetap/view', 'id' => $model->id_pembelian_harta_tetap]);
        }
    }

    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['akt-pembelian-harta-tetap/view', 'id' => $model->id_pembelian_harta_tetap]);
    }

    protected function findModel($id)
    {
        if (($model = AktPembelianHartaTetapDetail::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
