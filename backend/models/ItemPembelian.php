<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_pembelian".
 *
 * @property int $id_item_pembelian
 * @property int $id_pembelian
 * @property int $id_item
 * @property int $quantity
 * @property string $satuan
 * @property int $harga
 * @property int $diskon
 * @property int $id_departement
 * @property int $id_gudang
 * @property int $id_proyek
 * @property string $keterangan
 * @property string $no_order_pembelian
 * @property string $no_penerimaan_pembelian
 */
class ItemPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian', 'id_satuan', 'id_item_stok', 'quantity', 'diskon', 'id_departement', 'id_gudang', 'id_proyek'], 'integer'],
            [['quantity', 'id_satuan', 'harga', 'diskon', 'keterangan'], 'required'],
            [['keterangan'], 'string'],
            [['no_order_pembelian', 'no_penerimaan_pembelian'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_pembelian' => 'Id Item Pembelian',
            'id_pembelian' => 'Id Pembelian',
            'id_item' => 'Id Item',
            'quantity' => 'Quantity',
            'satuan' => 'Satuan',
            'harga' => 'Harga',
            'diskon' => 'Diskon',
            'id_departement' => 'Id Departement',
            'id_gudang' => 'Id Gudang',
            'id_proyek' => 'Id Proyek',
            'keterangan' => 'Keterangan',
            'no_order_pembelian' => 'No Order Pembelian',
            'no_penerimaan_pembelian' => 'No Penerimaan Pembelian',
        ];
    }
    public function getItem_stok()
    {
        return $this->hasOne(AktItemStok::className(), ['id_item_stok' => 'id_item_stok']);
    }

    public function getSatuan()
    {
        return $this->hasOne(AktSatuan::className(), ['id_satuan' => 'id_satuan']);
    }

    public function getProyek()
    {
        return $this->hasOne(AktProyek::className(), ['id_proyek' => 'id_proyek']);
    }

    public function getDepartement()
    {
        return $this->hasOne(AktDepartement::className(), ['id_departement' => 'id_departement']);
    }
}
