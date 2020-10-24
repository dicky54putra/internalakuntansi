<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_level_harga".
 *
 * @property int $id_level_harga
 * @property string $kode_level_harga
 * @property string $keterangan
 */
class AktLevelHarga extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_level_harga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_level_harga', 'keterangan'], 'required'],
            [['keterangan'], 'string'],
            [['kode_level_harga'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_level_harga' => 'Id Level Harga',
            'kode_level_harga' => 'Kode',
            'keterangan' => 'Keterangan',
        ];
    }
}
