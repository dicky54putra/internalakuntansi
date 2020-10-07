<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_mitra_bisnis_pembelian_penjualan".
 *
 * @property int $id_mitra_bisnis_pembelian_penjualan
 * @property int $id_mitra_bisnis
 * @property int $id_mata_uang
 * @property int $termin_pembelian
 * @property int $tempo_pembelian
 * @property int $termin_penjualan
 * @property int $tempo_penjualan
 * @property string $batas_hutang
 * @property string $batas_frekuensi_hutang
 * @property int $id_akun_hutang
 * @property string $batas_piutang
 * @property string $batas_frekuensi_piutang
 * @property int $id_akun_piutang
 */
class AktMitraBisnisPembelianPenjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_mitra_bisnis_pembelian_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis', 'id_mata_uang', 'termin_pembelian', 'tempo_pembelian', 'termin_penjualan', 'tempo_penjualan', 'batas_hutang', 'batas_frekuensi_hutang', 'id_akun_hutang', 'batas_piutang', 'batas_frekuensi_piutang', 'id_akun_piutang'], 'required'],
            [['id_mitra_bisnis', 'id_mata_uang', 'termin_pembelian', 'tempo_pembelian', 'termin_penjualan', 'tempo_penjualan', 'id_akun_hutang', 'id_akun_piutang'], 'integer'],
            [['batas_hutang', 'batas_frekuensi_hutang', 'batas_piutang', 'batas_frekuensi_piutang'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mitra_bisnis_pembelian_penjualan' => 'Id Mitra Bisnis Pembelian Penjualan',
            'id_mitra_bisnis' => 'Id Mitra Bisnis',
            'id_mata_uang' => 'Mata Uang',
            'termin_pembelian' => 'Termin Pembelian',
            'tempo_pembelian' => 'Tempo Pembelian',
            'termin_penjualan' => 'Termin Penjualan',
            'tempo_penjualan' => 'Tempo Penjualan',
            'batas_hutang' => 'Batas Hutang',
            'batas_frekuensi_hutang' => 'Batas Frekuensi Hutang',
            'id_akun_hutang' => 'Akun Hutang',
            'batas_piutang' => 'Batas Piutang',
            'batas_frekuensi_piutang' => 'Batas Frekuensi Piutang',
            'id_akun_piutang' => 'Akun Piutang',
        ];
    }
}
