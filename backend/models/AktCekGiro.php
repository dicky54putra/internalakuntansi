<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_cek_giro".
 *
 * @property int $id_cek_giro
 * @property string $no_transaksi
 * @property string $no_cek_giro
 * @property string $tanggal_terbit
 * @property int $tanggal_effektif
 * @property int $tipe
 * @property int $in_out
 * @property int $id_bank_asal
 * @property int $id_mata_uang
 * @property double $jumlah
 * @property string $cabang_bank
 * @property string $tanggal_kliring
 * @property string $bank_kliring
 * @property int $id_penerbit
 * @property int $id_penerima
 */
class AktCekGiro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_cek_giro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transaksi', 'no_cek_giro', 'tanggal_terbit', 'tanggal_effektif', 'tipe', 'in_out', 'id_bank_asal', 'id_mata_uang', 'jumlah', 'cabang_bank', 'tanggal_kliring', 'bank_kliring', 'id_penerbit'], 'required'],
            [['tanggal_terbit','tanggal_effektif',  'tanggal_kliring'], 'safe'],
            [['tipe', 'in_out', 'id_bank_asal', 'id_mata_uang', 'id_penerbit', 'id_penerima'], 'integer'],
            [['jumlah'], 'number'],
            [['no_transaksi', 'no_cek_giro'], 'string', 'max' => 11],
            [['cabang_bank', 'bank_kliring'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cek_giro' => 'Id Cek Giro',
            'no_transaksi' => 'No Transaksi',
            'no_cek_giro' => 'No Cek Giro',
            'tanggal_terbit' => 'Tanggal Terbit',
            'tanggal_effektif' => 'Tanggal Effektif',
            'tipe' => 'Tipe',
            'in_out' => 'In/Out',
            'id_bank_asal' => 'Bank Asal',
            'id_mata_uang' => 'Mata Uang',
            'jumlah' => 'Jumlah',
            'cabang_bank' => 'Cabang Bank',
            'tanggal_kliring' => 'Tanggal Kliring',
            'bank_kliring' => 'Bank Kliring',
            'id_penerbit' => 'Penerbit',
            'id_penerima' => 'Penerima',
        ];
    }
}
