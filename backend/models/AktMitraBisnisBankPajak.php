<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_mitra_bisnis_bank_pajak".
 *
 * @property int $id_mitra_bisnis_bank_pajak
 * @property int $id_mitra_bisnis
 * @property string $nama_bank
 * @property string $no_rekening
 * @property string $atas_nama
 * @property string $npwp
 * @property string $pkp
 * @property string $tanggal_pkp
 * @property string $no_nik
 * @property string $atas_nama_nik
 * @property int $pembelian_pajak
 * @property int $penjualan_pajak
 */
class AktMitraBisnisBankPajak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_mitra_bisnis_bank_pajak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis', 'nama_bank', 'no_rekening', 'atas_nama'], 'required'],
            [['id_mitra_bisnis'], 'integer'],
            [['tanggal_pkp'], 'safe'],
            [['nama_bank', 'no_rekening', 'atas_nama', 'npwp', 'pkp', 'no_nik', 'atas_nama_nik'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mitra_bisnis_bank_pajak' => 'Id Mitra Bisnis Bank Pajak',
            'id_mitra_bisnis' => 'Id Mitra Bisnis',
            'nama_bank' => 'Nama Bank',
            'no_rekening' => 'No Rekening',
            'atas_nama' => 'Atas Nama',
            'npwp' => 'NPWP',
            'pkp' => 'PKP',
            'tanggal_pkp' => 'Tanggal PKP',
            'no_nik' => 'No NIK',
            'atas_nama_nik' => 'Atas Nama NIK',
        ];
    }
}
