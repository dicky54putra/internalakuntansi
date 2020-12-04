<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_laporan_posisi_keuangan".
 *
 * @property int $id_laporan_posisi_keuangan
 * @property int $id_laba_rugi
 * @property int $id_akun
 * @property int $nominal
 */
class AktLaporanPosisiKeuangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_laporan_posisi_keuangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_laba_rugi', 'id_akun', 'nominal'], 'required'],
            [['id_laba_rugi', 'id_akun'], 'integer'],
            [['nominal'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_laporan_posisi_keuangan' => 'Id Laporan Posisi Keuangan',
            'id_laba_rugi' => 'Id Laba Rugi',
            'id_akun' => 'Id Akun',
            'nominal' => 'Nominal',
        ];
    }
}
