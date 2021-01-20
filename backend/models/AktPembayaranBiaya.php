<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_pembayaran_biaya".
 *
 * @property int $id_pembayaran_biaya
 * @property string $tanggal_pembayaran_biaya
 * @property int $id_pembelian
 * @property int $cara_bayar
 * @property int $id_kas_bank
 * @property int $nominal
 * @property string $keterangan
 */
class AktPembayaranBiaya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembayaran_biaya';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_pembayaran_biaya', 'id_pembelian', 'cara_bayar', 'id_kas_bank', 'nominal'], 'required'],
            [['tanggal_pembayaran_biaya'], 'safe'],
            [['id_pembelian', 'cara_bayar', 'id_kas_bank'], 'integer'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembayaran_biaya' => 'Id Pembayaran Biaya',
            'tanggal_pembayaran_biaya' => 'Tanggal Pembayaran Biaya',
            'id_pembelian' => 'Id Pembelian',
            'cara_bayar' => 'Cara Bayar',
            'id_kas_bank' => 'Kas Bank',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
        ];
    }

    public static function setJurnalUmum($model, $model_nominal, $jurnal_transaksi, $jurnal_umum, $akt_pembelian, $cek_kas){


        foreach ($jurnal_transaksi as $jurnal) {
            $jurnal_umum_detail = new AktJurnalUmumDetail();
            $akun = AktAkun::findOne($jurnal->id_akun);
            $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail->id_akun = $jurnal->id_akun;
            if ($jurnal->id_akun == 64 && $jurnal->tipe == 'D') {
                $jurnal_umum_detail->debit = $model_nominal;
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                }
            } else if ($jurnal->id_akun == 64 && $jurnal->tipe == 'K') {
                $jurnal_umum_detail->kredit = $model_nominal;
                if ($akun->saldo_normal == 1) {

                    $akun->saldo_akun = $akun->saldo_akun - $model_nominal;
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $model_nominal;
                }
            } else if (strtolower($akun->nama_akun) == 'kas' && $jurnal->tipe == 'D') {
                $jurnal_umum_detail->debit = $model_nominal;
                if ($akun->saldo_normal == 1) {
                    $cek_kas->saldo = $cek_kas->saldo + $model_nominal;
                } else {
                    $cek_kas->saldo = $cek_kas->saldo - $model_nominal;
                }
            } else if (strtolower($akun->nama_akun) == 'kas' && $jurnal->tipe == 'K') {
                $jurnal_umum_detail->kredit = $model_nominal;
                if ($akun->saldo_normal == 1) {
                    $cek_kas->saldo = $cek_kas->saldo - $model_nominal;
                } else {
                    $cek_kas->saldo = $cek_kas->saldo + $model_nominal;
                }
            }
            $jurnal_umum_detail->keterangan = 'Pembayaran Biaya : ' . $akt_pembelian->no_pembelian;
            $akun->save(false);
            $cek_kas->save(false);
            $jurnal_umum_detail->save(false);

            if (strtolower($akun->nama_akun) == 'kas') {
                $history_transaksi3 = new AktHistoryTransaksi();
                $history_transaksi3->nama_tabel = 'akt_kas_bank';
                $history_transaksi3->id_tabel = $model->id_kas_bank;
                $history_transaksi3->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                $history_transaksi3->save(false);
            }
        }
    }
}
