<?php

namespace backend\models;

use Yii;

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
            [['no_order_penjualan', 'tanggal_order_penjualan', 'id_customer', 'id_mata_uang', 'status'], 'required'],
            [['tanggal_order_penjualan', 'tanggal_penjualan', 'tanggal_faktur_penjualan', 'tanggal_tempo', 'the_approver_date', 'tanggal_estimasi'], 'safe'],
            [['id_customer', 'id_sales', 'id_mata_uang', 'pajak', 'jenis_bayar', 'jumlah_tempo', 'status', 'diskon', 'the_approver', 'id_kas_bank'], 'integer'],
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
}
