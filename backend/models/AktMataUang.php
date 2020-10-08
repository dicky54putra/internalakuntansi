<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_mata_uang".
 *
 * @property int $id_mata_uang
 * @property string $mata_uang
 * @property string $simbol
 * @property string $kurs
 * @property string $fiskal
 * @property string $rate_type
 * @property int $status_default
 */
class AktMataUang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_mata_uang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mata_uang', 'simbol', 'kurs', 'fiskal', 'rate_type', 'status_default', 'kode_mata_uang'], 'required'],
            [['status_default'], 'integer'],
            [['mata_uang', 'simbol', 'kurs', 'fiskal', 'rate_type', 'kode_mata_uang'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mata_uang' => 'Id Mata Uang',
            'kode_mata_uang' => 'Kode',
            'mata_uang' => 'Mata Uang',
            'simbol' => 'Simbol',
            'kurs' => 'Kurs',
            'fiskal' => 'Fiskal',
            'rate_type' => 'Rate Type',
            'status_default' => 'Default',
        ];
    }
}
