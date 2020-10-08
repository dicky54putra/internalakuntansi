<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_saldo_awal_stok".
 *
 * @property int $id_saldo_awal_stok
 * @property string $no_transaksi
 * @property string $tanggal
 * @property int $tipe
 */
class AktSaldoAwalStok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_saldo_awal_stok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transaksi', 'tanggal', 'tipe'], 'required'],
            [['tanggal'], 'safe'],
            [['tipe'], 'integer'],
            [['no_transaksi'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_saldo_awal_stok' => 'Id Saldo Awal Stok',
            'no_transaksi' => 'No Transaksi',
            'tanggal' => 'Tanggal',
            'tipe' => 'Tipe',
        ];
    }
}
