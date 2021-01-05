<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_permintaan_pembelian".
 *
 * @property int $id_item_permintaan_pembelian
 * @property int $id_item
 * @property int $quantity
 * @property string $satuan
 * @property int $id_departement
 * @property int $id_proyek
 * @property string $keterangan
 * @property string $req_date
 */
class ItemPermintaanPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_permintaan_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item_stok'], 'required'],
            [['id_item_stok', 'quantity', 'id_departement', 'id_proyek', 'id_satuan'], 'integer'],
            [['req_date'], 'safe'],
            [['keterangan'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_permintaan_pembelian' => 'Id Item Permintaan Pembelian',
            'id_item_stok' => 'Id Item',
            'quantity' => 'Quantity',
            // 'satuan' => 'Satuan',
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
