<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_retur_penjualan_detail".
 *
 * @property int $id_retur_penjualan_detail
 * @property int $id_retur_penjualan
 * @property int $id_penjualan_pengiriman_detail
 * @property int $qty
 * @property int $retur
 */
class AktReturPenjualanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_retur_penjualan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_retur_penjualan', 'id_penjualan_pengiriman_detail', 'qty', 'retur'], 'required'],
            [['id_retur_penjualan', 'id_penjualan_pengiriman_detail', 'qty', 'retur'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_retur_penjualan_detail' => 'Id Retur Penjualan Detail',
            'id_retur_penjualan' => 'Id Retur Penjualan',
            'id_penjualan_pengiriman_detail' => 'Nama Barang',
            'qty' => 'Qty',
            'retur' => 'Retur',
            'keterangan' => 'Keterangan',
        ];
    }
}
