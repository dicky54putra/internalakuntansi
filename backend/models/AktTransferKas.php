<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_transfer_kas".
 *
 * @property int $id_transfer_kas
 * @property int $no_transfer_kas
 * @property string $tanggal
 * @property int $id_asal_kas
 * @property int $id_tujuan_kas
 * @property double $jumlah1
 * @property double $jumlah2
 * @property string $keterangan
 */
class AktTransferKas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_transfer_kas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transfer_kas', 'tanggal', 'id_asal_kas', 'id_tujuan_kas', 'jumlah1'], 'required'],
            [['id_asal_kas', 'id_tujuan_kas'], 'integer'],
            [['tanggal'], 'safe'],
            [['jumlah2'], 'number'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_transfer_kas' => 'Id Transfer Kas',
            'no_transfer_kas' => 'No Transfer Kas',
            'tanggal' => 'Tanggal',
            'id_asal_kas' => 'Asal Kas',
            'id_tujuan_kas' => 'Tujuan Kas',
            'jumlah1' => 'Nominal',
            'jumlah2' => 'Jumlah2',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getkas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_asal_kas']);
    }

    public function getkas_bank2()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_tujuan_kas']);
    }
}
