<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penjualan_pengiriman_detail".
 *
 * @property int $id_penjualan_pengiriman_detail
 * @property int $id_penjualan_pengiriman
 * @property int $id_penjualan_detail
 * @property int $qty_dikirim
 * @property string $keterangan
 */
class AktPenjualanPengirimanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penjualan_pengiriman_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan_pengiriman', 'id_penjualan_detail', 'qty_dikirim'], 'required'],
            [['id_penjualan_pengiriman', 'id_penjualan_detail'], 'integer'],
            [['keterangan'], 'string'],
            [['qty_dikirim'], 'integer', 'min' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_pengiriman_detail' => 'Id Penjualan Pengiriman Detail',
            'id_penjualan_pengiriman' => 'Id Penjualan Pengiriman',
            'id_penjualan_detail' => 'Barang Penjualan',
            'qty_dikirim' => 'Qty Dikirim',
            'keterangan' => 'Keterangan',
        ];
    }
}
