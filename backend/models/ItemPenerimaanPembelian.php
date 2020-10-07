<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_penerimaan_pembelian".
 *
 * @property int $id_item_penerimaan_pembelian
 * @property int $id_pembelian
 * @property string $tanggal
 * @property string $pengirim
 * @property string $penerima
 * @property int $id_item_pembelian
 * @property int $qty
 */
class ItemPenerimaanPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_penerimaan_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian', 'id_item_pembelian', 'qty'], 'integer'],
            [['tanggal', 'pengirim', 'penerima', 'id_item_pembelian', 'qty'], 'required'],
            [['tanggal'], 'safe'],
            [['pengirim', 'penerima'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_penerimaan_pembelian' => 'Id Item Penerimaan Pembelian',
            'id_pembelian' => 'Id Pembelian',
            'tanggal' => 'Tanggal',
            'pengirim' => 'Pengirim',
            'penerima' => 'Penerima',
            'id_item_pembelian' => 'Id Item Pembelian',
            'qty' => 'Qty',
        ];
    }

    public function getItem_pembelian()
    {
        return $this->hasOne(ItemPembelian::className(), ['id_item_pembelian' => 'id_item_pembelian']);
    }
}
