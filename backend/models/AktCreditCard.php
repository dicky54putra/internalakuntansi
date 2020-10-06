<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_credit_card".
 *
 * @property int $id_cc
 * @property string $nama_cc
 */
class AktCreditCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_credit_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_cc', 'nama_cc'], 'required'],
            [['kode_cc', 'nama_cc'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cc' => 'Id Cc',
            'kode_cc' => 'Kode',
            'nama_cc' => 'Nama Kartu Kredit',
        ];
    }
}
