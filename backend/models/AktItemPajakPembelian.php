<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_item_pajak_pembelian".
 *
 * @property int $id_item_pajak_pembelian
 * @property int $id_item
 * @property int $id_pajak
 * @property int $perhitungan
 */
class AktItemPajakPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_item_pajak_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_item', 'id_pajak', 'perhitungan'], 'required'],
            [['id_item', 'id_pajak', 'perhitungan'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_pajak_pembelian' => 'Id Item Pajak Pembelian',
            'id_item' => 'Id Item',
            'id_pajak' => 'Id Pajak',
            'perhitungan' => 'Perhitungan',
        ];
    }
}
