<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_stok_masuk_detail".
 *
 * @property int $id_stok_masuk_detail
 * @property int $id_stok_masuk
 * @property int $id_item
 * @property int $qty
 * @property int $id_gudang
 */
class AktStokMasukDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_stok_masuk_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_masuk', 'id_item_stok', 'qty'], 'required'],
            [['id_stok_masuk', 'id_item_stok', 'qty'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_masuk_detail' => 'Id Stok Masuk Detail',
            'id_stok_masuk' => 'Stok Masuk',
            'id_item_stok' => 'Barang',
            'qty' => 'Qty',
        ];
    }
}
