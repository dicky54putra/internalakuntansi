<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_saldo_awal_kas".
 *
 * @property int $id_saldo_awal_kas
 * @property string $no_transaksi
 * @property string $tanggal_transaksi
 * @property int $id_kas_bank
 * @property int $jumlah
 * @property string $keterangan
 */
class AktSaldoAwalKas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_saldo_awal_kas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transaksi', 'tanggal_transaksi', 'id_kas_bank', 'jumlah'], 'required'],
            [['tanggal_transaksi'], 'safe'],
            [['id_kas_bank'], 'integer'],
            [['keterangan'], 'string'],
            [['no_transaksi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_saldo_awal_kas' => 'Id Saldo Awal Kas',
            'no_transaksi' => 'No Transaksi',
            'tanggal_transaksi' => 'Tanggal Transaksi',
            'id_kas_bank' => 'Kas/Bank',
            'jumlah' => 'Jumlah',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getkas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }
}
