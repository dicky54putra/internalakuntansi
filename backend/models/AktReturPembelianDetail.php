<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_retur_pembelian_detail".
 *
 * @property int $id_retur_pembelian_detail
 * @property int $id_retur_pembelian
 * @property int $id_pembelian_detail
 * @property int $qty
 * @property int $retur
 * @property string $keterangan
 */
class AktReturPembelianDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_retur_pembelian_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_retur_pembelian', 'id_pembelian_detail', 'qty', 'retur'], 'required'],
            [['id_retur_pembelian', 'id_pembelian_detail', 'qty', 'retur'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_retur_pembelian_detail' => 'Id Retur Pembelian Detail',
            'id_retur_pembelian' => 'Id Retur Pembelian',
            'id_pembelian_detail' => 'Id Pembelian Detail',
            'qty' => 'Qty',
            'retur' => 'Retur',
            'keterangan' => 'Keterangan',
        ];
    }
}
