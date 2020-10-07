<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penawaran_penjualan".
 *
 * @property int $id_penawaran_penjualan
 * @property int $no_penawaran_penjualan
 * @property string $tanggal
 * @property int $id_customer
 * @property int $id_sales
 * @property int $id_mata_uang
 * @property int $pajak
 * @property int $id_penagih
 * @property int $id_pengirim
 * @property int $status
 */
class AktPenawaranPenjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penawaran_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_penawaran_penjualan', 'tanggal', 'id_customer', 'id_sales', 'id_mata_uang', 'id_penagih', 'id_pengirim', 'status'], 'required'],
            [['id_customer', 'id_sales', 'id_mata_uang', 'pajak', 'id_penagih', 'id_pengirim', 'status', 'the_approver'], 'integer'],
            [['tanggal', 'tanggal_approve'], 'safe'],
            // , 'diskon', 'total', 'pajak'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penawaran_penjualan' => 'Id Penawaran Penjualan',
            'no_penawaran_penjualan' => 'No Penawaran Penjualan',
            'tanggal' => 'Tanggal',
            'id_customer' => 'Customer',
            'id_sales' => 'Sales',
            'id_mata_uang' => 'Mata Uang',
            'pajak' => 'Pajak',
            'id_penagih' => 'Penagih',
            'id_pengirim' => 'Pengirim',
            'status' => 'Status',
            'tanggal_approve' => 'Tanggal Approve',
            'the_approver' => 'The Approver',
        ];
    }

    public function getcustomer()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_customer']);
    }
    public function getpenagih()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_penagih']);
    }
    public function getpengirim()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_pengirim']);
    }
    public function getsales()
    {
        return $this->hasOne(AktSales::className(), ['id_sales' => 'id_sales']);
    }
    public function getmata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }
    public function getlogin()
    {
        return $this->hasOne(Login::className(), ['id_login' => 'the_approver']);
    }
}
