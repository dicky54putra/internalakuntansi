<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu_navigasi_role".
 *
 * @property int $id_menu_role
 * @property int $id_menu
 * @property int $id_system_role
 */
class MenuNavigasiRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_navigasi_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_menu', 'id_system_role'], 'required'],
            [['id_menu', 'id_system_role'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_menu_role' => 'Id Menu Role',
            'id_menu' => 'Id Menu',
            'id_system_role' => 'Id System Role',
        ];
    }
}
