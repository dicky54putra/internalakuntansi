<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_satuan".
 *
 * @property int $id_satuan
 * @property string $nama_satuan
 */
class AktSatuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_satuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_satuan'], 'required'],
            [['nama_satuan'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_satuan' => 'Id Satuan',
            'nama_satuan' => 'Nama Satuan',
        ];
    }
}
