<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "request_fitur".
 *
 * @property int $id_request_fitur
 * @property string $tanggal
 * @property int $id_login
 * @property string $keterangan
 */
class RequestFitur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_fitur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'id_login', 'keterangan'], 'required'],
            [['tanggal','status'], 'safe'],
            [['id_login'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_request_fitur' => 'Id Request Fitur',
            'tanggal' => 'Tanggal',
            'id_login' => 'Nama User',
            'keterangan' => 'Keterangan',
            'status' => 'Status',
        ];
    }

    public function getLogin()
    {
        return $this->hasOne(Login::className(), ["id_login"=>"id_login"]);
    }
}
