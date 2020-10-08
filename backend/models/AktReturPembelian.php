<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_retur_pembelian".
 *
 * @property int $id_retur_pembelian
 * @property string $no_retur_pembelian
 * @property string $tanggal_retur_pembelian
 * @property int $id_pembelian
 * @property int $status_retur
 */
class AktReturPembelian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_retur_pembelian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_retur_pembelian', 'tanggal_retur_pembelian', 'id_pembelian', 'status_retur'], 'required'],
            [['tanggal_retur_pembelian'], 'safe'],
            [['id_pembelian', 'status_retur'], 'integer'],
            [['no_retur_pembelian'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_retur_pembelian' => 'Id Retur Pembelian',
            'no_retur_pembelian' => 'No Retur Pembelian',
            'tanggal_retur_pembelian' => 'Tanggal Retur Pembelian',
            'id_pembelian' => 'Id Pembelian',
            'status_retur' => 'Status Retur',
        ];
    }

    public function getPembelian()
    {
        return $this->hasOne(AktPembelian::className(), ['id_pembelian' => 'id_pembelian']);
    }
}
