<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_saldo_awal_stok_detail".
 *
 * @property int $id_saldo_awal_stok_detail
 * @property int $id_saldo_awal_stok
 * @property int $id_item
 * @property int $id_item_stok
 * @property int $qty
 */
class AktSaldoAwalStokDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_saldo_awal_stok_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_saldo_awal_stok', 'id_item', 'id_item_stok', 'qty'], 'required'],
            [['id_saldo_awal_stok', 'id_item', 'id_item_stok', 'qty'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_saldo_awal_stok_detail' => 'Id Saldo Awal Stok Detail',
            'id_saldo_awal_stok' => 'Saldo Awal Stok',
            'id_item' => 'Barang',
            'id_item_stok' => 'Gudang',
            'qty' => 'Qty',
        ];
    }
}
