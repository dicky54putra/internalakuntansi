<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_merk".
 *
 * @property int $id_merk
 * @property string $kode_merk
 * @property string $nama_merk
 */
class AktMerk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_merk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_merk', 'nama_merk'], 'required'],
            [['kode_merk', 'nama_merk'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_merk' => 'Id Merk',
            'kode_merk' => 'Kode Merk',
            'nama_merk' => 'Nama Merk',
        ];
    }
}
