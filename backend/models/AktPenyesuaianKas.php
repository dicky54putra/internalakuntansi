<?php

namespace backend\models;

use Yii;
use backend\models\AktMitraBisnis;
/**
 * This is the model class for table "akt_penyesuaian_kas".
 *
 * @property int $id_penyesuaian_kas
 * @property string $no_transaksi
 * @property string $tanggal
 * @property int $id_akun
 * @property int $id_mitra_bisnis
 * @property string $no_referensi
 * @property int $id_kas_bank
 * @property int $id_mata_uang
 * @property double $jumlah
 * @property string $keterangan
 */
class AktPenyesuaianKas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penyesuaian_kas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transaksi', 'tanggal', 'id_akun', 'id_mitra_bisnis', 'no_referensi', 'id_kas_bank', 'id_mata_uang', 'jumlah', 'keterangan'], 'required'],
            [['tanggal','id_akun', 'id_mitra_bisnis'], 'safe'],
            [['id_kas_bank', 'id_mata_uang'], 'integer'],
            [['jumlah'], 'number'],
            [['keterangan'], 'string'],
            [['no_transaksi', 'no_referensi'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penyesuaian_kas' => 'Id Penyesuaian Kas',
            'no_transaksi' => 'No Transaksi',
            'tanggal' => 'Tanggal',
            'id_akun' => 'Nama Akun',
            'id_mitra_bisnis' => 'Mitra Bisnis',
            'no_referensi' => 'No Referensi',
            'id_kas_bank' => 'Kas/Bank',
            'id_mata_uang' => 'Mata Uang',
            'jumlah' => 'Jumlah',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getmitra_bisnis()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_mitra_bisnis']);
    }

    public function getakun()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun']);
    }
    public function getmata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getkas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }
}
