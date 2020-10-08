<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembayaran_biaya".
 *
 * @property int $id_pembayaran_biaya
 * @property string $tanggal_pembayaran_biaya
 * @property int $id_pembelian
 * @property int $cara_bayar
 * @property int $id_kas_bank
 * @property int $nominal
 * @property string $keterangan
 */
class AktPembayaranBiaya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembayaran_biaya';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_pembayaran_biaya', 'id_pembelian', 'cara_bayar', 'id_kas_bank', 'nominal'], 'required'],
            [['tanggal_pembayaran_biaya'], 'safe'],
            [['id_pembelian', 'cara_bayar', 'id_kas_bank'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembayaran_biaya' => 'Id Pembayaran Biaya',
            'tanggal_pembayaran_biaya' => 'Tanggal Pembayaran Biaya',
            'id_pembelian' => 'Id Pembelian',
            'cara_bayar' => 'Cara Bayar',
            'id_kas_bank' => 'Kas Bank',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
        ];
    }
}
