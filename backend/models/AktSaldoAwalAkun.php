<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_saldo_awal_akun".
 *
 * @property int $id_saldo_awal_akun
 * @property string $no_jurnal
 * @property string $tanggal
 * @property int $tipe
 */
class AktSaldoAwalAkun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_saldo_awal_akun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_jurnal', 'tanggal', 'tipe'], 'required'],
            [['tanggal'], 'safe'],
            [['tipe'], 'integer'],
            [['no_jurnal'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_saldo_awal_akun' => 'Id Saldo Awal Akun',
            'no_jurnal' => 'No Jurnal',
            'tanggal' => 'Tanggal',
            'tipe' => 'Tipe',
        ];
    }
}
