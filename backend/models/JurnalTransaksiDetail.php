<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jurnal_transaksi_detail".
 *
 * @property int $id_jurnal_transaksi_detail
 * @property int $id_jurnal_transaksi
 * @property string $tipe
 * @property int $id_akun
 */
class JurnalTransaksiDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jurnal_transaksi_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jurnal_transaksi', 'tipe', 'id_akun'], 'required'],
            [['id_jurnal_transaksi', 'id_akun'], 'integer'],
            [['tipe'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jurnal_transaksi_detail' => 'Id Jurnal Transaksi Detail',
            'id_jurnal_transaksi' => 'Id Jurnal Transaksi',
            'tipe' => 'Tipe',
            'id_akun' => 'Id Akun',
        ];
    }
}
