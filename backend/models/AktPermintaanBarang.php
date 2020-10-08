<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_permintaan_barang".
 *
 * @property int $id_permintaan_barang
 * @property string $nomor_permintaan
 * @property string $tanggal_permintaan
 * @property int $status_aktif
 */
class AktPermintaanBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_permintaan_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_permintaan', 'tanggal_permintaan', 'status_aktif','id_pegawai'], 'required'],
            [['tanggal_permintaan'], 'safe'],
            [['status_aktif'], 'integer'],
            [['nomor_permintaan'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_permintaan_barang' => 'Id Permintaan Barang',
            'nomor_permintaan' => 'Nomor Permintaan',
            'tanggal_permintaan' => 'Tanggal Permintaan',
            'status_aktif' => 'Status Aktif',
            'id_pegawai' => 'Pegawai'
        ];
    }

    public function getpegawai()
    {
        return $this->hasOne(AktPegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
}
