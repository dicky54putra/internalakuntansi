<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPenjualan;
use backend\models\AktPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktItemStok;
use backend\models\AktMitraBisnisAlamat;
use yii\helpers\ArrayHelper;
use backend\models\Foto;
use backend\models\AktPenjualanDetail;
use backend\models\Setting;
use backend\models\AktPenjualanPengiriman;
use backend\models\AktPenjualanPengirimanDetail;
use yii\web\UploadedFile;

/**
 * AktPenjualanController implements the CRUD actions for AktPenjualan model.
 */
class AktPenjualanPengirimanParentController extends Controller
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
     * Lists all AktPenjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPenjualanSearch();
        $dataProvider = $searchModel->searchPengiriman(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktPenjualan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $model->id_penjualan, "nama_tabel" => "penjualan"])->all();

        $model_penjualan_pengiriman = new AktPenjualanPengiriman();
        $model_penjualan_pengiriman->tanggal_pengiriman = date('Y-m-d');

        $akt_penjualan_pengiriman = AktPenjualanPengiriman::find()->select(["no_pengiriman"])->orderBy("id_penjualan_pengiriman DESC")->limit(1)->one();
        if (!empty($akt_penjualan_pengiriman->no_pengiriman)) {
            # code...
            $no_bulan = substr($akt_penjualan_pengiriman->no_pengiriman, 2, 4);
            if ($no_bulan == date('ym')) {
                # code...
                $noUrut = substr($akt_penjualan_pengiriman->no_pengiriman, -3);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_pengiriman = 'PG' . date('ym') . $noUrut_2;
            } else {
                # code...
                $no_pengiriman = 'PG' . date('ym') . '001';
            }
        } else {
            # code...
            $no_pengiriman = 'PG' . date('ym') . '001';
        }

        $model_penjualan_pengiriman->no_pengiriman = $no_pengiriman;

        $data_mitra_bisnis_alamat = ArrayHelper::map(
            AktMitraBisnisAlamat::find()
                ->where(['id_mitra_bisnis' => $model->id_customer])
                ->andWhere(['!=', 'alamat_pengiriman_penagihan', 2])
                ->orderBy("akt_mitra_bisnis_alamat.keterangan_alamat")
                ->asArray()
                ->all(),
            'id_mitra_bisnis_alamat',
            'keterangan_alamat'
        );

        $data_penjualan_detail = ArrayHelper::map(
            AktPenjualanDetail::find()
                ->select(["akt_item.nama_item as nama_item", "akt_item.kode_item as kode_item", "akt_penjualan_detail.id_penjualan_detail as id_penjualan_detail", "akt_penjualan_detail.qty as qty"])
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item_stok = akt_penjualan_detail.id_item_stok")
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->where(['id_penjualan' => $model->id_penjualan])
                ->asArray()
                ->all(),
            'id_penjualan_detail',
            function ($model) {
                $sum_qty_dikirim = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_detail' => $model['id_penjualan_detail']])->sum("qty_dikirim");
                $sisa_qty_dikirim = $model['qty'] - $sum_qty_dikirim;
                return $model['kode_item'] . ' - ' . $model['nama_item'] . ' : ' . $sisa_qty_dikirim;
            }
        );

        $model_mitra_bisnis_alamat = new AktMitraBisnisAlamat();

        $model_penjualan_pengiriman_detail = new AktPenjualanPengirimanDetail();

        return $this->render('view', [
            'model' => $model,
            'foto' => $foto,
            'model_penjualan_pengiriman' => $model_penjualan_pengiriman,
            'data_mitra_bisnis_alamat' => $data_mitra_bisnis_alamat,
            'model_mitra_bisnis_alamat' => $model_mitra_bisnis_alamat,
            'model_penjualan_pengiriman_detail' => $model_penjualan_pengiriman_detail,
            'data_penjualan_detail' => $data_penjualan_detail,
        ]);
    }

    public function actionUpload()
    {
        $model = new Foto();

        if (Yii::$app->request->isPost) {

            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');

            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        } else {
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel')]);
        }
    }

    protected function findModel($id)
    {
        if (($model = AktPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCetakSuratPengantar($id)
    {
        $model = $this->findModel($id);

        $data_setting = Setting::find()->one();

        return $this->renderPartial('cetak_surat_pengantar', [
            'model' => $model,
            'data_setting' => $data_setting,
        ]);
    }

    public function actionTerkirim($id)
    {
        $model = $this->findModel($id);
        $model->status = 4;
        $model->save(FALSE);
        Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_penjualan . ' Berhasil Terkirim Semua']]);
        return $this->redirect(['view', 'id' => $model->id_penjualan]);
    }

    public function actionTambahDataBarangPengiriman()
    {
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);

        $model_penjualan_pengiriman_detail = new AktPenjualanPengirimanDetail();

        if ($model_penjualan_pengiriman_detail->load(Yii::$app->request->post())) {
            # code...

            $penjualan_detail = AktPenjualanDetail::findOne($model_penjualan_pengiriman_detail->id_penjualan_detail);

            $sum_dikirim = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_detail' => $model_penjualan_pengiriman_detail->id_penjualan_detail])->sum("qty_dikirim");

            $total_dikirim = $sum_dikirim + $model_penjualan_pengiriman_detail->qty_dikirim;

            if ($total_dikirim <= $penjualan_detail->qty) {
                # code...
                $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);

                if ($model_penjualan_pengiriman_detail->qty_dikirim <= $item_stok->qty) {
                    # code...
                    $model_penjualan_pengiriman_detail->save(FALSE);

                    $item_stok->qty = $item_stok->qty - $model_penjualan_pengiriman_detail->qty_dikirim;
                    $item_stok->save(FALSE);

                    Yii::$app->session->setFlash('success', [['Perhatian !', 'Data Barang Yang Akan Dikirim Berhasil di Tambahkan']]);
                } else {
                    # code...
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Qty Yang Diinput Melebihi Stok Barang']]);
                }
            } else {
                # code...
                Yii::$app->session->setFlash('danger', [['Perhatian !', 'Qty Yang Diinput Melebihi Yang Harus Dikirim']]);
            }
        }

        return $this->redirect(['view', 'id' => $model->id_penjualan, '#' => 'data-pengiriman']);
    }

    public function actionDeletePenjualanPengiriman($id)
    {
        $model_penjualan_pengiriman = AktPenjualanPengiriman::findOne($id);
        $model_penjualan_pengiriman->delete();

        Yii::$app->session->setFlash('success', [['Perhatian !', 'Pengiriman No : ' . $model_penjualan_pengiriman->no_pengiriman . ' Berhasil di Hapuskan']]);

        return $this->redirect(['view', 'id' => $model_penjualan_pengiriman->id_penjualan, '#' => 'data-pengiriman']);
    }
}
