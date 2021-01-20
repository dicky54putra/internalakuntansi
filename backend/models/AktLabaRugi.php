<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_laba_rugi".
 *
 * @property int $id_laba_rugi
 * @property string $tanggal
 * @property int $periode
 * @property int $id_login
 */
class AktLabaRugi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_laba_rugi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'periode'], 'required'],
            [['tanggal','tanggal_approve'], 'safe'],
            [['periode', 'id_login'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_laba_rugi' => 'Id Laba Rugi',
            'tanggal' => 'Tanggal',
            'periode' => 'Periode',
            'id_login' => 'Id Login',
        ];
    }
}
