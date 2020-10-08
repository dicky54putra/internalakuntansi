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
class AktDepresiasiHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_depresiasi_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_depresiasi', 'tanggal', 'nilai', 'id_pembelian_harta_tetap_detail'], 'required'],
            [['id_pembelian_harta_tetap_detail'], 'integer'],
            [['kode_depresiasi', 'tanggal', 'nilai'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_harta_tetap_detail' => 'Pembelian Harta Tetap',
            'kode_depresiasi' => 'Kode Depresiasi',
            'tanggal' => 'Tanggal',
            'nilai' => 'Nilai',
        ];
    }
}
