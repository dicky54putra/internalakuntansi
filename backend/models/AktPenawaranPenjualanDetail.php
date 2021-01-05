<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penawaran_penjualan_detail".
 *
 * @property int $id_penawaran_penjualan_detail
 * @property int $id_penawaran_penjualan
 * @property int $id_item_stok
 * @property int $qty
 * @property int $harga
 * @property int $diskon
 * @property int $total
 * @property string $keterangan
 */
class AktPenawaranPenjualanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penawaran_penjualan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penawaran_penjualan', 'id_item_stok', 'qty', 'harga', 'diskon', 'sub_total'], 'required'],
            [['id_penawaran_penjualan', 'id_item_stok', 'qty', 'diskon', 'sub_total','id_item_harga_jual'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penawaran_penjualan_detail' => 'Id Penawaran Penjualan Detail',
            'id_penawaran_penjualan' => 'Id Penawaran Penjualan',
            'id_item_stok' => 'Barang',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'diskon' => 'Diskon %',
            'keterangan' => 'Keterangan',
            'sub_total' => 'Sub Total',
        ];
    }
    public function getItem_stok()
    {
        return $this->hasOne(AktItemStok::className(), ['id_item_stok' => 'id_item_stok']);
    }
}
