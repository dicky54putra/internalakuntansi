<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pengajuan_biaya".
 *
 * @property int $id_pengajuan_biaya
 * @property string $nomor_pengajuan_biaya
 * @property string $tanggal_pengajuan
 * @property string $nomor_purchasing_order
 * @property string $nomor_kendaraan
 * @property string $volume
 * @property string $keterangan_pengajuan
 * @property int $dibuat_oleh
 * @property string $jenis_bayar
 * @property string $dibayar_oleh
 * @property string $dibayar_kepada
 * @property string $alamat_dibayar_kepada
 * @property int $approver1
 * @property int $approver2
 * @property int $approver3
 * @property string $approver1_date
 * @property string $approver2_date
 * @property string $approver3_date
 * @property int $status
 * @property string $alasan_reject
 * @property string $tanggal_jatuh_tempo
 * @property int $sumber_dana
 * @property int $status_pembayaran
 */
class AktPengajuanBiaya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pengajuan_biaya';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_pengajuan_biaya', 'tanggal_pengajuan', 'volume', 'dibuat_oleh', 'jenis_bayar', 'dibayar_oleh', 'dibayar_kepada','status', 'sumber_dana', 'status_pembayaran'], 'required'],
            [['tanggal_pengajuan', 'approver1_date', 'approver2_date', 'approver3_date', 'tanggal_jatuh_tempo'], 'safe'],
            [['keterangan_pengajuan', 'alamat_dibayar_kepada', 'alasan_reject'], 'string'],
            [['dibuat_oleh', 'approver1', 'approver2', 'approver3', 'status', 'sumber_dana', 'status_pembayaran'], 'integer'],
            [['nomor_pengajuan_biaya', 'nomor_purchasing_order', 'nomor_kendaraan', 'volume', 'jenis_bayar', 'dibayar_oleh', 'dibayar_kepada'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pengajuan_biaya' => 'Id Pengajuan Biaya',
            'nomor_pengajuan_biaya' => 'Nomor Pengajuan Biaya',
            'tanggal_pengajuan' => 'Tanggal Pengajuan',
            'nomor_purchasing_order' => 'Nomor Purchasing Order',
            'nomor_kendaraan' => 'Nomor Kendaraan',
            'volume' => 'Volume',
            'keterangan_pengajuan' => 'Keterangan Pengajuan',
            'dibuat_oleh' => 'Dibuat Oleh',
            'jenis_bayar' => 'Jenis Bayar',
            'dibayar_oleh' => 'Dibayar Oleh',
            'dibayar_kepada' => 'Dibayar Kepada',
            'alamat_dibayar_kepada' => 'Alamat Dibayar Kepada',
            'approver1' => 'Approver1',
            'approver2' => 'Approver2',
            'approver3' => 'Approver3',
            'approver1_date' => 'Approver1 Date',
            'approver2_date' => 'Approver2 Date',
            'approver3_date' => 'Approver3 Date',
            'status' => 'Status',
            'alasan_reject' => 'Alasan Reject',
            'tanggal_jatuh_tempo' => 'Tanggal Jatuh Tempo',
            'sumber_dana' => 'Sumber Dana',
            'status_pembayaran' => 'Status Pembayaran',
        ];
    }

    public function getlogin()
    {
        return $this->hasOne(Login::className(), ['id_login' => 'dibuat_oleh']);
    }
}
