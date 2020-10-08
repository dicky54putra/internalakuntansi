<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_kota".
 *
 * @property int $id_kota
 * @property string $kode_kota
 * @property string $nama_kota
 */
class AktKota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_kota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_kota', 'nama_kota'], 'required'],
            [['kode_kota', 'nama_kota'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kota' => 'Id Kota',
            'kode_kota' => 'Kode Kota',
            'nama_kota' => 'Nama Kota',
        ];
    }
}
