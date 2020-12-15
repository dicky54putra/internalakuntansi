<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
use yii\helpers\ArrayHelper;
use backend\models\AktKlasifikasi;
use backend\models\AktAkun;
use backend\models\AktAkunSearch;
use backend\models\AktJurnalUmumDetail;

/**
 * DaftarMisiController implements the CRUD actions for DaftarMisi model.
 */
class AktLaporanKasController extends Controller
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
        return $this->render('index');
    }

    public function actionLaporanKartuKas()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $kasbank = Yii::$app->request->post('kasbank');

        return $this->render('laporan_kartu_kas', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kasbank' => $kasbank,
        ]);
    }

    public function actionLaporanRekapTransferKas()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $kasbank_asal = Yii::$app->request->post('kasbank_asal');
        $kasbank_tujuan = Yii::$app->request->post('kasbank_tujuan');

        return $this->render('laporan_rekap_transfer_kas', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kasbank_asal' => $kasbank_asal,
            'kasbank_tujuan' => $kasbank_tujuan,
        ]);
    }

    public function actionLaporanRekapTransferKasCetak($tanggal_awal, $tanggal_akhir, $kasbank_asal = null, $kasbank_tujuan = null)
    {
        return $this->renderPartial('laporan_rekap_transfer_kas_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kasbank_asal' => $kasbank_asal,
            'kasbank_tujuan' => $kasbank_tujuan,
        ]);
    }

    public function actionLaporanRekapTransferKasExport($tanggal_awal, $tanggal_akhir, $kasbank_asal = null, $kasbank_tujuan = null)
    {
        return $this->renderPartial('laporan_rekap_transfer_kas_export', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kasbank_asal' => $kasbank_asal,
            'kasbank_tujuan' => $kasbank_tujuan,
        ]);
    }

    public function actionLaporanTransferKas()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $kasbank_asal = Yii::$app->request->post('kasbank_asal');
        $kasbank_tujuan = Yii::$app->request->post('kasbank_tujuan');

        return $this->render('laporan_transfer_kas', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kasbank_asal' => $kasbank_asal,
            'kasbank_tujuan' => $kasbank_tujuan,
        ]);
    }

    public function actionLaporanTransferKasCetak($tanggal_awal, $tanggal_akhir, $kasbank_asal = null, $kasbank_tujuan = null)
    {
        return $this->renderPartial('laporan_transfer_kas_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kasbank_asal' => $kasbank_asal,
            'kasbank_tujuan' => $kasbank_tujuan,
        ]);
    }

    public function actionLaporanTransferKasExport($tanggal_awal, $tanggal_akhir, $kasbank_asal = null, $kasbank_tujuan = null)
    {
        return $this->renderPartial('laporan_transfer_kas_export', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'kasbank_asal' => $kasbank_asal,
            'kasbank_tujuan' => $kasbank_tujuan,
        ]);
    }

    public function actionLaporanDetailPembayaran()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $supplier = Yii::$app->request->post('supplier');
        // $akun_tujuan = Yii::$app->request->post('akun_tujuan');

        return $this->render('laporan_detail_pembayaran', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'supplier' => $supplier,
            // 'akun_tujuan' => $akun_tujuan,
        ]);
    }

    public function actionLaporanDetailPembayaranExport($tanggal_awal, $tanggal_akhir, $supplier = null)
    {
        return $this->renderPartial('laporan_detail_pembayaran_export', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'supplier' => $supplier,
        ]);
    }

    public function actionLaporanDetailPenerimaanPembayaran()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $customer = Yii::$app->request->post('customer');
        // $akun_tujuan = Yii::$app->request->post('akun_tujuan');

        return $this->render('laporan_detail_penerimaan_pembayaran', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'customer' => $customer,
            // 'akun_tujuan' => $akun_tujuan,
        ]);
    }

    public function actionLaporanHutangVsPiutang()
    {
        $jatuh_tempo = Yii::$app->request->post('jatuh_tempo');

        return $this->render('laporan_hutang_vs_piutang', [
            'jatuh_tempo' => $jatuh_tempo,
        ]);
    }

    public function actionLaporanHutangVsPiutangCetak($jatuh_tempo)
    {
        return $this->renderPartial('laporan_hutang_vs_piutang_cetak', [
            'jatuh_tempo' => $jatuh_tempo,
        ]);
    }

    public function actionLaporanHutangVsPiutangExport($jatuh_tempo)
    {
        return $this->renderPartial('laporan_hutang_vs_piutang_export', [
            'jatuh_tempo' => $jatuh_tempo,
        ]);
    }
}
