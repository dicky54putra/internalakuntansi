<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penerimaan_pembayaran_harta_tetap".
 *
 * @property int $id_penerimaan_pembayaran_harta_tetap
 * @property string $tanggal_penerimaan_pembayaran
 * @property int $id_penjualan_harta_tetap
 * @property int $cara_bayar
 * @property int $id_kas_bank
 * @property int $nominal
 * @property string $keterangan
 */
class AktPenerimaanPembayaranHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penerimaan_pembayaran_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_penerimaan_pembayaran', 'id_penjualan_harta_tetap', 'cara_bayar', 'id_kas_bank', 'nominal', 'keterangan'], 'required'],
            [['tanggal_penerimaan_pembayaran', 'nominal'], 'safe'],
            [['id_penjualan_harta_tetap', 'cara_bayar', 'id_kas_bank'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penerimaan_pembayaran_harta_tetap' => 'Id Penerimaan Pembayaran Harta Tetap',
            'tanggal_penerimaan_pembayaran' => 'Tanggal Penerimaan Pembayaran',
            'id_penjualan_harta_tetap' => 'Id Penjualan Harta Tetap',
            'cara_bayar' => 'Cara Bayar',
            'id_kas_bank' => 'Id Kas Bank',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
        ];
    }
}
