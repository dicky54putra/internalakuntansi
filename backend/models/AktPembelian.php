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
            [['id_customer', 'id_mata_uang', 'diskon', 'pajak', 'total', 'jenis_bayar', 'jatuh_tempo', 'id_penagih', 'status', 'id_kas_bank'], 'integer'],
            [['tanggal_pembelian', 'tanggal_faktur_pembelian', 'tanggal_tempo', 'tanggal_order_pembelian', 'tanggal_penerimaan', 'tanggal_estimasi', 'uang_muka', 'materai'], 'safe'],
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
}
