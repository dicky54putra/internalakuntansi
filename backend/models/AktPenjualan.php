<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_penjualan".
 *
 * @property int $id_penjualan
 * @property string $no_order_penjualan
 * @property string $tanggal_order_penjualan
 * @property int $id_customer
 * @property int $id_sales
 * @property int $id_mata_uang
 * @property string $no_penjualan
 * @property string $tanggal_penjualan
 * @property string $no_faktur_penjualan
 * @property string $tanggal_faktur_penjualan
 * @property string $ongkir
 * @property string $pajak
 * @property string $total
 * @property string $bayar
 * @property string $kekurangan
 * @property int $jenis_bayar
 * @property int $jumlah_tempo
 * @property string $tanggal_tempo
 * @property int $id_kas_bank
 * @property int $materai
 * @property int $id_pengirim
 * @property int $status
 */
class AktPenjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_customer', 'id_mata_uang', 'status'], 'required'],
            [['tanggal_order_penjualan', 'tanggal_penjualan', 'tanggal_faktur_penjualan', 'tanggal_tempo', 'the_approver_date', 'tanggal_estimasi', 'materai', 'ongkir', 'diskon'], 'safe'],
            [['id_customer', 'id_sales', 'id_mata_uang', 'pajak', 'jenis_bayar', 'jumlah_tempo', 'status', 'the_approver', 'id_kas_bank'], 'integer'],
            [['no_order_penjualan', 'no_penjualan', 'no_faktur_penjualan'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan' => 'Id Penjualan',
            'no_order_penjualan' => 'No. Order Penjualan',
            'tanggal_order_penjualan' => 'Tanggal Order',
            'id_customer' => 'Customer',
            'id_sales' => 'Sales',
            'id_mata_uang' => 'Mata Uang',
            'the_approver' => 'The Approver',
            'the_approver_date' => 'The Approver Date',
            'no_penjualan' => 'No Penjualan',
            'tanggal_penjualan' => 'Tanggal Penjualan',
            'no_faktur_penjualan' => 'No Faktur Pajak',
            'tanggal_faktur_penjualan' => 'Tanggal Faktur Pajak',
            'ongkir' => 'Ongkir',
            'pajak' => 'Pajak 10%',
            'uang_muka' => 'Uang Muka',
            'id_kas_bank' => 'Kas Bank',
            'total' => 'Grand Total',
            'jenis_bayar' => 'Jenis Bayar',
            'jumlah_tempo' => 'Jumlah Tempo',
            'tanggal_tempo' => 'Tanggal Tempo',
            'materai' => 'Materai',
            'status' => 'Status',
            'diskon' => 'Diskon %',
            'no_spb' => 'No. Surat Pengantar Barang',
            'tanggal_estimasi' => 'Tanggal Estimasi',
        ];
    }

    public function getcustomer()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_customer']);
    }

    public function getsales()
    {
        return $this->hasOne(AktSales::className(), ['id_sales' => 'id_sales']);
    }

    public function getmata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getapprover()
    {
        return $this->hasOne(Login::className(), ['id_login' => 'the_approver']);
    }

    public function getkas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }

    public static function cekButtonPenjualan()
    {
        $pengaturan = Pengaturan::find()->select(['status'])->where(['like', 'nama_pengaturan', 'Button Penjualan'])->one();

        return $pengaturan;
    }

    public static function dataCustomer()
    {
        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 2])
                ->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
            }
        );
        return $data_customer;
    }

    public static function dataSales()
    {
        $data_sales = ArrayHelper::map(
            AktSales::find()
                ->where(["=", 'status_aktif', 1])
                ->all(),
            'id_sales',
            function ($model) {
                return $model['kode_sales'] . ' - ' . $model['nama_sales'];
            }
        );

        return $data_sales;
    }

    public static function dataMataUang()
    {
        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
            }
        );

        return $data_mata_uang;
    }

    public static function data_item_stok($model)
    {
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty", "akt_satuan.nama_satuan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->leftJoin("akt_satuan", "akt_satuan.id_satuan = akt_item.id_satuan")
                // ->where(['id_mitra_bisnis' => $model->id_customer])
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return 'Nama Barang : ' . $model['nama_item'] . ', Satuan : ' . $model['nama_satuan'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        return $data_item_stok;
    }

    public  static function dataLevel($id)
    {
        $data_level = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_harga_jual.id_item_harga_jual", "akt_item_harga_jual.harga_satuan", "akt_level_harga.keterangan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_item_harga_jual", "akt_item_harga_jual.id_item = akt_item.id_item")
                ->leftJoin("akt_level_harga", "akt_level_harga.id_level_harga = akt_item_harga_jual.id_level_harga")
                ->where(['akt_item.id_item' => $id])
                ->asArray()
                ->all(),
            'id_item_harga_jual',
            function ($model) {
                return $model['keterangan'];
            }
        );

        return $data_level;
    }

    public static function dataKasNank()
    {
        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()
                ->where(["=", 'status_aktif', 1])
                ->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'] . ' : ' . ribuan($model['saldo']);
            }
        );

        return $data_kas_bank;
    }

    public static function getBulan()
    {
        $bulan = array(
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12
        );

        return $bulan;
    }

    public static function getPenjualanTahun($year, $type)
    {
        if ($type == 'sum') {
            $query = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_penjualan WHERE YEAR(tanggal_penjualan) = '$year' AND status >= 3")->queryScalar();
        } else if ($type = 'count') {
            $query = Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_penjualan WHERE YEAR(tanggal_penjualan) = '$year' AND status >= 3")->queryScalar();
        }

        return $query;
    }

    public static function setfilterNamaAkun($model_akun, $nama_akun,  $model_jurnal_umum_detail, $nominal, $jt)
    {

        if (strtolower($model_akun->nama_akun) == strtolower($nama_akun) && $jt->tipe == 'D') {
            $model_jurnal_umum_detail->debit = $nominal;
            if ($model_akun->saldo_normal == 1) {
                $model_akun->saldo_akun = $model_akun->saldo_akun + $nominal;
            } else {
                $model_akun->saldo_akun = $model_akun->saldo_akun - $nominal;
            }
        } else if (strtolower($model_akun->nama_akun) == strtolower($nama_akun) && $jt->tipe == 'K') {
            $model_jurnal_umum_detail->kredit = $nominal;
            if ($model_akun->saldo_normal == 1) {
                $model_akun->saldo_akun = $model_akun->saldo_akun - $nominal;
            } else {
                $model_akun->saldo_akun = $model_akun->saldo_akun + $nominal;
            }
        }
    }

    public static function setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum, $type)
    {


        foreach ($jurnal_transaksi_detail as $jt) {
            $jurnal_umum_detail = new AktJurnalUmumDetail();
            $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail->id_akun = $jt->id_akun;
            $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

            AktPenjualan::setfilterNamaAkun($akun, 'penjualan barang', $jurnal_umum_detail, $data_jurnal_umum['total_penjualan'], $jt);
            AktPenjualan::setfilterNamaAkun($akun, 'piutang usaha', $jurnal_umum_detail, $data_jurnal_umum['piutang_usaha'], $jt);
            AktPenjualan::setfilterNamaAkun($akun, 'ppn keluaran', $jurnal_umum_detail, $data_jurnal_umum['pajak'], $jt);
            AktPenjualan::setfilterNamaAkun($akun, 'hutang pengiriman', $jurnal_umum_detail, $data_jurnal_umum['ongkir'], $jt);
            AktPenjualan::setfilterNamaAkun($akun, 'biaya admin kantor', $jurnal_umum_detail, $data_jurnal_umum['materai'], $jt);
            AktPenjualan::setfilterNamaAkun($akun, 'uang muka penjualan', $jurnal_umum_detail, $data_jurnal_umum['uang_muka'], $jt);

            if ($model->id_kas_bank != null) {
                $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                if ($akun->nama_akun == 'kas' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                    }
                    $akt_kas_bank->save(false);
                } else if ($akun->nama_akun == 'kas' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                    }
                    $akt_kas_bank->save(false);
                }
            }
            $akun->save(false);
            if($type == 'order_penjualan') {
                $jurnal_umum_detail->keterangan = 'Order Penjualan : ' .  $model->no_order_penjualan;
            } else if ($type == 'penjualan') {
                $jurnal_umum_detail->keterangan = 'Penjualan : ' .  $model->no_penjualan;

            }
            $jurnal_umum_detail->save(false);

            if ($akun->nama_akun == 'kas') {
                $history_transaksi_kas = new AktHistoryTransaksi();
                $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                $history_transaksi_kas->save(false);
            }
        }
    }
}
