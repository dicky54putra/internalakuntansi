<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

use backend\models\AktItemStokSearch;
use backend\models\AktGudang;
use yii\helpers\ArrayHelper;
use backend\models\AktPenyesuaianStok;
use backend\models\AktStokKeluar;
use backend\models\AktTransferStok;
use backend\models\AktStokMasuk;

/**
 * DaftarMisiController implements the CRUD actions for DaftarMisi model.
 */
class AktLaporanStokController extends Controller
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

    public function actionLihatStok()
    {
        $searchModel = new AktItemStokSearch();
        $dataProvider = $searchModel->searchLihatStok(Yii::$app->request->queryParams);

        return $this->render('lihat_stok', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLaporanTransferStok()
    {
        $data_gudang = ArrayHelper::map(
            AktGudang::find()
                ->select(["akt_gudang.id_gudang", "akt_gudang.nama_gudang"])
                ->orderBy("akt_gudang.nama_gudang ASC")
                ->asArray()
                ->all(),
            'id_gudang',
            function ($model) {
                return $model['nama_gudang'];
            }
        );

        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $id_gudang_asal = Yii::$app->request->post('id_gudang_asal');
        $id_gudang_tujuan = Yii::$app->request->post('id_gudang_tujuan');

        $where_gudang_asal = "";
        if ($id_gudang_asal != "") {
            # code...
            $where_gudang_asal = " AND id_gudang_asal = " . $id_gudang_asal . " ";
        }
        $where_gudang_tujuan = "";
        if ($id_gudang_tujuan != "") {
            # code...
            $where_gudang_tujuan = " AND id_gudang_tujuan = " . $id_gudang_tujuan . " ";
        }
        $count_transfer_stok = AktTransferStok::find()->where("tanggal_transfer BETWEEN '$tanggal_awal' AND '$tanggal_akhir' $where_gudang_asal $where_gudang_tujuan")->count();

        return $this->render('laporan_transfer_stok', [
            'data_gudang' => $data_gudang,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_gudang_asal' => $id_gudang_asal,
            'id_gudang_tujuan' => $id_gudang_tujuan,
            'count_transfer_stok' => $count_transfer_stok,
        ]);
    }

    public function actionLaporanTransferStokCetak()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $id_gudang_asal = Yii::$app->request->post('id_gudang_asal');
        $id_gudang_tujuan = Yii::$app->request->post('id_gudang_tujuan');

        return $this->renderPartial('laporan_transfer_stok_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_gudang_asal' => $id_gudang_asal,
            'id_gudang_tujuan' => $id_gudang_tujuan,
        ]);
    }

    public function actionLaporanTransferStokExportExcel()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $id_gudang_asal = Yii::$app->request->post('id_gudang_asal');
        $id_gudang_tujuan = Yii::$app->request->post('id_gudang_tujuan');

        return $this->renderPartial('laporan_transfer_stok_export_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'id_gudang_asal' => $id_gudang_asal,
            'id_gudang_tujuan' => $id_gudang_tujuan,
        ]);
    }

    public function actionLaporanPenyesuaianStok()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $metode = Yii::$app->request->post('metode');

        $where_metode = "";
        if ($metode != "") {
            # code...
            $where_metode = " AND metode = " . $metode . " ";
        }

        $count_penyesuaian_stok = AktPenyesuaianStok::find()->where("tanggal_penyesuaian BETWEEN '$tanggal_awal' AND '$tanggal_akhir' $where_metode")->count();

        return $this->render('laporan_penyesuaian_stok', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'metode' => $metode,
            'count_penyesuaian_stok' => $count_penyesuaian_stok,
        ]);
    }

    public function actionLaporanPenyesuaianStokCetak()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $metode = Yii::$app->request->post('metode');

        return $this->renderPartial('laporan_penyesuaian_stok_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'metode' => $metode,
        ]);
    }

    public function actionLaporanPenyesuaianStokExportExcel()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');
        $metode = Yii::$app->request->post('metode');

        return $this->renderPartial('laporan_penyesuaian_stok_export_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'metode' => $metode,
        ]);
    }

    public function actionLaporanStokMasuk()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_stok_masuk', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanStokMasukCetak($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_stok_masuk_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanStokMasukExcel($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_stok_masuk_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanStokKeluar()
    {
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        return $this->render('laporan_stok_keluar', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanStokKeluarCetak($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_stok_keluar_cetak', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }

    public function actionLaporanStokKeluarExcel($tanggal_awal, $tanggal_akhir)
    {
        return $this->renderPartial('laporan_stok_keluar_excel', [
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]);
    }
}
