<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "menu_navigasi".
 *
 * @property int $id_menu
 * @property string $nama_menu
 * @property string $url
 * @property int $id_parent
 * @property int $no_urut
 * @property string $icon
 * @property int $status
 */
class MenuNavigasi extends \yii\db\ActiveRecord
{
    public $parent;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu_navigasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_menu', 'url',  'no_urut', 'icon', 'status'], 'required'],
            [['id_parent', 'no_urut', 'status'], 'integer'],
            [['nama_menu', 'url'], 'string', 'max' => 200],
            [['icon'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_menu' => 'Id Menu',
            'nama_menu' => 'Nama Menu',
            'url' => 'URL',
            'id_parent' => 'Id Parent',
            'no_urut' => 'No Urut',
            'icon' => 'Icon',
            'status' => 'Status',
        ];
    }
}
