<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_mitra_bisnis_kontak".
 *
 * @property int $id_mitra_bisnis_kontak
 * @property int $id_mitra_bisnis
 * @property string $nama_kontak
 * @property string $jabatan
 * @property string $handphone
 * @property string $email
 */
class AktMitraBisnisKontak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_mitra_bisnis_kontak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis', 'nama_kontak'], 'required'],
            [['id_mitra_bisnis'], 'integer'],
            [['nama_kontak', 'jabatan', 'handphone', 'email'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mitra_bisnis_kontak' => 'Id Mitra Bisnis Kontak',
            'id_mitra_bisnis' => 'Id Mitra Bisnis',
            'nama_kontak' => 'Nama Kontak',
            'jabatan' => 'Jabatan',
            'handphone' => 'Handphone',
            'email' => 'Email',
        ];
    }
}
