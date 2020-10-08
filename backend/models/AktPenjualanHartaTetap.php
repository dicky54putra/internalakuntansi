<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penjualan_harta_tetap".
 *
 * @property int $id_penjualan_harta_tetap
 * @property string $no_penjualan_harta_tetap
 * @property string $tanggal_penjualan_harta_tetap
 * @property int $id_customer
 * @property int $id_sales
 * @property int $id_mata_uang
 * @property int $the_approver
 * @property string $the_approver_date
 * @property string $no_faktur_penjualan_harta_tetap
 * @property string $tanggal_faktur_penjualan_harta_tetap
 * @property int $ongkir
 * @property int $pajak
 * @property int $uang_muka
 * @property int $id_kas_bank
 * @property int $total
 * @property int $diskon
 * @property int $jenis_bayar
 * @property int $jumlah_tempo
 * @property string $tanggal_tempo
 * @property int $materai
 * @property int $status
 */
class AktPenjualanHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penjualan_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_penjualan_harta_tetap', 'tanggal_penjualan_harta_tetap', 'id_customer', 'id_mata_uang', 'status'], 'required'],
            [['tanggal_penjualan_harta_tetap', 'the_approver_date', 'tanggal_faktur_penjualan_harta_tetap', 'tanggal_tempo'], 'safe'],
            [['id_customer', 'id_sales', 'id_mata_uang', 'the_approver', 'pajak', 'id_kas_bank', 'total', 'diskon', 'jenis_bayar', 'jumlah_tempo', 'status'], 'integer'],
            [['no_penjualan_harta_tetap', 'no_faktur_penjualan_harta_tetap'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_harta_tetap' => 'Id Penjualan Harta Tetap',
            'no_penjualan_harta_tetap' => 'No Penjualan Harta Tetap',
            'tanggal_penjualan_harta_tetap' => 'Tanggal Penjualan Harta Tetap',
            'id_customer' => 'Customer',
            'id_sales' => 'Sales',
            'id_mata_uang' => 'Mata Uang',
            'the_approver' => 'The Approver',
            'the_approver_date' => 'The Approver Date',
            'no_faktur_penjualan_harta_tetap' => 'No Faktur Penjualan Harta Tetap',
            'tanggal_faktur_penjualan_harta_tetap' => 'Tanggal Faktur Penjualan Harta Tetap',
            'ongkir' => 'Ongkir',
            'pajak' => 'Pajak',
            'uang_muka' => 'Uang Muka',
            'id_kas_bank' => 'Kas Bank',
            'total' => 'Total',
            'diskon' => 'Diskon %',
            'jenis_bayar' => 'Jenis Bayar',
            'jumlah_tempo' => 'Jumlah Tempo',
            'tanggal_tempo' => 'Tanggal Tempo',
            'materai' => 'Materai',
            'status' => 'Status',
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
