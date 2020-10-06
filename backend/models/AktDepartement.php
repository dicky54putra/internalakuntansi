<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_departement".
 *
 * @property int $id_departement
 * @property string $kode_departement
 * @property string $nama_departement
 * @property string $keterangan
 * @property int $status_aktif
 */
class AktDepartement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_departement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_departement', 'nama_departement', 'keterangan', 'status_aktif'], 'required'],
            [['keterangan'], 'string'],
            [['status_aktif'], 'integer'],
            [['kode_departement', 'nama_departement'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_departement' => 'Id Departemen',
            'kode_departement' => 'Kode Departemen',
            'nama_departement' => 'Nama Departemen',
            'keterangan' => 'Keterangan',
            'status_aktif' => 'Status',
        ];
    }
}
