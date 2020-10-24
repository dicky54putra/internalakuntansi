<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_bom_detail_hp".
 *
 * @property int $id_bom_hasil_detail_hp
 * @property int $id_bom
 * @property int $id_item
 */
class AktBomDetailHp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_bom_detail_hp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_bom', 'id_item'], 'required'],
            [['id_bom', 'id_item'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_bom_hasil_detail_hp' => 'Id Bom Hasil Detail Hp',
            'id_bom' => 'Id Bom',
            'id_item' => 'Id Item',
        ];
    }
}
