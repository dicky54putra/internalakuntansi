<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_history_transaksi".
 *
 * @property int $id_history_transaksi
 * @property int $id_tabel
 * @property int $id_jurnal_umum
 * @property int $nama_tabel
 */
class AktHistoryTransaksi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_history_transaksi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tabel', 'id_jurnal_umum', 'nama_tabel'], 'required'],
            [['id_tabel', 'id_jurnal_umum'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_history_transaksi' => 'Id History Transaksi',
            'id_tabel' => 'Id Tabel',
            'id_jurnal_umum' => 'Id Jurnal Umum',
            'nama_tabel' => 'Nama Tabel',
        ];
    }
}
