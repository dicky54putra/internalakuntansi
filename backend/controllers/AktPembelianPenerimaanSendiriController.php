<?php

namespace backend\controllers;

use Yii;
use backend\models\AktPembelian;
use backend\models\AktPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use backend\models\AktItemStok;
use backend\models\AktMitraBisnisAlamat;
use yii\helpers\ArrayHelper;
use backend\models\Foto;
use backend\models\AktPembelianDetail;
use backend\models\Setting;
use backend\models\AktJurnalUmum;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktAkun;
// use backend\models\AktPembelianDetail;
use backend\models\AktPembelianPenerimaan;
use backend\models\AktPembelianPenerimaanDetail;
use yii\web\UploadedFile;
use yii\db\Query;

/**
 * AktpembelianController implements the CRUD actions for Aktpembelian model.
 */
class AktPembelianPenerimaanSendiriController extends Controller
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
        $dataProvider = $searchModel->searchPenerimaan(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Aktpembelian model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model2 = new AktPembelianPenerimaan();
        $model3 = new AktPembelianPenerimaanDetail();
        $model_pembelian_detail = new AktPembelianDetail();

        $model_pembelian  = AktPembelian::findOne($model->id_pembelian);

        // echo $model->id_pembelian; die;

        $detail = Yii::$app->db->createCommand("SELECT SUM(qty_diterima) as qty_diterima FROM akt_pembelian_penerimaan_detail LEFT JOIN akt_pembelian_detail ON akt_pembelian_detail.id_pembelian_detail = akt_pembelian_penerimaan_detail.id_pembelian_detail WHERE akt_pembelian_detail.id_pembelian = $model->id_pembelian")->query();

        $a = array();
        foreach ($detail as $d) {
            $a[] = $d['qty_diterima'];
        }
        $b = implode(', ', $a);
        $query_for_pembelian_detail = ArrayHelper::map(
            AktPembelianDetail::find()
                ->select(["akt_item.nama_item", "akt_pembelian_detail.qty", "akt_pembelian_detail.id_pembelian_detail"])
                ->leftJoin("akt_item_stok", "akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok")
                ->leftJoin("akt_item", "akt_item.id_item= akt_item_stok.id_item")
                ->where(['akt_pembelian_detail.id_pembelian' => $model->id_pembelian])
                // ->andWhere(['!=', 'akt_pembelian_detail.qty', $b])
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_pembelian_detail',
            function ($model_pembelian_detail) {
                $sum_detail = Yii::$app->db->createCommand("SELECT SUM(qty_diterima) FROM akt_pembelian_penerimaan_detail WHERE id_pembelian_detail = '$model_pembelian_detail[id_pembelian_detail]'")->queryScalar();
                $qty_last = $model_pembelian_detail['qty'] - $sum_detail;
                return $model_pembelian_detail['nama_item'] . ' : ' . $qty_last;
            }
        );

        if (!empty(Yii::$app->request->get('id_hapus'))) {
            Foto::deleteAll(["id_foto" => Yii::$app->request->get('id_hapus')]);
            return $this->redirect(['view', 'id' => Yii::$app->request->get('id')]);
        };


        $sum_pembelian_detail = Yii::$app->db->createCommand("SELECT SUM(akt_pembelian_detail.qty) FROM akt_pembelian_detail WHERE id_pembelian = $model->id_pembelian")->queryScalar();

        $sum_penerimaan_detail = Yii::$app->db->createCommand("SELECT SUM(qty_diterima) as qty_diterima FROM akt_pembelian_penerimaan_detail LEFT JOIN akt_pembelian_detail ON akt_pembelian_detail.id_pembelian_detail = akt_pembelian_penerimaan_detail.id_pembelian_detail WHERE akt_pembelian_detail.id_pembelian = $model->id_pembelian")->queryScalar();

        if ($sum_pembelian_detail == $sum_penerimaan_detail) {
            $model_pembelian->status = 4;
        } else {
            $model_pembelian->status = 5;
        }
        $model_pembelian->save();

        $nomor_sebelumnya = Yii::$app->db->createCommand("SELECT no_penerimaan FROM `akt_pembelian_penerimaan` ORDER by no_penerimaan DESC LIMIT 1")->queryScalar();
        // echo $nomor_sebelumnya; die;
        if (!empty($nomor_sebelumnya)) {
            $noUrut = (int) substr($nomor_sebelumnya, 6);
            $bulanNoUrut = substr($nomor_sebelumnya, -7, 4);
            // echo $noUrut; die;
            if ($bulanNoUrut !== date('ym')) {
                $kode = 'PQ' . date('ym') . '001';
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

                $no_penerimaan = "PQ" . date('ym') . $noUrut_2;
                $kode = $no_penerimaan;
            }
        } else {
            # code...
            $kode = 'PQ' . date('ym') . '001';
        }

        $model2->no_penerimaan = $kode;

        if (Yii::$app->request->get('aksi') == "terima_barang_detail") {
            if ($model3->load(Yii::$app->request->post())) {
                echo $model3->keterangan;
                // $post_qty = Yii::$app->request->post('AktPembelianPenerimaanDetail')['qty_diterima'];
                $jumlah_beli = AktPembelianDetail::find()->where(['id_pembelian_detail' => $model3->id_pembelian_detail])->one();
                $sum_detail = Yii::$app->db->createCommand("SELECT SUM(qty_diterima) FROM akt_pembelian_penerimaan_detail WHERE id_pembelian_detail = '$model3->id_pembelian_detail'")->queryScalar();
                $qty_last = $jumlah_beli->qty - $sum_detail;
                // var_dump($model3->qty_diterima);
                // var_dump($qty_last);
                // die;
                if ($model3->qty_diterima <= $qty_last) {
                    $cek_stok =  Yii::$app->db->createCommand("SELECT akt_pembelian_detail.id_item_stok FROM `akt_pembelian_detail` INNER JOIN `akt_item_stok` ON akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok INNER JOIN `akt_item` ON akt_item.id_item = akt_item_stok.id_item WHERE akt_pembelian_detail.id_pembelian_detail =$model3->id_pembelian_detail")->queryScalar();
                    $stok = AktItemStok::find()->where(['id_item_stok' => $cek_stok])->one();
                    $stok->qty = $stok->qty + $model3->qty_diterima;
                    // $model3->qty_diterima = $model3->qty_diterima + $post_qty;
                    $model3->save(FALSE);
                    $stok->save(FALSE);

                    Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Pembelian Berhasil Disimpan.']]);
                } else {
                    Yii::$app->session->setFlash('danger', [['Perhatian !', 'Qty yang diterima melebihi qty yang dibeli.']]);
                }
                // die;

                return $this->redirect(['view', 'id' => $model->id_pembelian, '#' => 'data-penerimaan']);
            }
            // echo  $model2->penerima . '-' . $model2->no_penerimaan;
            // die;
        }
        // elseif (Yii::$app->request->get('aksi') == "terima_barang") {
        //     if ($model2->load(Yii::$app->request->post())) {
        //         $model2->foto_resi = UploadedFile::getInstance($model2, 'foto_resi');
        //         $model2->save(false);
        //         Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Pembelian Berhasil Di Simpan.']]);
        //     }
        //     return $this->redirect(['view', 'id' => $model->id_pembelian]);
        // } elseif (Yii::$app->request->get('aksi') == "edit_terima_barang") {
        //     $id_penerimaan = Yii::$app->request->post('AktPembelianPenerimaan')['id_pembelian_penerimaan'];
        //     $tanggal_penerimaan = Yii::$app->request->post('AktPembelianPenerimaan')['tanggal_penerimaan'];
        //     $penerima = Yii::$app->request->post('AktPembelianPenerimaan')['penerima'];
        //     $pengantar = Yii::$app->request->post('AktPembelianPenerimaan')['pengantar'];
        //     $keterangan_pengantar = Yii::$app->request->post('AktPembelianPenerimaan')['keterangan_pengantar'];

        //     Yii::$app->db->createCommand("UPDATE `akt_pembelian_penerimaan` SET `penerima` = '$penerima', `tanggal_penerimaan` = '$tanggal_penerimaan', `pengantar` =' $pengantar', `keterangan_pengantar` = '$keterangan_pengantar' WHERE `akt_pembelian_penerimaan`.`id_pembelian_penerimaan` = " . $id_penerimaan . "")->execute();
        //     Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data Pembelian Penerimaan Berhasil Di Simpan.']]);
        //     return $this->redirect(['view', 'id' => $model->id_pembelian]);
        // }

        $foto = Foto::find()->where(["id_tabel" => $model->id_pembelian, "nama_tabel" => "pembelian"])->all();

        $count_no_penerimaan = ($model->no_penerimaan == NULL) ? 1 : 0;
        $count_tanggal_penerimaan = ($model->tanggal_penerimaan == NULL) ? 1 : 0;
        $count_pengantar = ($model->pengantar == NULL) ? 1 : 0;
        $count_no_spb = ($model->no_spb == NULL) ? 1 : 0;
        $count_data_penerimaan_count = $count_no_penerimaan + $count_tanggal_penerimaan + $count_pengantar + $count_no_spb;

        $count_tanggal_penerimaan = ($model->tanggal_penerimaan == NULL) ? 1 : 0;
        $count_penerima = ($model->penerima == NULL) ? 1 : 0;
        $count_data_penerimaan_count2 = $count_tanggal_penerimaan + $count_penerima;

        return $this->render('view', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'foto' => $foto,
            'count_data_penerimaan_count' => $count_data_penerimaan_count,
            'count_data_penerimaan_count2' => $count_data_penerimaan_count2,
            'model_pembelian' => $model_pembelian,
            'query_for_pembelian_detail' => $query_for_pembelian_detail,
            'sum_pembelian_detail' =>  $sum_pembelian_detail,
            'sum_penerimaan_detail' => $sum_penerimaan_detail,
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

    public function actionUpdateDataPembelianPenerimaan($id)
    {
        $model = $this->findModel($id);
        $model->status = 4;
        $model->tanggal_penerimaan = date('Y-m-d H:i:s');

        // $data_mitra_bisnis_alamat = ArrayHelper::map(
        //     AktMitraBisnisAlamat::find()
        //         ->where(['id_mitra_bisnis' => $model->id_customer])
        //         ->andWhere(['!=', 'alamat_penerimaan_penagihan', 2])
        //         ->orderBy("akt_mitra_bisnis_alamat.keterangan_alamat")
        //         ->asArray()
        //         ->all(),
        //     'id_mitra_bisnis_alamat',
        //     'keterangan_alamat'
        // );

        # kode u/ no_penerimaan
        $id_pembelian_max = Aktpembelian::find()->select(['max(id_pembelian) as id_pembelian'])->where(['IS NOT', 'no_spb', NULL])->one();
        $nomor_sebelumnya = Aktpembelian::find()->select(['no_spb'])->where(['id_pembelian' => $id_pembelian_max])->one();
        if (!empty($nomor_sebelumnya->no_spb)) {
            # code...
            $noUrut = (int) substr($nomor_sebelumnya->no_spb, 0, 3);
            if ($noUrut <= 999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
            } elseif ($noUrut <= 9999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%04s", $noUrut);
            } elseif ($noUrut <= 99999) {
                # code...
                $noUrut++;
                $noUrut_2 = sprintf("%05s", $noUrut);
            }
            $no_spb = $noUrut_2 . '/SPB/' . date('m/Y');
            $kode = $no_spb;
        } else {
            # code...
            $kode = '001/SPB/' . date('m/Y');
        }

        $model->no_spb = ($model->no_spb == NULL) ? $kode : $model->no_spb;

        if ($model->load(Yii::$app->request->post())) {

            $totalan_total = 0;
            $query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
            foreach ($query_detail as $key => $data) {
                # code...
                $item_stok = AktItemStok::findOne($data['id_item_stok']);
                $query_detail_ = AktPembelianDetail::find()->where(['id_item_stok' => $data['id_item_stok']])->one();
                $item_stok->qty = $item_stok->qty + $query_detail_->qty;
                // var_dump($item_stok->qty);
                // die;
                $item_stok->save(false);
            }

            if ($model->jenis_bayar == 2) {
                // create jurnal umum
                $jurnal_umum = new AktJurnalUmum();
                $akt_jurnal_umum = AktJurnalUmum::find()->select(["no_jurnal_umum"])->orderBy("id_jurnal_umum DESC")->limit(1)->one();
                if (!empty($akt_jurnal_umum->no_jurnal_umum)) {
                    # code...
                    $no_bulan = substr($akt_jurnal_umum->no_jurnal_umum, 2, 4);
                    if ($no_bulan == date('ym')) {
                        # code...
                        $noUrut = substr($akt_jurnal_umum->no_jurnal_umum, -3);
                        $noUrut++;
                        $noUrut_2 = sprintf("%03s", $noUrut);
                        $no_jurnal_umum = 'JU' . date('ym') . $noUrut_2;
                    } else {
                        # code...
                        $no_jurnal_umum = 'JU' . date('ym') . '001';
                    }
                } else {
                    # code...
                    $no_jurnal_umum = 'JU' . date('ym') . '001';
                }

                $jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
                $jurnal_umum->tanggal = date('Y-m-d');
                $jurnal_umum->tipe = 1;

                $jurnal_umum->save(false);

                // create jurnal umum

                // Create Jurnal Umum detail
                $jurnal_transaksi = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => 2])->all();

                foreach ($jurnal_transaksi as $jurnal) {
                    $jurnal_umum_detail = new AktJurnalUmumDetail();
                    $akun = AktAkun::findOne($jurnal->id_akun);
                    $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
                    $jurnal_umum_detail->id_akun = $jurnal->id_akun;
                    if ($jurnal->tipe == 'K') {
                        if ($akun->saldo_normal == 1) {
                            if ($akun->saldo_akun < $model->total) {
                                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak bisa menambah jurnal umum, karena saldo tidak mencukupi.']]);
                            } else {
                                $akun->saldo_akun = $akun->saldo_akun - $model->total;
                                $jurnal_umum_detail->kredit =  $model->total;
                                $jurnal_umum_detail->debit =  0;
                            }
                        } else if ($akun->saldo_normal == 2) {
                            $akun->saldo_akun = $akun->saldo_akun + $model->total;
                            $jurnal_umum_detail->kredit =  $model->total;
                            $jurnal_umum_detail->debit =  0;
                        }
                    } else if ($jurnal->tipe == 'D') {
                        if ($akun->saldo_normal == 1) {
                            $akun->saldo_akun = $akun->saldo_akun + $model->total;
                            $jurnal_umum_detail->debit =  $model->total;
                            $jurnal_umum_detail->kredit =  0;
                        } else if ($akun->saldo_normal == 2) {
                            if ($akun->saldo_akun < $model->total) {
                                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Tidak bisa menambah jurnal umum, karena saldo tidak mencukupi.']]);
                            } else {
                                $akun->saldo_akun = $akun->saldo_akun - $model->total;
                                $jurnal_umum_detail->debit =  $model->total;
                                $jurnal_umum_detail->kredit =  0;
                            }
                        }
                    }
                    $akun->save(false);
                    $jurnal_umum_detail->save(false);
                }

                // End Create Jurnal Umum Detail
            }


            $model->save(FALSE);

            Yii::$app->session->setFlash('success', [['Perhatian !', 'Perubahan Data penerimaan pembelian : ' . $model->no_penerimaan . ' Berhasil Di Simpan']]);
            return $this->redirect(['view', 'id' => $model->id_pembelian]);
        }

        return $this->render('update_data_pembelian_penerimaan', [
            'model' => $model,
            // 'data_mitra_bisnis_alamat' => $data_mitra_bisnis_alamat,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Aktpembelian::findOne($id)) !== null) {
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

    public function actionTerima($id)
    {
        $model = $this->findModel($id);
        $model->status = 4;
        $model->save(FALSE);

        Yii::$app->session->setFlash('success', [['Perhatian !', '' . $model->no_penerimaan . ' Berhasil Di Terima ']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian]);
    }

    public function actionDeletePembelianPenerimaan($id)
    {
        $model = AktPembelianPenerimaan::find()->where(['id_pembelian_penerimaan' => $id])->one();
        $model2 = AktPembelianPenerimaanDetail::find()->where(['id_pembelian_penerimaan' => $id])->all();

        // var_dump($model2fordelete);
        // die;
        foreach ($model2 as $k) {
            $cek_stok =  Yii::$app->db->createCommand("SELECT akt_pembelian_detail.id_item_stok FROM `akt_pembelian_detail` INNER JOIN `akt_item_stok` ON akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok INNER JOIN `akt_item` ON akt_item.id_item = akt_item_stok.id_item WHERE akt_pembelian_detail.id_pembelian_detail =$k->id_pembelian_detail")->queryScalar();
            $stok = AktItemStok::find()->where(['id_item_stok' => $cek_stok])->one();

            $stok->qty = $stok->qty - $k->qty_diterima;
            $stok->save(false);
        }
        Yii::$app->db->createCommand("DELETE FROM `akt_pembelian_penerimaan_detail` WHERE `akt_pembelian_penerimaan_detail`.`id_pembelian_penerimaan` = " . $id . "")->execute();
        // var_dump($model->id_pembelian_penerimaan);
        // die;
        $model->delete();
        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Pembelian Penerimaan Berhasil Dihapus']]);
        return $this->redirect(['view', 'id' => $model->id_pembelian]);
    }

    public function actionDeletePembelianPenerimaanDetail($id)
    {
        $model = AktPembelianPenerimaanDetail::find()->where(['id_pembelian_penerimaan_detail' => $id])->leftJoin('akt_pembelian_penerimaan', 'akt_pembelian_penerimaan.id_pembelian_penerimaan = akt_pembelian_penerimaan_detail.id_pembelian_penerimaan')->one();
        $id_pembelian = Yii::$app->db->createCommand("SELECT akt_pembelian_penerimaan.id_pembelian FROM `akt_pembelian_penerimaan_detail` INNER JOIN `akt_pembelian_penerimaan` ON akt_pembelian_penerimaan.id_pembelian_penerimaan = akt_pembelian_penerimaan_detail.id_pembelian_penerimaan WHERE akt_pembelian_penerimaan_detail.id_pembelian_penerimaan_detail =$id")->queryScalar();

        $cek_stok =  Yii::$app->db->createCommand("SELECT akt_pembelian_detail.id_item_stok FROM `akt_pembelian_detail` INNER JOIN `akt_item_stok` ON akt_item_stok.id_item_stok = akt_pembelian_detail.id_item_stok INNER JOIN `akt_item` ON akt_item.id_item = akt_item_stok.id_item WHERE akt_pembelian_detail.id_pembelian_detail =$model->id_pembelian_detail")->queryScalar();
        $stok = AktItemStok::find()->where(['id_item_stok' => $cek_stok])->one();

        $stok->qty = $stok->qty - $model->qty_diterima;
        $stok->save(false);
        $model->delete();
        Yii::$app->session->setFlash('success', [['Perhatian!', 'Data Pembelian Penerimaan Detail Berhasil Dihapus']]);
        return $this->redirect(['view', 'id' => $id_pembelian, '#' => 'data-penerimaan']);
    }

    public function actionGetPenerimaan($id)
    {
        $h = AktPembelianPenerimaan::find()->where(['id_pembelian_penerimaan' => $id])->asArray()->one();
        return json_encode($h);
    }
}
