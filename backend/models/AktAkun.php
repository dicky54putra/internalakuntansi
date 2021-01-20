<?php

namespace backend\models;

use Yii;
use backend\models\AktAktKlasifikasi;

/**
 * This is the model class for table "akt_akun".
 *
 * @property int $id_akun
 * @property string $kode_akun
 * @property string $nama_akun
 * @property int $saldo_akun
 * @property int $header
 * @property int $parent
 * @property int $jenis
 * @property int $klasifikasi
 * @property int $status_aktif
 */
class AktAkun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_akun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_akun', 'nama_akun', 'saldo_akun', 'header', 'jenis', 'klasifikasi', 'status_aktif', 'saldo_normal'], 'required'],
            [['saldo_akun', 'header', 'parent', 'jenis', 'klasifikasi', 'status_aktif', 'saldo_normal'], 'integer'],
            [['kode_akun', 'nama_akun'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_akun' => 'Id Akun',
            'kode_akun' => 'Kode Akun',
            'nama_akun' => 'Nama Akun',
            'saldo_akun' => 'Saldo Akun',
            'header' => 'Header',
            'parent' => 'Parent',
            'jenis' => 'Jenis',
            'klasifikasi' => 'Klasifikasi',
            'saldo_normal' => 'Debet/Kredit',
            'status_aktif' => 'Status',
        ];
    }

    public function getakt_klasifikasi()
    {
        return $this->hasOne(AktKlasifikasi::className(), ['id_klasifikasi' => 'klasifikasi']);
    }
}
