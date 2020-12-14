<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penjualan_harta_tetap_detail".
 *
 * @property int $id_penjualan_harta_tetap_detail
 * @property int $id_penjualan_harta_tetap
 * @property int $id_pembelian_harta_tetap_detail
 * @property int $qty
 * @property int $harga
 * @property double $diskon
 * @property int $total
 * @property string $keterangan
 */
class AktPenjualanHartaTetapDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penjualan_harta_tetap_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan_harta_tetap', 'id_pembelian_harta_tetap_detail', 'qty', 'harga', 'total'], 'required'],
            [['id_penjualan_harta_tetap', 'id_pembelian_harta_tetap_detail', 'qty'], 'integer'],
            [['total', 'diskon'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_harta_tetap_detail' => 'Id Penjualan Harta Tetap Detail',
            'id_penjualan_harta_tetap' => 'Id Penjualan Harta Tetap',
            'id_pembelian_harta_tetap_detail' => 'Barang',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'diskon' => 'Diskon %',
            'total' => 'Total',
            'keterangan' => 'Keterangan',
        ];
    }
}
