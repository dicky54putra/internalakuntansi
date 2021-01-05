<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_stok_keluar_detail".
 *
 * @property int $id_stok_keluar_detail
 * @property int $id_stok_keluar
 * @property int $id_item_stok
 * @property int $qty
 */
class AktStokKeluarDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_stok_keluar_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_keluar', 'id_item_stok', 'qty'], 'required'],
            [['id_stok_keluar', 'id_item_stok', 'qty'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_keluar_detail' => 'Id Stok Keluar Detail',
            'id_stok_keluar' => 'Id Stok Keluar',
            'id_item_stok' => 'Barang',
            'qty' => 'Qty',
        ];
    }
}
