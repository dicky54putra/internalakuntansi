<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_cabang".
 *
 * @property int $id_cabang
 * @property string $kode_cabang
 * @property string $nama_cabang
 * @property string $nama_cabang_perusahaan
 * @property string $alamat
 * @property string $telp
 * @property string $fax
 * @property string $npwp
 * @property string $pkp
 * @property int $id_customer
 * @property int $id_foto
 */
class AktCabang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_cabang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_cabang', 'nama_cabang'], 'required'],
            [['id_customer'], 'integer'],
            [['kode_cabang', 'nama_cabang', 'nama_cabang_perusahaan', 'alamat', 'telp', 'fax', 'npwp', 'pkp'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cabang' => 'Id Cabang',
            'kode_cabang' => 'Kode Cabang',
            'nama_cabang' => 'Nama Cabang',
            'nama_cabang_perusahaan' => 'Nama Cabang Perusahaan',
            'alamat' => 'Alamat',
            'telp' => 'Telp',
            'fax' => 'Fax',
            'npwp' => 'Npwp',
            'pkp' => 'Pkp',
            'id_customer' => 'Id Customer',
            // 'id_foto' => 'Id Foto',
        ];
    }
}
