<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_klasifikasi".
 *
 * @property int $id_klasifikasi
 * @property string $klasifikasi
 */
class AktKlasifikasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_klasifikasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['klasifikasi'], 'required'],
            [['klasifikasi'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_klasifikasi' => 'Id Klasifikasi',
            'klasifikasi' => 'Klasifikasi',
        ];
    }
}
