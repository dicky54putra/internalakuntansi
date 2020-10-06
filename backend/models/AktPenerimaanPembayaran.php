<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penerimaan_pembayaran".
 *
 * @property int $id_penerimaan_pembayaran_penjualan
 * @property string $tanggal_penerimaan_pembayaran
 * @property int $id_penjualan
 * @property int $cara_bayar
 * @property int $id_kas_bank
 * @property int $nominal
 * @property string $keterangan
 */
class AktPenerimaanPembayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penerimaan_pembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_penerimaan_pembayaran', 'id_penjualan', 'cara_bayar', 'id_kas_bank', 'nominal'], 'required'],
            [['tanggal_penerimaan_pembayaran'], 'safe'],
            [['id_penjualan', 'cara_bayar', 'id_kas_bank'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penerimaan_pembayaran_penjualan' => 'Id Penerimaan Pembayaran Penjualan',
            'tanggal_penerimaan_pembayaran' => 'Tanggal Penerimaan Pembayaran',
            'id_penjualan' => 'No. Penjualan',
            'cara_bayar' => 'Cara Bayar',
            'id_kas_bank' => 'Kas Bank',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
        ];
    }
}
