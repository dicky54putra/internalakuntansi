<?php

namespace backend\models;

use Yii;
use backend\models\AktLevelHarga;
use backend\models\AktSales;

/**
 * This is the model class for table "akt_mitra_bisnis".
 *
 * @property int $id_mitra_bisnis
 * @property string $kode_mitra_bisnis
 * @property string $deskripsi_mitra_bisnis
 * @property int $tipe_mitra_bisnis
 * @property int $id_gmb_satu
 * @property int $id_gmb_dua
 * @property int $id_gmb_tiga
 * @property int $id_level_harga
 * @property int $id_sales
 */
class AktMitraBisnis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_mitra_bisnis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_mitra_bisnis', 'tipe_mitra_bisnis', 'nama_mitra_bisnis', 'status_mitra_bisnis'], 'required'],
            [['deskripsi_mitra_bisnis'], 'string'],
            [['tipe_mitra_bisnis', 'id_gmb_satu', 'id_gmb_dua', 'id_gmb_tiga', 'id_level_harga', 'id_sales', 'status_mitra_bisnis'], 'integer'],
            [['kode_mitra_bisnis', 'nama_mitra_bisnis', 'pemilik_bisnis'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mitra_bisnis' => 'Id Mitra Bisnis',
            'kode_mitra_bisnis' => 'Kode Mitra Bisnis',
            'deskripsi_mitra_bisnis' => 'Deskripsi Mitra Bisnis',
            'tipe_mitra_bisnis' => 'Tipe Mitra Bisnis',
            'id_gmb_satu' => 'Id Gmb Satu',
            'id_gmb_dua' => 'Id Gmb Dua',
            'id_gmb_tiga' => 'Id Gmb Tiga',
            'id_level_harga' => 'Level Harga',
            'id_sales' => 'Sales',
            'nama_mitra_bisnis' => 'Nama Mitra Bisnis',
            'status_mitra_bisnis' => 'Status',
            'pemilik_bisnis' => 'Pemilik Bisnis',
        ];
    }

    public function getsales()
    {
        return $this->hasOne(AktSales::className(), ['id_sales' => 'id_sales']);
    }

    public function getlevel_harga()
    {
        return $this->hasOne(AktLevelHarga::className(), ['id_level_harga' => 'id_level_harga']);
    }
}
