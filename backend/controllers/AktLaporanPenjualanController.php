<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualan;
use backend\models\AktPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use backend\models\AktItemStok;
use yii\helpers\ArrayHelper;
use backend\models\Foto;
use backend\models\AktPenjualanDetail;
use backend\models\AktJurnalUmum;
use backend\models\AktHistoryTransaksi;
use backend\models\JurnalTransaksi;
use backend\models\JurnalTransaksiDetail;
use backend\models\JurnalUmumDetail;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\Setting;
use yii\helpers\Json;

/**
 * AktPenjualanController implements the CRUD actions for AktPenjualan model.
 */
class AktLaporanPenjualanController extends Controller
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

    public function actionIndex()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('index', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanPenjualanCetak($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_penjualan_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanPenjualanExcel($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_penjualan_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }
}
