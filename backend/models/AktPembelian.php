<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_pembelian".
 *
 * @property int $id_pembelian
 * @property string $no_order_pembelian
 * @property int $id_customer
 * @property int $id_mata_uang
 * @property string $no_pembelian
 * @property string $tanggal_pembelian
 * @property string $no_faktur_pembelian
 * @property string $tanggal_faktur_pembelian
 * @property int $ongkir
 * @property int $diskon
 * @property int $pajak
 * @property int $total
 * @property int $jenis_bayar
 * @property int $jatuh_tempo
 * @property string $tanggal_tempo
 * @property int $materai
 * @property int $id_penagih
 * @property int $status
 */
class AktPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_customer',], 'required'],
            [['id_customer', 'id_mata_uang', 'pajak', 'total', 'jenis_bayar', 'jatuh_tempo', 'id_penagih', 'status', 'id_kas_bank'], 'integer'],
            [['tanggal_pembelian', 'tanggal_faktur_pembelian', 'tanggal_tempo', 'tanggal_order_pembelian', 'tanggal_penerimaan', 'tanggal_estimasi', 'uang_muka', 'materai', 'diskon'], 'safe'],
            [['no_order_pembelian', 'no_pembelian', 'no_faktur_pembelian', 'no_penerimaan', 'pengantar', 'penerima', 'no_spb'], 'string', 'max' => 255],
            [['keterangan_penerimaan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian' => 'Id Pembelian',
            'no_order_pembelian' => 'No Order Pembelian',
            'id_customer' => 'Customer',
            'id_mata_uang' => 'Mata Uang',
            'no_pembelian' => 'No Pembelian',
            'tanggal_pembelian' => 'Tanggal Pembelian',
            'no_faktur_pembelian' => 'No Faktur Pembelian',
            'tanggal_faktur_pembelian' => 'Tanggal Faktur Pembelian',
            'ongkir' => 'Ongkir',
            'diskon' => 'Diskon',
            'pajak' => 'Pajak 10%',
            'total' => 'Total',
            'jenis_bayar' => 'Jenis Bayar',
            'jatuh_tempo' => 'Jatuh Tempo',
            'tanggal_tempo' => 'Tanggal Tempo',
            'materai' => 'Materai',
            'id_penagih' => 'Penagih',
            'status' => 'Status',
            'uang_muka' => 'Uang Muka',
            'tanggal_estimasi' => 'Tanggal Estimasi'
        ];
    }

    public function getcustomer()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_customer']);
    }

    public function getmata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getkas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }
    public function getpembayaran_biaya()
    {
        return $this->hasOne(AktPembayaranBiaya::className(), ['id_pembelian' => 'id_pembelian']);
    }
    public function getpenagih()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_penagih'])->from(["penagih" => AktMitraBisnis::tableName()]);
    }

    public function getpengirim()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_pengirim'])->from(["pengirim" => AktMitraBisnis::tableName()]);
    }

    public static function cekButtonPembelian()
    {
        $pengaturan = Pengaturan::find()->select(['status'])->where(['like', 'nama_pengaturan', 'Button Pembelian'])->one();

        return $pengaturan;
    }


    public static function dataCustomer()
    {


        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 1])
                ->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
            }
        );

        return $data_customer;
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

    public static function dataKasBank()
    {
        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'] . ' : ' . ribuan($model['saldo']);
            }
        );

        return $data_kas_bank;
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

    public static function dataItemStok($model)
    {
        $data_item_stok = ArrayHelper::map(
            AktItemStok::find()
                ->select(["akt_item_stok.id_item_stok", "akt_item.nama_item", "akt_gudang.nama_gudang", "akt_item_stok.qty", "akt_satuan.nama_satuan", "akt_item_harga_jual.harga_satuan"])
                ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
                ->leftJoin("akt_item_harga_jual", "akt_item_harga_jual.id_item = akt_item.id_item")
                ->leftJoin("akt_gudang", "akt_gudang.id_gudang = akt_item_stok.id_gudang")
                ->leftJoin("akt_satuan", "akt_satuan.id_satuan = akt_item.id_satuan")
                ->where(['id_mitra_bisnis' => $model->id_customer])
                ->orderBy("akt_item.nama_item")
                ->asArray()
                ->all(),
            'id_item_stok',
            function ($model) {
                return $model['nama_item'] . ', Satuan : ' . $model['nama_satuan'] . ', Gudang : ' . $model['nama_gudang'] . ', Stok : ' . $model['qty'];
            }
        );

        return $data_item_stok;
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

            AktPembelian::setfilterNamaAkun($akun, 'pembelian barang', $jurnal_umum_detail, $data_jurnal_umum['pembelian_barang'], $jt);
            AktPembelian::setfilterNamaAkun($akun, 'ppn masukan', $jurnal_umum_detail, $data_jurnal_umum['pajak'], $jt);
            AktPembelian::setfilterNamaAkun($akun, 'uang muka pembelian', $jurnal_umum_detail, $data_jurnal_umum['uang_muka'], $jt);
            AktPembelian::setfilterNamaAkun($akun, 'piutang pengiriman', $jurnal_umum_detail, $data_jurnal_umum['ongkir'], $jt);
            AktPembelian::setfilterNamaAkun($akun, 'biaya admin kantor', $jurnal_umum_detail, $data_jurnal_umum['materai'], $jt);


            if ($jt->id_akun == 64 && $jt->tipe == 'D') {
                $jurnal_umum_detail->debit = $data_jurnal_umum['hutang_usaha'];
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $data_jurnal_umum['hutang_usaha'];
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $data_jurnal_umum['hutang_usaha'];
                }
            } else if ($jt->id_akun == 64 && $jt->tipe == 'K') {
                $jurnal_umum_detail->kredit = $data_jurnal_umum['hutang_usaha'];
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun - $data_jurnal_umum['hutang_usaha'];
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $data_jurnal_umum['hutang_usaha'];
                }
            } else if ($model->id_kas_bank != null) {
                $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                if (strtolower($akun->nama_akun) == 'kas' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $data_jurnal_umum['uang_muka'];
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $data_jurnal_umum['uang_muka'];
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $data_jurnal_umum['uang_muka'];
                    }
                } else if (strtolower($akun->nama_akun) == 'kas' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $data_jurnal_umum['uang_muka'];
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $data_jurnal_umum['uang_muka'];
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $data_jurnal_umum['uang_muka'];
                    }
                }
                $akt_kas_bank->save(false);
            }

            $akun->save(false);
            if ($type == 'order_pembelian') {
                $jurnal_umum_detail->keterangan = 'Order Pembelian : ' .  $model->no_order_pembelian;
            } else if ($type == 'pembelian') {
                $jurnal_umum_detail->keterangan = 'Pembelian : ' .  $model->no_pembelian;
            }
            $jurnal_umum_detail->save(false);

            if (strtolower($akun->nama_akun) == 'kas') {
                $history_transaksi_kas = new AktHistoryTransaksi();
                $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                $history_transaksi_kas->save(false);
            }
        }
    }
}
