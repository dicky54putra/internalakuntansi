<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_transfer_stok".
 *
 * @property int $id_transfer_stok
 * @property string $no_transfer
 * @property string $tanggal_transfer
 * @property int $id_gudang_asal
 * @property int $id_gudang_tujuan
 * @property string $keterangan
 */
class AktTransferStok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_transfer_stok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transfer', 'tanggal_transfer', 'id_gudang_asal', 'id_gudang_tujuan'], 'required'],
            [['tanggal_transfer'], 'safe'],
            [['id_gudang_asal', 'id_gudang_tujuan'], 'integer'],
            [['keterangan'], 'string'],
            [['no_transfer'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_transfer_stok' => 'Id Transfer Stok',
            'no_transfer' => 'No Transfer',
            'tanggal_transfer' => 'Tanggal Transfer',
            'id_gudang_asal' => 'Gudang Asal',
            'id_gudang_tujuan' => 'Gudang Tujuan',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getgudang_asal()
    {
        return $this->hasOne(AktGudang::className(), ['id_gudang' => 'id_gudang_asal'])->from(["gudang_asal" => AktGudang::tableName()]);
    }

    public function getgudang_tujuan()
    {
        return $this->hasOne(AktGudang::className(), ['id_gudang' => 'id_gudang_tujuan'])->from(["gudang_tujuan" => AktGudang::tableName()]);
    }
}
