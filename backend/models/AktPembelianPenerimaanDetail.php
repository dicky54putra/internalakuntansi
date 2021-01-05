<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembelian_penerimaan_detail".
 *
 * @property int $id_pembelian_penerimaan_detail
 * @property int $id_pembelian_penerimaan
 * @property int $id_pembelian_detail
 * @property int $qty_diterima
 * @property string $keterangan
 */
class AktPembelianPenerimaanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian_penerimaan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian_penerimaan', 'id_pembelian_detail', 'qty_diterima'], 'required'],
            [['id_pembelian_penerimaan', 'id_pembelian_detail', 'qty_diterima'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_penerimaan_detail' => 'Pembelian Penerimaan Detail',
            'id_pembelian_penerimaan' => 'Pembelian Penerimaan',
            'id_pembelian_detail' => 'Pembelian Detail',
            'qty_diterima' => 'Qty Diterima',
            'keterangan' => 'Keterangan',
        ];
    }
}
