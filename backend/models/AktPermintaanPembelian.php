<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_permintaan_pembelian".
 *
 * @property int $id_permintaan_pembelian
 * @property string $no_permintaan
 * @property string $tanggal
 * @property int $id_pegawai
 * @property int $status
 * @property string $keterangan
 * @property int $id_cabang
 * @property int $draft
 */
class AktPermintaanPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_permintaan_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_permintaan', 'tanggal', 'id_pegawai'], 'required'],
            [['tanggal'], 'safe'],
            [['id_pegawai', 'id_cabang', 'draft', 'status'], 'integer'],
            [['keterangan'], 'string'],
            [['no_permintaan'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_permintaan_pembelian' => 'Id Permintaan Pembelian',
            'no_permintaan' => 'No. Permintaan',
            'tanggal' => 'Tanggal',
            'id_pegawai' => 'Nama Pegawai',
            'status' => 'Status',
            'keterangan' => 'Keterangan',
            'id_cabang' => 'Id Cabang',
            'draft' => 'Draft',
        ];
    }
}
