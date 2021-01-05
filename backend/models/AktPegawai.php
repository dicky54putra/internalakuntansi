<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_pegawai".
 *
 * @property int $id_pegawai
 * @property string $kode_pegawai
 * @property string $nama_pegawai
 * @property string $alamat
 * @property int $id_kota
 * @property int $kode_pos
 * @property int $telepon
 * @property int $handphone
 * @property string $email
 * @property int $status_aktif
 */
class AktPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_pegawai', 'nama_pegawai', 'alamat', 'id_kota'], 'required'],
            [['alamat'], 'string'],
            [['id_kota', 'status_aktif'], 'integer'],
            [['kode_pegawai', 'kode_pos', 'telepon', 'handphone'], 'string', 'max' => 20],
            [['nama_pegawai', 'email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pegawai' => 'Id Pegawai',
            'kode_pegawai' => 'Kode Pegawai',
            'nama_pegawai' => 'Nama Pegawai',
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

    public static function getArrayKota($model)
    {
        $data =  ArrayHelper::map(AktKota::find()->all(), 'id_kota', function ($model) {
            return $model->kode_kota . ' - ' . $model->nama_kota;
        });
        return $data;
    }
}
