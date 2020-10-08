<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembayaran_biaya_harta_tetap".
 *
 * @property int $id_pembayaran_biaya_harta_tetap
 * @property string $tanggal_pembayaran_biaya
 * @property int $id_pembelian_harta_tetap
 * @property int $cara_bayar
 * @property int $id_kas_bank
 * @property int $nominal
 * @property string $keterangan
 */
class AktPembayaranBiayaHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembayaran_biaya_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_pembayaran_biaya', 'id_pembelian_harta_tetap', 'cara_bayar', 'id_kas_bank', 'nominal'], 'required'],
            [['tanggal_pembayaran_biaya'], 'safe'],
            [['id_pembelian_harta_tetap', 'cara_bayar', 'id_kas_bank'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembayaran_biaya_harta_tetap' => 'Id Pembayaran Biaya Harta Tetap',
            'tanggal_pembayaran_biaya' => 'Tanggal Pembayaran Biaya',
            'id_pembelian_harta_tetap' => 'Id Pembelian Harta Tetap',
            'cara_bayar' => 'Cara Bayar',
            'id_kas_bank' => 'Id Kas Bank',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
        ];
    }
}
