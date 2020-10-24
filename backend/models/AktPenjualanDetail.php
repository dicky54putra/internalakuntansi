<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penjualan_detail".
 *
 * @property int $id_penjualan_detail
 * @property int $id_penjualan
 * @property int $id_item_stok
 * @property int $qty
 * @property string $harga
 * @property double $diskon
 * @property string $total
 * @property string $keterangan
 */
class AktPenjualanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penjualan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan', 'id_item_stok', 'qty', 'harga', 'total'], 'required'],
            [['id_penjualan', 'id_item_stok', 'total'], 'integer'],
            [['diskon'], 'safe'],
            [['keterangan'], 'string'],
            [['qty'], 'integer', 'min' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_detail' => 'Id Penjualan Detail',
            'id_penjualan' => 'Id Penjualan',
            'id_item_stok' => 'Barang',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'diskon' => 'Diskon %',
            'total' => 'Total',
            'keterangan' => 'Keterangan',
        ];
    }
}
