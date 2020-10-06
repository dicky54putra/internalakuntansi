<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_item_tipe".
 *
 * @property int $id_tipe_item
 * @property string $nama_tipe_item
 */
class AktItemTipe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_item_tipe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_tipe_item'], 'required'],
            [['nama_tipe_item'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipe_item' => 'Id Tipe Barang',
            'nama_tipe_item' => 'Nama Tipe Barang',
        ];
    }
}
