<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_item".
 *
 * @property int $id_item
 * @property string $kode_item
 * @property string $barcode_item
 * @property string $nama_item
 * @property string $nama_alias_item
 * @property int $id_tipe_item
 * @property int $id_merk
 * @property string $keterangan_item
 * @property int $status_aktif_item
 */
class AktItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_item', 'nama_item', 'id_tipe_item', 'status_aktif_item', 'berat_item'], 'required'],
            [['id_tipe_item', 'id_merk', 'status_aktif_item', 'id_satuan', 'id_mitra_bisnis'], 'integer'],
            [['keterangan_item'], 'string'],
            [['berat_item'], 'safe'],
            [['kode_item', 'barcode_item', 'nama_item', 'nama_alias_item'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_item' => 'Id Barang',
            'kode_item' => 'Kode Barang',
            'barcode_item' => 'Barcode Barang',
            'nama_item' => 'Nama Barang',
            'nama_alias_item' => 'Nama Alias Barang',
            'id_tipe_item' => 'Tipe Barang',
            'id_merk' => 'Merk',
            'berat_item' => 'Berat Item (Kg)',
            'keterangan_item' => 'Keterangan Barang',
            'status_aktif_item' => 'Status',
            'id_satuan' => 'Satuan',
            'id_mitra_bisnis' => 'Mitra Bisnis',
        ];
    }

    public function gettipe_item()
    {
        return $this->hasOne(AktItemTipe::className(), ['id_tipe_item' => 'id_tipe_item']);
    }

    public function getmerk()
    {
        return $this->hasOne(AktMerk::className(), ['id_merk' => 'id_merk']);
    }

    public function getsatuan()
    {
        return $this->hasOne(AktSatuan::className(), ['id_satuan' => 'id_satuan']);
    }

    public function getmitra_bisnis()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_mitra_bisnis']);
    }
}
