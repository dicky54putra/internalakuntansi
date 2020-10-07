<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_kas_bank".
 *
 * @property int $id_kas_bank
 * @property string $kode_kas_bank
 * @property string $keterangan
 * @property string $jenis
 * @property int $id_mata_uang
 * @property int $saldo
 * @property int $total_giro_keluar
 * @property int $id_akun
 * @property int $status_aktif
 */
class AktKasBank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_kas_bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_kas_bank', 'keterangan', 'status_aktif'], 'required'],
            [['keterangan'], 'string'],
            [['id_mata_uang', 'saldo', 'total_giro_keluar', 'id_akun', 'status_aktif'], 'integer'],
            [['kode_kas_bank', 'jenis'], 'string', 'max' => 123],
            [['id_mata_uang'], 'exist', 'skipOnError' => true, 'targetClass' => AktMataUang::className(), 'targetAttribute' => ['id_mata_uang' => 'id_mata_uang']],
            [['id_akun'], 'exist', 'skipOnError' => true, 'targetClass' => AktAkun::className(), 'targetAttribute' => ['id_akun' => 'id_akun']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kas_bank' => 'Id Kas Bank',
            'kode_kas_bank' => 'Kode',
            'keterangan' => 'Keterangan',
            'jenis' => 'Tipe Kas',
            'id_mata_uang' => 'Mata Uang',
            'saldo' => 'Saldo',
            'total_giro_keluar' => 'Total Giro Keluar',
            'id_akun' => 'Akun',
            'status_aktif' => 'Status',
        ];
    }

    public function getakt_mata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getakt_akun()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun']);
    }
}
