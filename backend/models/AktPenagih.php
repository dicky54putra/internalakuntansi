<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penagih".
 *
 * @property int $id_penagih
 * @property string $kode_penagih
 * @property string $nama_penagih
 * @property string $alamat
 * @property int $id_kota
 * @property int $kode_pos
 * @property int $telepon
 * @property int $handphone
 * @property string $email
 * @property int $status_aktif
 */
class AktPenagih extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penagih';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_penagih', 'nama_penagih', 'alamat', 'id_kota', 'kode_pos', 'telepon', 'handphone', 'email', 'status_aktif'], 'required'],
            [['alamat'], 'string'],
            [['id_kota', 'status_aktif'], 'integer'],
            [['kode_penagih', 'kode_pos', 'telepon', 'handphone'], 'string', 'max' => 20],
            [['nama_penagih', 'email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penagih' => 'Id Penagih',
            'kode_penagih' => 'Kode Penagih',
            'nama_penagih' => 'Nama Penagih',
            'alamat' => 'Alamat',
            'id_kota' => 'Kota',
            'kode_pos' => 'Kode Pos',
            'telepon' => 'Telepon',
            'handphone' => 'Handphone',
            'email' => 'Email',
            'status_aktif' => 'Status',
        ];
    }

    public function getakt_kota()
    {
        return $this->hasOne(AktKota::className(), ['id_kota' => 'id_kota']);
    }
}
