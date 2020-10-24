<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_saldo_awal_akun_detail".
 *
 * @property int $id_saldo_awal_akun_detail
 * @property int $id_saldo_awal_akun
 * @property int $id_akun
 * @property double $debet
 * @property double $kredit
 */
class AktSaldoAwalAkunDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_saldo_awal_akun_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_saldo_awal_akun', 'id_akun'], 'required'],
            [['id_saldo_awal_akun', 'id_akun'], 'integer'],
            [['debet', 'kredit'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_saldo_awal_akun_detail' => 'Id Saldo Awal Akun Detail',
            'id_saldo_awal_akun' => 'Id Saldo Awal Akun',
            'id_akun' => 'Akun',
            'debet' => 'Debet',
            'kredit' => 'Kredit',
        ];
    }
}
