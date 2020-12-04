<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_laba_rugi_detail".
 *
 * @property int $id_laba_rugi_detail
 * @property int $id_laba_rugi
 * @property int $id_akun
 * @property int $saldo_akun
 */
class AktLabaRugiDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_laba_rugi_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_laba_rugi', 'id_akun', 'saldo_akun'], 'required'],
            [['id_laba_rugi', 'id_akun'], 'integer'],
            [['saldo_akun'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_laba_rugi_detail' => 'Id Laba Rugi Detail',
            'id_laba_rugi' => 'Id Laba Rugi',
            'id_akun' => 'Id Akun',
            'saldo_akun' => 'Nominal',
        ];
    }
}
