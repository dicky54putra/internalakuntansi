<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * AktStokOpnameController implements the CRUD actions for AktStokOpname model.
 */
class AktTutupBukuController extends Controller
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
     * Lists all AktStokOpname models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $tutup_buku = Yii::$app->request->post('tutup_buku');

        return $this->render('index', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tutup_buku' => $tutup_buku,
        ]);
    }

    public function actionCetakTutupBukuPenjualan($tanggal_awal, $tanggal_akhir, $tutup_buku)
    {
        return $this->renderPartial('cetak_tutup_buku_penjualan', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tutup_buku' => $tutup_buku,
        ]);
    }

    public function actionExportTutupBukuPenjualan($tanggal_awal, $tanggal_akhir, $tutup_buku)
    {
        return $this->renderPartial('export_tutup_buku_penjualan', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tutup_buku' => $tutup_buku,
        ]);
    }

    public function actionCetakTutupBukuPembelian($tanggal_awal, $tanggal_akhir, $tutup_buku)
    {
        return $this->renderPartial('cetak_tutup_buku_pembelian', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tutup_buku' => $tutup_buku,
        ]);
    }

    public function actionExportTutupBukuPembelian($tanggal_awal, $tanggal_akhir, $tutup_buku)
    {
        return $this->renderPartial('export_tutup_buku_pembelian', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tutup_buku' => $tutup_buku,
        ]);
    }
}
