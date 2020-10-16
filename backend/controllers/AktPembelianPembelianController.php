<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelian;
use backend\models\AktPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use backend\models\AktItemStok;
use backend\models\AktSatuan;
use yii\helpers\ArrayHelper;

use backend\models\ItemPembelian;
use backend\models\Foto;
use backend\models\AktPembelianDetail;
use backend\models\Setting;

/**
 * AktpembelianController implements the CRUD actions for Aktpembelian model.
 */
class AktPembelianPembelianController extends Controller
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
     * Lists all Aktpembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPembelianSearch();
        $dataProvider = $searchModel->searchPembelian(Yii::$app->request->queryParams);
        $is_pembelian = AktPembelian::cekButtonPembelian();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'is_pembelian' => $is_pembelian

        ]);
    }

    /**
     * Displays a single Aktpembelian model
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id'), '#' => 'unggah-dokumen']);
        }

        $foto = Foto::find()->where(["id_tabel" => $model->id_pembelian, "nama_tabel" => "pembelian"])->all();

        if (Yii::$app->request->get('aksi') == "faktur") {

            $akt_pembelian_faktur = AktPembelian::find()->where(['id_pembelian' => Yii::$app->request->get('id')])->one();
            $akt_pembelian_faktur->no_faktur_pembelian = Yii::$app->request->post('no_faktur_pembelian');
            $akt_pembelian_faktur->tanggal_faktur_pembelian = Yii::$app->request->post('tanggal_faktur_pembelian');
            $akt_pembelian_faktur->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian!', 'No. Faktur Berhasil Di Simpan']]);
            return $this->redirect(['view', 'id' => $id, '#' => 'faktur']);
        }

        # form modal input barang
        $model_pembelian_detail_baru = new AktPembelianDetail();
        $model_pembelian_detail_baru->id_pembelian = $model->id_pembelian;
        $model_pembelian_detail_baru->diskon = 0;

        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty", "akt_satuan.nama_satuan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->leftJoin("akt_satuan", "akt_satuan.id_satuan = akt_item.id_satuan")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Satuan : ' . $model['nama_satuan'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        # untuk tombol penerimaan klo data pembelian belom di update belom bisa melakukan penerimaan
        $count_model_no_pembelian = ($model->no_pembelian == NULL) ? 1 : 0;
        $count_model_tanggal_pembelian = ($model->tanggal_pembelian == NULL) ? 1 : 0;
        // $count_model_ongkir = ($model->ongkir == NULL) ? 1 : 0 ;
        // $count_model_pajak = ($model->pajak == NULL) ? 1 : 0 ;
        $count_model_total = ($model->total == NULL) ? 1 : 0;
        // $count_model_diskon = ($model->diskon == NULL) ? 1 : 0 ;
        $count_model_jenis_bayar = ($model->jenis_bayar == 1) ? 0 : $retVal = ($model->jenis_bayar == 2 && $model->tanggal_tempo != NULL && $model->jatuh_tempo != NULL) ? 0 : 1;
        // $count_model_materai = ($model->materai == NULL) ? 1 : 0 ;
        $count_model_id_penagih = ($model->id_penagih == NULL) ? 1 : 0;
        $count_model_no_faktur_pembelian = ($model->no_faktur_pembelian == NULL) ? 1 : 0;
        $count_model_tanggal_faktur_pembelian = ($model->tanggal_faktur_pembelian == NULL) ? 1 : 0;
        $count_data_pembelian_count = $count_model_no_pembelian + $count_model_tanggal_pembelian + 0 + 0 + $count_model_total + 0 + $count_model_jenis_bayar + 0 + $count_model_id_penagih;
        // + $count_model_no_faktur_pembelian + $count_model_tanggal_faktur_pembelian;

        $is_pembelian = AktPembelian::cekButtonPembelian();
        return $this->render('view', [
            'model' => $model,
            'foto' => $foto,
            'is_pembelian' => $is_pembelian,
            'model_pembelian_detail_baru' => $model_pembelian_detail_baru,
            'data_item_stok' => $data_item_stok,
            'count_data_pembelian_count' => $count_data_pembelian_count,
        ]);
    }

    public function actionPenerimaan($id)
    {
        $model = $this->findModel($id);
        $model->status = 5;

        $model->save(FALSE);
        return $this->redirect(['akt-pembelian-penerimaan-sendiri/view', 'id' => $model->id_pembelian]);
    }

    public function actionUpload()
    {
        $model = new Foto();

        if (Yii::$app->request->isPost) {

            $model->nama_tabel  = Yii::$app->request->post('nama_tabel');
            $model->id_tabel    = Yii::$app->request->post('id_tabel');
            $model->save(false);
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel'), '#' => 'unggah-dokumen']);
        } else {
            return $this->redirect(['view', 'id' => Yii::$app->request->post('id_tabel'), '#' => 'unggah-dokumen']);
        }
    }

    public function actionSimpanGrandTotal($id, $grand_total)
    {
        $model = $this->findModel($id);
        $model->total = $grand_total;
        $model->kekurangan = $model->bayar - $model->total;
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Berhasil Di Simpan']]);
        return $this->redirect(['akt-pembelian-pembelian/view', 'id' => $model->id_pembelian]);
    }

    protected function findModel($id)
    {
        if (($model = AktPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateDataPembelian($id)
    {
        $model = $this->findModel($id);
        $model->ongkir = ($model->ongkir == NULL) ? 0 : $model->ongkir;
        $model->diskon = ($model->diskon == NULL) ? 0 : $model->diskon;
        $model->materai = ($model->materai == NULL) ? 0 : $model->materai;

        $query = (new \yii\db\Query())->from('akt_pembelian_detail')->where(['id_pembelian' => $model->id_pembelian]);
        $model_pembelian_detail = $query->sum('total');

        $model->total = ($model->total == NULL) ? $model_pembelian_detail : $model->total;

        $data_penagih = ArrayHelper::map(AktMitraBisnis::find()->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis');

        if ($model->load(Yii::$app->request->post())) {

            $model_ongkir = Yii::$app->request->post('AktPembelian')['ongkir'];
            // $model_total = Yii::$app->request->post('Aktpembelian')['total'];

            $diskon = ($model->diskon > 0) ? ($model->diskon * $model_pembelian_detail) / 100 : 0;
            $pajak = ($model->pajak == 1) ? (($model_pembelian_detail - $diskon) * 10) / 100 : 0;
            $model_total = (($model_pembelian_detail - $diskon) + $pajak) + $model_ongkir + $model->materai;

            $model->ongkir = $model_ongkir;
            $model->total = $model_total;

            if ($model->jenis_bayar == 1) {
                # code...
                $model->jatuh_tempo = NULL;
                $model->tanggal_tempo = NULL;
            }

            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Pembelian Berhasil Di Simpan']]);
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('update_data_pembelian', [
            'model' => $model,
            'data_penagih' => $data_penagih,
            'model_pembelian_detail' => $model_pembelian_detail,
        ]);
    }

    public function actionGetTanggal($id)
    {
        $h = AktPembelian::find()->where(['id_pembelian' => $id])->asArray()->one();
        return json_encode($h);
    }


    public function actionCreate()
    {
        $model = new AktPembelian();

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_pembelian FROM `akt_pembelian` ORDER by no_pembelian DESC LIMIT 1")->queryScalar();

        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            // echo $noUrut; die;
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'PE' . date('ym') . '001';
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

                $no_order_pembelian = "PE" . date('ym') . $noUrut_2;
                $kode = $no_order_pembelian;
            }
        } else {
            # code...
            $kode = 'PE' . date('ym') . '001';
        }

        $model->no_pembelian = $kode;
        $model->no_penerimaan = substr_replace($kode, "PQ", 0, 2);

        $data_customer = AktPembelian::dataCustomer();
        $data_mata_uang = AktPembelian::dataMataUang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $kode,
            'data_customer' => $data_customer,
            'data_mata_uang' => $data_mata_uang,
        ]);
    }
}
