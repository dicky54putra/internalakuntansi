<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_produksi_manual_detail_hp".
 *
 * @property int $id_produksi_manual_detail_hp
 * @property int $id_produksi_manual
 * @property int $id_item_stok
 * @property int $qty
 * @property string $keterangan
 */
class AktProduksiManualDetailHp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_produksi_manual_detail_hp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_produksi_manual', 'id_item_stok', 'qty', 'keterangan'], 'required'],
            [['id_produksi_manual', 'id_item_stok', 'qty'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produksi_manual_detail_hp' => 'Id Produksi Manual Detail Hp',
            'id_produksi_manual' => 'Id Produksi Manual',
            'id_item_stok' => 'Id Item Stok',
            'qty' => 'Qty',
            'keterangan' => 'Keterangan',
        ];
    }
}
