<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_item_harga_jual".
 *
 * @property int $id_item_harga_jual
 * @property int $id_item
 * @property int $id_mata_uang
 * @property int $id_level_harga
 * @property int $harga_satuan
 * @property int $diskon_satuan
 */
class AktItemHargaJual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_item_harga_jual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item', 'id_mata_uang', 'id_level_harga', 'harga_satuan'], 'required'],
            [['id_item', 'id_mata_uang', 'id_level_harga'], 'integer'],
            [['harga_satuan'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_harga_jual' => 'Id Item Harga Jual',
            'id_item' => 'Id Item',
            'id_mata_uang' => 'Id Mata Uang',
            'id_level_harga' => 'Id Level Harga',
            'harga_satuan' => 'Harga Satuan',
            'diskon_satuan' => 'Diskon Satuan',
        ];
    }
}
