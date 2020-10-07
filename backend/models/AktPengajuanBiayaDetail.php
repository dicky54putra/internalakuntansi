<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pengajuan_biaya_detail".
 *
 * @property int $id_pengajuan_biaya_detail
 * @property int $id_pengajuan
 * @property int $id_akun
 * @property string $kode_rekening
 * @property string $nama_pengajuan
 * @property string $debit
 * @property string $kredit
 */
class AktPengajuanBiayaDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pengajuan_biaya_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pengajuan_biaya', 'id_akun', 'kode_rekening', 'nama_pengajuan'], 'required'],
            [['id_pengajuan_biaya', 'id_akun'], 'integer'],
            [['kode_rekening', 'nama_pengajuan'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pengajuan_biaya_detail' => 'Id Pengajuan Biaya Detail',
            'id_pengajuan_biaya' => 'Id Pengajuan',
            'id_akun' => 'Akun',
            'kode_rekening' => 'Divisi',
            'nama_pengajuan' => 'Nama Pengajuan',
            'debit' => 'Debit',
            'kredit' => 'Kredit',
        ];
    }
}
