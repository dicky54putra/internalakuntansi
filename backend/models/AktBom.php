<?php

namespace backend\models;

use Yii;
use backend\models\AktItem;
use backend\models\AktItemStok;

/**
 * This is the model class for table "akt_bom".
 *
 * @property int $id_bom
 * @property int $no_bom
 * @property string $keterangan
 * @property string $tipe
 * @property int $id_item_stok
 * @property int $qty
 * @property double $total
 * @property int $status_bom
 */
class AktBom extends \yii\db\ActiveRecord
{
    public $nama_item;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_bom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_bom', 'tipe', 'id_item_stok', 'qty', 'total', 'status_bom'], 'required'],
            [['id_item_stok', 'qty', 'status_bom'], 'integer'],
            [['keterangan'], 'string'],
            [['total'], 'safe'],
            [['tipe'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_bom' => 'Id Bom',
            'no_bom' => 'No B.o.M',
            'keterangan' => 'Keterangan',
            'tipe' => 'Tipe',
            'id_item_stok' => 'Item',
            'qty' => 'Qty',
            'total' => 'Total',
            'status_bom' => 'Status',
        ];
    }

    public function getitem_stok()
    {
        return $this->hasOne(AktItemStok::className(), ['id_item_stok' => 'id_item_stok']);
    }

    public function getlogin()
    {
        return $this->hasOne(Login::className(), ['id_login' => 'id_login']);
    }

    // public function getitem()
    // {
    //     return $this->hasOne(AktItem::className(), ['id_item_stok_stok' => 'id_item_stok']);
    // }
}
