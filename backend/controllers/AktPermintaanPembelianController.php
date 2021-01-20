<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPermintaanPembelian;
use backend\models\AktPermintaanPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


use backend\models\ItemPermintaanPembelian;
use backend\models\Foto;
use backend\models\Setting;
use backend\models\AktItemStok;
use backend\models\AktItem;
use Mpdf\Mpdf;

/**
 * AktPermintaanPembelianController implements the CRUD actions for AktPermintaanPembelian model.
 */
class AktPermintaanPembelianController extends Controller
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
     * Lists all AktPermintaanPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktPermintaanPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single AktPermintaanPembelian model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if (Yii::$app->request->get('aksi') == 'save') {

            $simpan = new ItemPermintaanPembelian();
            $simpan->id_permintaan_pembelian = $id;
            $simpan->id_item_stok = Yii::$app->request->post('id_item_stok');
            $simpan->quantity = Yii::$app->request->post('quantity');
            $simpan->keterangan = Yii::$app->request->post("keterangan");

            $count_barang = ItemPermintaanPembelian::find()->where(['id_permintaan_pembelian' => $simpan->id_permintaan_pembelian])->andWhere(['id_item_stok' => $simpan->id_item_stok])->count();

            if ($count_barang == 0) {
                $simpan->save(false);
                Yii::$app->session->setFlash("success", "Detail Item Ditambahkan");
            } else {
                Yii::$app->session->setFlash("danger", "Barang Sudah Ada");
            }

            return $this->redirect(['view', 'id' => $id]);
        }

        if (Yii::$app->request->get('action') == "delete_item") {

            ItemPermintaanPembelian::deleteAll(["id_item_permintaan_pembelian" => Yii::$app->request->get('id_item_permintaan_pembelian')]);

            Yii::$app->session->setFlash("success", "Data item berhasil dihapus");

            return $this->redirect(['view', 'id' => $id]);
        }

        $daftar_item = ItemPermintaanPembelian::find()->where(['id_permintaan_pembelian' => $id])->all();

        $array_item = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
        }

        $foto = Foto::find()->where(["id_tabel" => $id, "nama_tabel" => "permintaan-pembelian"])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'foto'  => $foto,
            'array_item' => $array_item,
            'daftar_item' => $daftar_item,
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

    /**
     * Creates a new AktPermintaanPembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktPermintaanPembelian();
        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_permintaan FROM akt_permintaan_pembelian ORDER by no_permintaan DESC LIMIT 1")->queryScalar();
        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7,4);
            // echo $bulanNoUrut; die;
            if($bulanNoUrut !== date('ym') ) {
                $kode = 'PR' . date('ym') . '001';
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
                
                $no_permintaan = "PR" . date('ym') . $noUrut_2;
                $kode = $no_permintaan;
            }
            
        } else {
            # code...
            $kode = 'PR' . date('ym') . '001';
        }
        $model->no_permintaan = $kode;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_permintaan_pembelian]);
        }

        return $this->render('create', [
            'model' => $model,
            // 'nomor' => $nomor
        ]);
    }

    /**
     * Updates an existing AktPermintaanPembelian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $nomor = $model->no_permintaan;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_permintaan_pembelian]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor
        ]);
    }

    /**
     * Deletes an existing AktPermintaanPembelian model.
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

    public function actionApprove($id)
    {
        $id_login =  Yii::$app->user->identity->id_login;
        $model = $this->findModel($id);
        $model->status = 1;
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = $id_login;
        $model->save(false);
        return $this->redirect(['view', 'id' => $model->id_permintaan_pembelian]);
    }

    public function actionReject($id)
    {
        $id_login =  Yii::$app->user->identity->id_login;
        $model = $this->findModel($id);
        $model->status = 3;
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = $id_login;
        $model->save(false);
        return $this->redirect(['view', 'id' => $model->id_permintaan_pembelian]);
    }

    public function actionPending($id)
    {
        $id_login =  Yii::$app->user->identity->id_login;
        $model = $this->findModel($id);
        $model->status = 2;
        $model->tanggal_approve = date("Y-m-d h:i:sa");
        $model->id_login = $id_login;
        $model->save(false);
        return $this->redirect(['view', 'id' => $model->id_permintaan_pembelian]);
    }

    public function actionPrintView($id)
    {
        $daftar_item = ItemPermintaanPembelian::find()->where(['id_permintaan_pembelian' => $id])->all();
        $setting = Setting::find()->one();
        $print =  $this->renderPartial('_print_view', [
            // return $this->renderPartial('request_print', [
            'model' => $this->findModel($id),
            'daftar_item' => $daftar_item,
            'setting' => $setting,
        ]);
        $mPDF = new mPDF([
            'orientation' => 'P',
        ]);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }

    /**
     * Finds the AktPermintaanPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktPermintaanPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktPermintaanPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
