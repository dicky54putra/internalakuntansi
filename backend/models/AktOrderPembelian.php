<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_order_pembelian".
 *
 * @property int $id_order_pembelian
 * @property string $no_order
 * @property string $tanggal_order
 * @property string $status_order
 * @property int $id_supplier
 * @property int $id_mata_uang
 * @property string $keterangan
 * @property int $id_cabang
 * @property int $draft
 * @property string $alamat_bayar
 * @property string $alamat_kirim
 */
class AktOrderPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_order_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_order', 'tanggal_order'], 'required'],
            [['tanggal_order'], 'safe'],
            [['id_supplier', 'id_mata_uang', 'id_cabang',  'total'], 'integer'],
            [['keterangan', 'alamat_bayar', 'alamat_kirim'], 'string'],
            [['no_order', 'status_order'], 'string', 'max' => 123],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_order_pembelian' => 'Id Order Pembelian',
            'no_order' => 'No Order',
            'tanggal_order' => 'Tanggal Order',
            'status_order' => 'Status Order',
            'id_supplier' => 'Id Supplier',
            'id_mata_uang' => 'Id Mata Uang',
            'keterangan' => 'Keterangan',
            'id_cabang' => 'Id Cabang',
            'alamat_bayar' => 'Alamat Bayar',
            'alamat_kirim' => 'Alamat Kirim',
            'total' => 'Total',
        ];
    }

    public function getakt_supplier()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_supplier']);
    }
    public function getakt_cabang()
    {
        return $this->hasOne(AktCabang::className(), ['id_cabang' => 'id_cabang']);
    }
    public function getakt_mata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }
}
