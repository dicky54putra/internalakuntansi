<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_jurnal_umum_detail".
 *
 * @property int $id_jurnal_umum_detail
 * @property int $id_jurnal_umum
 * @property int $id_akun
 * @property int $debit
 * @property int $kredit
 * @property string $keterangan
 */
class AktJurnalUmumDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_jurnal_umum_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jurnal_umum', 'id_akun', 'debit', 'kredit', 'keterangan'], 'required'],
            [['id_jurnal_umum', 'id_akun'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jurnal_umum_detail' => 'Id Jurnal Umum Detail',
            'id_jurnal_umum' => 'Id Jurnal Umum',
            'id_akun' => 'Akun',
            'debit' => 'Debit',
            'kredit' => 'Kredit',
            'keterangan' => 'Keterangan',
        ];
    }
}
