<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_mitra_bisnis_alamat".
 *
 * @property int $id_mitra_bisnis_alamat
 * @property int $id_mitra_bisnis
 * @property string $keterangan_alamat
 * @property string $alamat_lengkap
 * @property int $id_kota
 * @property string $telephone
 * @property string $fax
 * @property string $kode_pos
 * @property int $alamat_pengiriman_penagihan
 */
class AktMitraBisnisAlamat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_mitra_bisnis_alamat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis', 'keterangan_alamat', 'alamat_lengkap', 'id_kota', 'alamat_pengiriman_penagihan'], 'required'],
            [['id_mitra_bisnis', 'id_kota', 'alamat_pengiriman_penagihan', 'telephone', 'kode_pos'], 'integer'],
            [['keterangan_alamat', 'alamat_lengkap'], 'string'],
            [['fax'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mitra_bisnis_alamat' => 'Id Mitra Bisnis Alamat',
            'id_mitra_bisnis' => 'Id Mitra Bisnis',
            'keterangan_alamat' => 'Keterangan Alamat',
            'alamat_lengkap' => 'Alamat Lengkap',
            'id_kota' => 'Id Kota',
            'telephone' => 'Telephone',
            'fax' => 'Fax',
            'kode_pos' => 'Kode Pos',
            'alamat_pengiriman_penagihan' => 'Alamat Pengiriman Penagihan',
        ];
    }

    public function getkota()
    {
        return $this->hasOne(AktKota::className(), ['id_kota' => 'id_kota']);
    }
}
