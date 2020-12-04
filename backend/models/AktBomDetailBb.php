<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_bom_detail_bb".
 *
 * @property int $id_bom_detail_bb
 * @property int $id_bom
 * @property int $id_item_stok
 * @property int $qty
 * @property double $harga
 * @property string $keterangan
 */
class AktBomDetailBb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_bom_detail_bb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_bom', 'id_item_stok', 'qty', 'harga'], 'required'],
            [['id_bom', 'id_item_stok', 'qty'], 'integer'],
            [['harga'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_bom_detail_bb' => 'Id Bom Detail Bb',
            'id_bom' => 'Id Bom',
            'id_item_stok' => 'Id Item',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'keterangan' => 'Keterangan',
        ];
    }
}
