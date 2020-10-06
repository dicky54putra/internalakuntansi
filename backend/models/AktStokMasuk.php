<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_stok_masuk".
 *
 * @property int $id_stok_masuk
 * @property string $nomor_transaksi
 * @property string $tanggal_masuk
 * @property int $tipe
 * @property int $metode
 * @property int $id_akun_persediaan
 * @property string $keterangan
 */
class AktStokMasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_stok_masuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_transaksi', 'tanggal_masuk', 'tipe'], 'required'],
            [['tanggal_masuk'], 'safe'],
            [['tipe'], 'integer'],
            [['keterangan'], 'string'],
            [['nomor_transaksi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_masuk' => 'Id Stok Masuk',
            'nomor_transaksi' => 'Nomor Transaksi',
            'tanggal_masuk' => 'Tanggal Masuk',
            'tipe' => 'Tipe',
            'keterangan' => 'Keterangan',
        ];
    }
}
