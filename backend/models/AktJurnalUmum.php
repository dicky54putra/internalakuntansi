<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_jurnal_umum".
 *
 * @property int $id_jurnal_umum
 * @property int $no_jurnal_umum
 * @property int $tanggal
 * @property int $tipe
 */
class AktJurnalUmum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_jurnal_umum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_jurnal_umum', 'tanggal', 'tipe'], 'required'],
            [['no_jurnal_umum', 'tanggal', 'keterangan'], 'safe'],
            [['tipe'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jurnal_umum' => 'Id Jurnal Umum',
            'no_jurnal_umum' => 'No Jurnal Umum',
            'tanggal' => 'Tanggal',
            'tipe' => 'Tipe',
            'keterangan' => 'Keterangan',
        ];
    }
}
