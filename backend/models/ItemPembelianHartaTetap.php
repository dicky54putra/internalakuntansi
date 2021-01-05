<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_pembelian_harta_tetap".
 *
 * @property int $id_item_pembelian_harta_tetap
 * @property int $id_pembelian_harta_tetap
 * @property int $id_harta_tetap
 * @property int $harga
 * @property int $diskon
 * @property int $pajak
 * @property string $lokasi
 * @property string $keterangan
 */
class ItemPembelianHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_pembelian_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian_harta_tetap'], 'required'],
            [['id_pembelian_harta_tetap', 'id_harta_tetap', 'harga', 'diskon'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item_pembelian_harta_tetap' => 'Id Item Pembelian Harta Tetap',
            'id_pembelian_harta_tetap' => 'Id Pembelian Harta Tetap',
            'id_harta_tetap' => 'Id Harta Tetap',
            'harga' => 'Harga',
            'diskon' => 'Diskon',
            'keterangan' => 'Keterangan',
        ];
    }
    public function getHarta_tetap()
    {
        return $this->hasOne(AktHartaTetap::className(), ['id_harta_tetap' => 'id_harta_tetap']);
    }
}
