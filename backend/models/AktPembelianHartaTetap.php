<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembelian_harta_tetap".
 *
 * @property int $id_pembelian_harta_tetap
 * @property int $no_pembelian_harta_tetap
 * @property string $tanggal
 * @property int $termin
 * @property int $id_kas_bank
 * @property int $jumlah_hari
 * @property string $tanggal_selesai
 * @property int $id_supplier
 * @property int $id_mata_uang
 * @property int $status_pajak
 * @property string $keterangan
 * @property int $id_cabang
 * @property int $status
 */
class AktPembelianHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_pembelian_harta_tetap', 'tanggal', 'id_mata_uang', 'id_supplier', 'status', 'jenis_bayar'], 'required'],
            [['termin', 'id_kas_bank', 'jatuh_tempo', 'id_supplier', 'id_mata_uang', 'pajak', 'diskon',  'status', 'id_login',], 'integer'],
            [['tanggal', 'tanggal_tempo', 'uang_muka', 'tanggal_approve', 'ongkir', 'materai'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_harta_tetap' => 'Id Pembelian Harta Tetap',
            'no_pembelian_harta_tetap' => 'No Pembelian Harta Tetap',
            'tanggal' => 'Tanggal',
            'termin' => 'Termin',
            'id_kas_bank' => 'Kas Bank',
            'jatuh_tempo' => 'Jatuh Tempo',
            'tanggal_selesai' => 'Tanggal Selesai',
            'id_supplier' => 'Id Supplier',
            'id_mata_uang' => 'Id Mata Uang',
            'pajak' => 'Pajak',
            'keterangan' => 'Keterangan',
            'id_cabang' => 'Id Cabang',
            'status' => 'Status',
            'materai' => 'Materai',
            'ongkir' => 'Ongkir',
            'jenis_bayar' => 'Jenis Bayar'
        ];
    }

    public function getakt_mata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getakt_cabang()
    {
        return $this->hasOne(AktCabang::className(), ['id_cabang' => 'id_cabang']);
    }

    public function getakt_mitra_bisnis()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_supplier']);
    }

    public function getakt_kas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }
}
