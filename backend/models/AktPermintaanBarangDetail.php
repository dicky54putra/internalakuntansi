<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_permintaan_barang_detail".
 *
 * @property int $id_permintaan_barang_detail
 * @property int $id_permintaan_barang
 * @property int $id_item
 * @property int $qty
 * @property int $qty_ordered
 * @property int $qty_rejected
 * @property string $keterangan
 * @property string $request_date
 */
class AktPermintaanBarangDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_permintaan_barang_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_permintaan_barang', 'id_item', 'qty', 'qty_ordered', 'qty_rejected'], 'required'],
            [['id_permintaan_barang', 'id_item', 'qty', 'qty_ordered', 'qty_rejected'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_permintaan_barang_detail' => 'Id Permintaan Barang Detail',
            'id_permintaan_barang' => 'Id Permintaan Barang',
            'id_item' => 'Item',
            'qty' => 'Qty',
            'qty_ordered' => 'Qty Ordered',
            'qty_rejected' => 'Qty Rejected',
            'keterangan' => 'Keterangan',
        ];
    }
}
