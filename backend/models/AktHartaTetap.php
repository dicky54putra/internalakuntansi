<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_harta_tetap".
 *
 * @property int $id_harta_tetap
 * @property string $kode
 * @property string $nama
 * @property int $id_kelompok_harta_tetap
 * @property int $tipe
 * @property int $metode_depresiasi
 * @property int $status
 */
class AktHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'id_kelompok_harta_tetap', 'tipe', 'status'], 'required'],
            [['id_kelompok_harta_tetap', 'tipe', 'status'], 'integer'],
            [['kode', 'nama'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_harta_tetap' => 'Id Harta Tetap',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'id_kelompok_harta_tetap' => 'Id Kelompok Harta Tetap',
            'tipe' => 'Tipe',
            'status' => 'Status',
        ];
    }

    public function getkelompok_harta_tetap()
    {
        return $this->hasOne(AktKelompokHartaTetap::className(), ['id_kelompok_harta_tetap' => 'id_kelompok_harta_tetap']);
    }
}
