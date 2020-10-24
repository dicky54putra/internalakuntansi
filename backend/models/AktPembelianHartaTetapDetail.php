<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembelian_harta_tetap_detail".
 *
 * @property int $id_pembelian_harta_tetap_detail
 * @property int $id_pembelian_harta_tetap
 * @property string $kode_pembelian
 * @property int $qty
 * @property int $diskon
 * @property string $keterangan
 * @property int $harga
 * @property string $nama_barang
 */
class AktPembelianHartaTetapDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian_harta_tetap_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian_harta_tetap',  'qty', 'harga', 'nama_barang'], 'required'],
            [['id_pembelian_harta_tetap', 'qty', 'diskon', 'total', 'umur_ekonomis'], 'integer'],
            [['keterangan'], 'string'],
            [['residu', 'tipe_harta_tetap', 'tanggal_pakai', 'lokasi', 'id_kelompok_aset_tetap', 'terhitung_tanggal', 'tanggal_terjual'], 'safe'],
            [['kode_pembelian'], 'string', 'max' => 30],
            [['nama_barang'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_harta_tetap_detail' => 'Id Pembelian Harta Tetap Detail',
            'id_pembelian_harta_tetap' => 'Id Pembelian Harta Tetap',
            'kode_pembelian' => 'Kode Pembelian',
            'qty' => 'Qty',
            'diskon' => 'Diskon',
            'keterangan' => 'Keterangan',
            'harga' => 'Harga',
            'nama_barang' => 'Nama Barang',
            'residu' => 'Residu',
        ];
    }
    public function getakt_pembelian_harta_tetap()
    {
        return $this->hasOne(AktPembelianHartaTetap::className(), ['id_pembelian_harta_tetap' => 'id_pembelian_harta_tetap']);
    }
}
