<?php

namespace backend\controllers;

use Yii;
use backend\models\AktProduksiBom;
use backend\models\AktBom;
use backend\models\AktItemStok;
use backend\models\AktBomDetailBb;
use backend\models\AktProduksiBomSearch;
use backend\models\AktProduksiBomDetailBb;
use backend\models\AktProduksiBomDetailHp;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use backend\models\Setting;
use Mpdf\Mpdf;
use backend\models\AktAkun;
use yii\helpers\ArrayHelper;

/**
 * AktProduksiBomController implements the CRUD actions for AktProduksiBom model.
 */
class AktProduksiBomController extends Controller
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
     * Lists all AktProduksiBom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktProduksiBomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single AktProduksiBom model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->get('aksi') == "save") {
            $bahan = new AktBomDetailBb();
            $id_bom = $model->id_bom;
            $bahan_item = new AktItemStok;

            $id_item_stok = Yii::$app->request->post('id_item_stok');
            $qty = Yii::$app->request->post('qty');
            $harga = Yii::$app->request->post('harga');
            $keterangan = Yii::$app->request->post('keterangan');
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$id_item_stok'")->queryScalar();
            $cek_item =  Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_bom WHERE id_bom = '$_GET[id]' AND id_item_stok = '$id_item_stok'")->queryScalar();

            // var_dump($qty);
            // var_dump($cek_qty);
            // die;

            if ($qty > $cek_qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            } else if ($cek_item > 0) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item yang diinputkan tidak boleh sama dengan, item yang diinputkan pada B.o.M!']]);
            } else {
                $bahan->id_bom = $id_bom;
                $bahan->id_item_stok = $id_item_stok;
                $bahan->qty = $qty;
                $bahan->harga = $harga;
                $bahan->keterangan = $keterangan;

                $bahan->save(false);
                Yii::$app->session->setFlash('success', [['Berhasil!', 'Barang berhasil diinput!']]);
                return $this->redirect(['akt-produksi-bom/view', 'id' => $id]);
            }
        }

        if (Yii::$app->request->get('aksi') == "hasil") {
            $bahan = new AktProduksiBomDetailHp();
            $bahan_item = new AktItemStok;

            $id_item_stok = Yii::$app->request->post('id_item_stok');
            $qty = Yii::$app->request->post('qty');
            $keterangan = Yii::$app->request->post('keterangan');
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$id_item_stok'")->queryScalar();
            $cek_item =  Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_bom WHERE id_bom = '$_GET[id]' AND id_item_stok = '$id_item_stok'")->queryScalar();

            if ($qty > $cek_qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            } else if ($cek_item > 0) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item yang diinputkan tidak boleh sama dengan, item yang diinputkan pada B.o.M!']]);
            } else {
                $bahan->id_produksi_bom = $id;
                $bahan->id_item_stok = $id_item_stok;
                $bahan->qty = $qty;
                $bahan->keterangan = $keterangan;

                $bahan->save(false);
                Yii::$app->session->setFlash('success', [['Berhasil!', 'Barang berhasil diinput!']]);
                return $this->redirect(['akt-produksi-bom/view', 'id' => $id]);
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new AktProduksiBom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AktProduksiBom();
        // $total = Yii::$app->db->createCommand("SELECT count(id_produksi_bom) from akt_produksi_bom where date_format(tanggal, '%Y-%m') = '" . date('Y-m') . "'")->queryScalar();
        // $nomor = 'PB' . date('ym') . str_pad($total + 1, 3, "0", STR_PAD_LEFT);
        // $id_bom_max = AktProduksiBom::find()->select(['max(id_produksi_bom) as id_produksi_bom'])->one();
        // $nomor_sebelumnya = AktProduksiBom::find()->select(['SUBSTRING(no_produksi_bom, 3, 4) as no_produksi_bom'])->where(['id_produksi_bom' => $id_bom_max])->one();
        // if (!empty($nomor_sebelumnya->no_produksi_bom)) {
        //     # code...
        //     if ($nomor_sebelumnya->no_produksi_bom == date('ym')) {
        //         # code...
        //         // $kode = 'oke' . $nomor_sebelumnya->no_bom . ' - ' . date('ym');
        //         $noUrut = (int) substr($nomor_sebelumnya->no_produksi_bom, 2, 4);
        //         $noUrut++;
        //         $noUrut_2 = sprintf("%03s", $noUrut);
        //         $no_produksi_bom = "PB" . date('ym') . $noUrut_2;
        //         $kode = $no_produksi_bom;
        //     } else {
        //         # code...

        //         $kode = 'PB' . date('ym') . '001';
        //     }

        //     // $noUrut = (int) substr($nomor_sebelumnya->no_bom, 2, 4);
        //     // $noUrut++;
        //     // $noUrut_2 = sprintf("%03s", $noUrut);
        //     // $no_bom = "AB" . date('ym') . $noUrut_2;
        //     // $kode = $no_bom;
        // } else {
        //     # code...
        //     $kode = 'PB' . date('ym') . '001';
        // }
        $model_akun = new AktAkun();
        $data_akun = ArrayHelper::map(AktAkun::find()->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_produksi_bom FROM `akt_produksi_bom` ORDER by no_produksi_bom DESC LIMIT 1")->queryScalar();
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'PB' . date('ym') . '001';
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

                $no_order_pembelian = "PB" . date('ym') . $noUrut_2;
                $kode = $no_order_pembelian;
            }
        } else {
            # code...
            $kode = 'PB' . date('ym') . '001';
        }

        $nomor = $kode;

        $model->tanggal = date('Y-m-d');
        // $nomor = 'PB' . str_pad($total + 1, 3, "0", STR_PAD_LEFT);
        if ($model->load(Yii::$app->request->post())) {

            $tipe = Yii::$app->request->post('AktProduksiBom')['tipe'];
            // echo $tipe;
            $id_bom = Yii::$app->request->post('AktProduksiBom')['id_bom'];
            $tipe_bom = Yii::$app->db->createCommand("SELECT tipe FROM akt_bom WHERE id_bom = '$id_bom'")->queryScalar();

            if ($tipe != $tipe_bom) {
                Yii::$app->session->setFlash('danger', 'Tipe tidak sama dengan Tipe B.o.M');
            } else {
                $cek_bom = AktProduksiBom::find()->where(['id_bom' => $id_bom])->one();
                // echo $cek_bom->id_bom;
                // die;
                if (!empty($cek_bom)) {
                    Yii::$app->session->setFlash('danger', 'B.o.M Sudah ada');
                } else {
                    // echo 'ok';
                    // die;

                    $model->save();
                    $akt_produksi_bom_detail_hp = new AktProduksiBomDetailHp();
                    $akt_produksi_bom_detail_hp_select = AktBom::findOne($id_bom);
                    $akt_produksi_bom_detail_hp->id_produksi_bom = $model->id_produksi_bom;
                    $akt_produksi_bom_detail_hp->id_item_stok = $akt_produksi_bom_detail_hp_select["id_item_stok"];
                    $akt_produksi_bom_detail_hp->qty = $akt_produksi_bom_detail_hp_select['qty'];
                    $akt_produksi_bom_detail_hp->keterangan = $akt_produksi_bom_detail_hp_select['keterangan'];
                    $akt_produksi_bom_detail_hp->save(FALSE);


                    $akt_produksi_bom_detail_bb_select = Yii::$app->db->createCommand("SELECT * FROM akt_bom_detail_bb WHERE id_bom = '$id_bom'")->query();
                    foreach ($akt_produksi_bom_detail_bb_select as $bb) {
                        $akt_produksi_bom_detail_bb = new AktProduksiBomDetailBb();
                        $akt_produksi_bom_detail_bb->id_produksi_bom = $model->id_produksi_bom;
                        $akt_produksi_bom_detail_bb->id_item_stok = $bb['id_item_stok'];
                        $akt_produksi_bom_detail_bb->qty = $bb['qty'];
                        $akt_produksi_bom_detail_bb->keterangan = $bb['keterangan'];
                        $akt_produksi_bom_detail_bb->save();
                    };

                    return $this->redirect(['view', 'id' => $model->id_produksi_bom]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
            'data_akun' => $data_akun
        ]);
    }
    /**
     * Updates an existing AktProduksiBom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nomor = $model->no_produksi_bom;
        $model_akun = new AktAkun();
        $data_akun = ArrayHelper::map(AktAkun::find()->all(), 'id_akun', function ($model_akun) {
            return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
        });
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_produksi_bom]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'data_akun' => $data_akun
        ]);
    }

    public function actionPrint($id)
    {
        // $daftar_item = ItemPermintaanPembelian::find()->where(['id_permintaan_pembelian' => $id])->all();
        $setting = Setting::find()->one();
        $print =  $this->renderPartial('_print_view', [
            // return $this->renderPartial('request_print', [
            'model' => $this->findModel($id),
            'setting' => $setting,
        ]);
        $mPDF = new mPDF([
            'orientation' => 'L',
        ]);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }

    public function actionTutup($id)
    {
        $model = $this->findModel($id);
        $status = Yii::$app->db->createCommand("UPDATE akt_produksi_bom SET status_produksi = 2 WHERE id_produksi_bom = '$id'")->execute();
        // $id_item = Yii::$app->db->createCommand("SELECT id_item FROM akt_bom WHERE id_bom = '$model->id_bom'")->queryScalar();
        // $select = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$id_item'")->queryScalar();
        // $qty = Yii::$app->db->createCommand("SELECT qty FROM akt_produksi_bom_detail_hp WHERE id_produksi_bom = '$model->id_produksi_bom'")->queryScalar();
        // $stok = $qty + $select;
        // $hasil_produksi = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$id_item'")->execute();
        return $this->redirect(['index']);
    }

    public function actionApproved($id)
    {
        $model = $this->findModel($id);
        $query = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->asArray()->all();
        $query2 = AktProduksiBomDetailHp::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->asArray()->all();
        foreach ($query as $key => $value) {
            $cek_qty = 0;
            $cek_qty_ = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $value['id_item_stok'] . "'")->queryScalar();
            $qty = ($value['qty'] > $cek_qty_) ? 1 : 0;
            $cek_qty += $qty;
        }
        foreach ($query2 as $key => $value) {
            $cek_qty2 = 0;
            $cek_qty2_ = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $value['id_item_stok'] . "'")->queryScalar();
            $qty2 = ($value['qty'] > $cek_qty2_) ? 1 : 0;
            $cek_qty2 += $qty2;
        }
        $cek_bom_bb = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->count();
        $cek_produksi_hp = AktProduksiBomDetailHp::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->count();

        // var_dump($cek_bom_bb);
        // die;
        if ($cek_bom_bb > 0 && $cek_produksi_hp > 0) {
            if ($cek_qty == 0 && $cek_qty2 == 0) {
                foreach ($query as $key => $value) {
                    $stok = AktItemStok::find()->where(['id_item_stok' => $value['id_item_stok']])->one();

                    $stok->qty = $stok->qty - $value['qty'];
                    $stok->save(false);
                    // var_dump($stok->qty);
                }
                foreach ($query2 as $key => $value) {
                    $stok = AktItemStok::find()->where(['id_item_stok' => $value['id_item_stok']])->one();

                    $stok->qty = $stok->qty + $value['qty'];
                    // var_dump($stok->qty);
                    $stok->save(false);
                }
                // die;
                $model->status_produksi = 1;
                $model->save(false);
                Yii::$app->session->setFlash('success', [['Berhasil !', 'berhasil di approve!']]);
                return $this->redirect(['view', 'id' => $id]);
            } else {
                # code...
                Yii::$app->session->setFlash('danger', [['Gagal !', 'tidak bisa approve, karena stok di hasil produksi atau bahan baku kurang!']]);
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('danger', [['Gagal !', 'tidak bisa approve, karena bahan baku detail atau hasil produksi masih kosong!']]);
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);
        $query = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->asArray()->all();
        $query2 = AktProduksiBomDetailHp::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->asArray()->all();
        foreach ($query as $key => $value) {
            $cek_qty = 0;
            $cek_qty_ = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $value['id_item_stok'] . "'")->queryScalar();
            $qty = ($value['qty'] > $cek_qty_) ? 1 : 0;
            $cek_qty += $qty;
        }
        foreach ($query2 as $key => $value) {
            $cek_qty2 = 0;
            $cek_qty2_ = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $value['id_item_stok'] . "'")->queryScalar();
            $qty2 = ($value['qty'] > $cek_qty2_) ? 1 : 0;
            $cek_qty2 += $qty2;
        }
        $cek_bom_bb = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->count();
        $cek_produksi_hp = AktProduksiBomDetailHp::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->count();

        if ($cek_bom_bb > 0) {
            if ($cek_qty == 0 && $cek_qty2 == 0) {
                foreach ($query as $key => $value) {
                    $stok = AktItemStok::find()->where(['id_item_stok' => $value['id_item_stok']])->one();

                    $stok->qty = $stok->qty + $value['qty'];
                    $stok->save(false);
                }
                foreach ($query2 as $key => $value) {
                    $stok = AktItemStok::find()->where(['id_item_stok' => $value['id_item_stok']])->one();

                    $stok->qty = $stok->qty - $value['qty'];
                    $stok->save(false);
                }
                $model->status_produksi = 0;
                $model->save(false);
                Yii::$app->session->setFlash('success', [['Berhasil !', 'berhasil di approve!']]);
                return $this->redirect(['view', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash('danger', [['Gagal !', 'tidak bisa approve, karena stok di hasil produksi atau bahan baku kurang!']]);
                return $this->redirect(['view', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('danger', [['Gagal !', 'tidak bisa approve, karena bahan baku detail masih kosong!']]);
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status_produksi = 3;
        $model->save(false);
        Yii::$app->session->setFlash('success', [['Berhasil !', 'berhasil di reject!']]);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing AktProduksiBom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $bb = AktProduksiBomDetailBb::find()
            ->where(['id_produksi_bom' => $id])
            ->one();
        $hp = AktProduksiBomDetailHp::find()
            ->where(['id_produksi_bom' => $id])
            ->one();
        $hp->delete();
        $bb->delete();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AktProduksiBom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktProduksiBom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktProduksiBom::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
