<?php

namespace backend\models;

use backend\models\AktItem;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_item_stok".
 *
 * @property int $id_item_stok
 * @property int $id_item
 * @property int $id_gudang
 * @property string $location
 * @property int $qty
 * @property int $hpp
 * @property int $min
 */
class AktItemStok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_item_stok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item', 'id_gudang', 'qty', 'hpp', 'min'], 'required'],
            [['id_item', 'id_gudang', 'qty'], 'integer'],
            [['hpp', 'min'], 'safe'],
            [['location'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_stok' => 'Id Item Stok',
            'id_item' => 'Id Item',
            'id_gudang' => 'Gudang',
            'location' => 'Location',
            'qty' => 'Qty',
            'hpp' => 'Hpp',
            'min' => 'Min',
        ];
    }

    public function getitem()
    {
        return $this->hasOne(AktItem::className(), ['id_item' => 'id_item']);
    }

    public function getgudang()
    {
        return $this->hasOne(AktGudang::className(), ['id_gudang' => 'id_gudang']);
    }

    public static function getKodeGudang($model)
    {
        $data_gudang = ArrayHelper::map(AktGudang::find()->all(), 'id_gudang', function ($model) {
            return $model->kode_gudang . ' - ' . $model->nama_gudang;
        });

        return $data_gudang;
    }
}
