<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_proyek".
 *
 * @property int $id_proyek
 * @property string $kode_proyek
 * @property string $nama_proyek
 * @property int $id_pegawai
 * @property int $id_mitra_bisnis
 * @property int $status_aktif
 */
class AktProyek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_proyek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_proyek', 'nama_proyek', 'id_pegawai', 'id_mitra_bisnis', 'status_aktif'], 'required'],
            [['id_pegawai', 'id_mitra_bisnis', 'status_aktif'], 'integer'],
            [['kode_proyek', 'nama_proyek'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_proyek' => 'Id Proyek',
            'kode_proyek' => 'Kode Proyek',
            'nama_proyek' => 'Nama Proyek',
            'id_pegawai' => 'Pegawai',
            'id_mitra_bisnis' => 'Mitra Bisnis',
            'status_aktif' => 'Status',
        ];
    }
}
