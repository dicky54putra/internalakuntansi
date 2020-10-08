<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembelian_detail".
 *
 * @property int $id_pembelian_detail
 * @property int $id_pembelian
 * @property int $id_item_stok
 * @property int $qty
 * @property int $harga
 * @property int $diskon
 * @property int $total
 * @property string $keterangan
 */
class AktPembelianDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian'], 'required'],
            [['id_pembelian', 'id_item_stok', 'qty', 'diskon', 'total'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_detail' => 'Id Pembelian Detail',
            'id_pembelian' => 'Id Pembelian',
            'id_item_stok' => 'Id Item Stok',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'diskon' => 'Diskon',
            'total' => 'Total',
            'keterangan' => 'Keterangan',
        ];
    }
}
