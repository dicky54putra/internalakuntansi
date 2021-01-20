<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "system_role".
 *
 * @property int $id_system_role
 * @property string $nama_role
 */
class Systemrole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_role'], 'required'],
            [['nama_role'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_system_role' => 'Id Hak Akses',
            'nama_role' => 'Nama Hak Akses',
        ];
    }
}
