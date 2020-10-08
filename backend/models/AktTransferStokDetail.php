<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_transfer_stok_detail".
 *
 * @property int $id_transfer_stok_detail
 * @property int $id_transfer_stok
 * @property int $id_item
 * @property int $qty
 * @property string $keterangan
 */
class AktTransferStokDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_transfer_stok_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_transfer_stok', 'id_item', 'qty'], 'required'],
            [['id_transfer_stok', 'id_item', 'qty'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_transfer_stok_detail' => 'Id Transfer Stok Detail',
            'id_transfer_stok' => 'Id Transfer Stok',
            'id_item' => 'Barang',
            'qty' => 'Qty',
            'keterangan' => 'Keterangan',
        ];
    }
}
