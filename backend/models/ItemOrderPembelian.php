<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_order_pembelian".
 *
 * @property int $id_item_order_pembelian
 * @property int $id_order_pembelian
 * @property int $id_item
 * @property int $quantity
 * @property string $satuan
 * @property int $harga
 * @property int $diskon
 * @property int $qty_terkirim
 * @property int $qty_back_order
 * @property int $id_departement
 * @property int $id_proyek
 * @property string $keterangan
 * @property string $req_date
 */
class ItemOrderPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_order_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_order_pembelian'], 'required'],
            [['id_order_pembelian', 'id_item_stok', 'quantity','id_satuan', 'harga', 'diskon', 'qty_terkirim', 'qty_back_order', 'id_departement', 'id_proyek'], 'integer'],
            [['keterangan'], 'string'],
            [['req_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_order_pembelian' => 'Id Item Order Pembelian',
            'id_order_pembelian' => 'Id Order Pembelian',
            'id_item_stok' => 'Id Item',
            'quantity' => 'Quantity',
            'satuan' => 'Satuan',
            'harga' => 'Harga',
            'diskon' => 'Diskon',
            'qty_terkirim' => 'Qty Terkirim',
            'qty_back_order' => 'Qty Back Order',
            'id_departement' => 'Id Departement',
            'id_proyek' => 'Id Proyek',
            'keterangan' => 'Keterangan',
            'req_date' => 'Req Date',
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
