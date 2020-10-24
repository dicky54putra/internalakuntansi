<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pengaturan".
 *
 * @property int $id_pengaturan
 * @property string $nama_pengaturan
 * @property int $status
 */
class Pengaturan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengaturan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pengaturan'], 'required'],
            [['status'], 'integer'],
            [['nama_pengaturan'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pengaturan' => 'Id Pengaturan',
            'nama_pengaturan' => 'Nama Pengaturan',
            'status' => 'Status',
        ];
    }
}
