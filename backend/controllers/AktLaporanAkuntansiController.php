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
class AktLaporanAkuntansiController extends Controller
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

    public function actionLaporanDaftarAkun()
    {
        $searchModel = new AktAkunSearch();
        $dataProvider = $searchModel->searchLaporanDaftarAkun(Yii::$app->request->queryParams);

        return $this->render('laporan_daftar_akun', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanBukuBesar()
    {
        $data_jenis = array(
            1 => 'Harta',
            2 => 'Kewajiban',
            3 => 'Modal',
            4 => 'Pendapatan',
            5 => 'Pendapatan Lain',
            6 => 'Pengeluaran Lain',
            7 => 'Biaya Atas Pendapatan',
            8 => 'Pengeluaran Operasional',
        );

        $data_klasifikasi = ArrayHelper::map(AktKlasifikasi::find()->all(), 'id_klasifikasi', 'klasifikasi');

        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $jenis = Yii::$app->request->post('jenis');
        $klasifikasi = Yii::$app->request->post('klasifikasi');

        return $this->render('laporan_buku_besar', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jenis' => $jenis,
            'klasifikasi' => $klasifikasi,
            'data_jenis' => $data_jenis,
            'data_klasifikasi' => $data_klasifikasi,
        ]);
    }

    public function actionLaporanBukuBesarCetak($tanggal_awal, $tanggal_akhir, $jenis, $klasifikasi)
    {

        return $this->renderPartial('laporan_buku_besar_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jenis' => $jenis,
            'klasifikasi' => $klasifikasi,
        ]);
    }

    public function actionLaporanBukuBesarExcel($tanggal_awal, $tanggal_akhir, $jenis, $klasifikasi)
    {

        return $this->renderPartial('laporan_buku_besar_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jenis' => $jenis,
            'klasifikasi' => $klasifikasi,
        ]);
    }

    public function actionLaporanNeracaSaldoSebelumExcel($tanggal_awal, $tanggal_akhir)
    {

        return $this->renderPartial('laporan_neraca_saldo_sebelum_penyesuaian_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanJurnalUmum()
    {
        # sementara tipe jurnal tidak di gunakan terlebih dahulu
        // $data_tipe_jurnal = array(
        //     1 => 'Akuntansi',
        //     2 => 'Saldo Awal',
        //     3 => 'Bill Of Material',
        //     4 => 'Penyesuaian Kas',
        //     5 => 'Revaluasi Kas',
        //     6 => 'Cek/BG',
        //     7 => 'Tutup Buku',
        //     8 => 'Konsinyasi',
        //     9 => 'Mutasi Kas',
        //     10 => 'Pengiriman',
        //     11 => 'Order Pengiriman',
        //     12 => 'Uang Muka',
        //     13 => 'Harta Tetap',
        //     14 => 'Penyusutan Harta Tetap',
        //     15 => 'Nota Potong',
        //     16 => 'General Jurnal',
        //     17 => 'Jurnal Umum',
        //     18 => 'Manufaktur',
        //     19 => 'Manufaktur Material',
        //     20 => 'Manufaktur Products',
        //     21 => 'Pembayaran',
        //     22 => 'Order Pembelian',
        //     23 => 'Sesi Kasir',
        //     24 => 'Penerimaan Pembelian',
        //     25 => 'Permintaan Pembelian',
        //     26 => 'Retur Pembelian',
        //     27 => 'Pembelian',
        //     28 => 'Penerimaan Pembayaran',
        //     29 => 'Revaluasi Kurs',
        //     30 => 'Penyesuaian Stock',
        //     31 => 'Penjualan',
        //     32 => 'Pengiriman Stock',
        //     33 => 'Stock Masuk',
        //     34 => 'Order Penjualan',
        //     35 => 'Stock Opname',
        //     36 => 'Stock Keluar',
        //     37 => 'Quote Penjualan',
        //     38 => 'Penerimaan Stock',
        //     39 => 'Permintaan Barang',
        //     40 => 'Retur Penjualan',
        //     41 => 'Stock Transfer',
        // );

        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        // $tipe_jurnal = Yii::$app->request->post('tipe_jurnal');

        return $this->render('laporan_jurnal_umum', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            // 'tipe_jurnal' => $tipe_jurnal,
            // 'data_tipe_jurnal' => $data_tipe_jurnal,
        ]);
    }

    public function actionLaporanJurnalUmumCetak($tanggal_awal, $tanggal_akhir)
    {

        return $this->renderPartial('laporan_jurnal_umum_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanJurnalUmumExcel($tanggal_awal, $tanggal_akhir)
    {

        return $this->renderPartial('laporan_jurnal_umum_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanNeracaSaldoSebelumPenyesuaian()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_neraca_saldo_sebelum_penyesuaian', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanJurnalPenyesuaian()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_jurnal_penyesuaian', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanJurnalPenyesuaianCetak($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_jurnal_penyesuaian_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanJurnalPenyesuaianExcel($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_jurnal_penyesuaian_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanNeracaSaldoSetelahPenyesuaian()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_neraca_saldo_setelah_penyesuaian', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanNeracaLajur()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_neraca_lajur', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanNeracaLajurCetak($tanggal_awal, $tanggal_akhir)
    {
        return $this->render('laporan_neraca_lajur_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanNeracaLajurExcel($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_neraca_lajur_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanLabaRugi()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_laba_rugi', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanLabaRugiCetak($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_laba_rugi_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanLabaRugiExcel($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_laba_rugi_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanPerubahanEkuitas()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_perubahan_ekuitas', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanArusKas()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $jurnal_umum_detail = AktJurnalUmumDetail::find()
                ->select('*')
                ->innerJoin('akt_akun', 'akt_akun.id_akun = akt_jurnal_umum_detail.id_akun')
                ->innerJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')
                ->where(['=', 'akt_akun.nama_akun', 'kas'])
                ->where(['between', 'tanggal', $tanggal_awal, $tanggal_akhir])
                ->all();
        } else {
            $jurnal_umum_detail = AktJurnalUmumDetail::find()
                ->select('*')
                ->innerJoin('akt_akun', 'akt_akun.id_akun = akt_jurnal_umum_detail.id_akun')
                ->innerJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')
                ->where(['=', 'akt_akun.nama_akun', 'kas'])
                ->all();
        }

        return $this->render('laporan_arus_kas', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jurnal_umum_detail' => $jurnal_umum_detail,
        ]);
    }

    public function actionLaporanArusKasCetak($tanggal_awal, $tanggal_akhir)
    {

        return $this->renderPartial('laporan_arus_kas_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanArusKasExcel($tanggal_awal, $tanggal_akhir)
    {

        return $this->renderPartial('laporan_arus_kas_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanDaftarHartaTetap()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_daftar_harta_tetap', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanPajakPpn()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $tipe = Yii::$app->request->post('tipe');

        return $this->render('laporan_pajak_ppn', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tipe' => $tipe,
        ]);
    }

    public function actionLaporanPpnCetak($tanggal_awal, $tanggal_akhir, $tipe)
    {
        return $this->renderPartial('laporan_pajak_ppn_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tipe' => $tipe,
        ]);
    }

    public function actionLaporanPpnExcel($tanggal_awal, $tanggal_akhir, $tipe)
    {
        return $this->renderPartial('laporan_pajak_ppn_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tipe' => $tipe,
        ]);
    }

    public function actionLaporanRekonsiliasiPpn()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_rekonsiliasi_ppn', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanRekonsiliasiPpnCetak($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_rekonsiliasi_ppn_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanRekonsiliasiPpnExport($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_rekonsiliasi_ppn_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanPajakPph()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $tipe = Yii::$app->request->post('tipe');

        return $this->render('laporan_pajak_pph', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tipe' => $tipe,
        ]);
    }

    public function actionLaporanPajakPphCetak($tanggal_awal, $tanggal_akhir, $tipe)
    {
        return $this->renderPartial('laporan_pajak_pph_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tipe' => $tipe,
        ]);
    }

    public function actionLaporanPajakPphExport($tanggal_awal, $tanggal_akhir, $tipe)
    {
        return $this->renderPartial('laporan_pajak_pph_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'tipe' => $tipe,
        ]);
    }

    public function actionLaporanAnggaranVsRealisasi()
    {
        $data_jenis = array(
            1 => 'Harta',
            2 => 'Kewajiban',
            3 => 'Modal',
            4 => 'Pendapatan',
            5 => 'Pendapatan Lain',
            6 => 'Pengeluaran Lain',
            7 => 'Biaya Atas Pendapatan',
            8 => 'Pengeluaran Operasional',
        );

        $data_klasifikasi = ArrayHelper::map(AktKlasifikasi::find()->all(), 'id_klasifikasi', 'klasifikasi');

        $data_akun = ArrayHelper::map(
            AktAkun::find()->all(),
            'id_akun',
            function ($model) {
                return $model['kode_akun'] . ' - ' . $model['nama_akun'];
            }
        );

        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $jenis = Yii::$app->request->post('jenis');
        $klasifikasi = Yii::$app->request->post('klasifikasi');
        $akun = Yii::$app->request->post('akun');

        return $this->render('laporan_anggaran_vs_realisasi', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jenis' => $jenis,
            'klasifikasi' => $klasifikasi,
            'akun' => $akun,
            'data_jenis' => $data_jenis,
            'data_klasifikasi' => $data_klasifikasi,
            'data_akun' => $data_akun,
        ]);
    }

    public function actionLaporanNeracaSaldo()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_neraca_saldo', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanNeracaSaldoCetak($tanggal_awal, $tanggal_akhir)
    {

        return $this->renderPartial('laporan_neraca_saldo_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanNeracaSaldoExcel($tanggal_awal, $tanggal_akhir)
    {

        return $this->renderPartial('laporan_neraca_saldo_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }
}
