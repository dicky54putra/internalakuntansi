<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property int $id_user_role
 * @property int $id_system_role
 * @property int $id_login
 */
class Userrole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_system_role', 'id_login'], 'required'],
            [['id_system_role', 'id_login'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_user_role' => 'Id User Role',
            'id_system_role' => 'Id System Role',
            'id_login' => 'Id Login',
        ];
    }
	
	public function getSystem_role() 
    {
        return $this->hasOne(Systemrole::className(), ['id_system_role' => 'id_system_role']);
    }
	
	public function getLogin() 
    {
        return $this->hasOne(Login::className(), ['id_login' => 'id_login']);
    }
}
