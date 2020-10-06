<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_kelompok_harta_tetap".
 *
 * @property int $id_kelompok_harta_tetap
 * @property string $kode
 * @property string $nama
 * @property int $umur_ekonomis
 * @property int $metode_depresiasi
 * @property int $id_akun_harta
 * @property int $id_akun_akumulasi
 * @property int $id_akun_depresiasi
 * @property string $keterangan
 */
class AktKelompokHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_kelompok_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'umur_ekonomis', 'metode_depresiasi', 'id_akun_harta', 'id_akun_akumulasi', 'id_akun_depresiasi'], 'required'],
            [['umur_ekonomis', 'metode_depresiasi', 'id_akun_harta', 'id_akun_akumulasi', 'id_akun_depresiasi'], 'integer'],
            [['keterangan'], 'string'],
            [['kode', 'nama'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kelompok_harta_tetap' => 'Id Kelompok Harta Tetap',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'umur_ekonomis' => 'Umur Ekonomis',
            'metode_depresiasi' => 'Metode Depresiasi',
            'id_akun_harta' => 'Id Akun Harta',
            'id_akun_akumulasi' => 'Id Akun Akumulasi',
            'id_akun_depresiasi' => 'Id Akun Depresiasi',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getakun_harta()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun_harta']);
    }
    public function getakun_akumulasi()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun_akumulasi']);
    }
    public function getakun_depresiasi()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun_depresiasi']);
    }
}
