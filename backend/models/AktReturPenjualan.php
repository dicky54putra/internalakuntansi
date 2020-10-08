<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_retur_penjualan".
 *
 * @property int $id_retur_penjualan
 * @property string $no_retur_penjualan
 * @property string $tanggal_retur_penjualan
 * @property int $id_penjualan_pengiriman
 * @property int $status_retur
 */
class AktReturPenjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_retur_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_retur_penjualan', 'tanggal_retur_penjualan', 'id_penjualan_pengiriman', 'status_retur'], 'required'],
            [['tanggal_retur_penjualan'], 'safe'],
            [['id_penjualan_pengiriman', 'status_retur'], 'integer'],
            [['no_retur_penjualan'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_retur_penjualan' => 'Id Retur Penjualan',
            'no_retur_penjualan' => 'No. Retur',
            'tanggal_retur_penjualan' => 'Tanggal Retur',
            'id_penjualan_pengiriman' => 'No. Pengiriman',
            'status_retur' => 'Status',
        ];
    }

    public function getpenjualan_pengiriman()
    {
        return $this->hasOne(AktPenjualanPengiriman::className(), ['id_penjualan_pengiriman' => 'id_penjualan_pengiriman']);
    }
}
