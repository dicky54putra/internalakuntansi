<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jurnal_transaksi".
 *
 * @property int $id_jurnal_transaksi
 * @property string $nama_transaksi
 */
class JurnalTransaksi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jurnal_transaksi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_transaksi'], 'required'],
            [['nama_transaksi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jurnal_transaksi' => 'Id Jurnal Transaksi',
            'nama_transaksi' => 'Nama Transaksi',
        ];
    }
}
