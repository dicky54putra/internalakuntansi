<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_pembelian_harta_tetap".
 *
 * @property int $id_pembelian_harta_tetap
 * @property int $no_pembelian_harta_tetap
 * @property string $tanggal
 * @property int $termin
 * @property int $id_kas_bank
 * @property int $jumlah_hari
 * @property string $tanggal_selesai
 * @property int $id_supplier
 * @property int $id_mata_uang
 * @property int $status_pajak
 * @property string $keterangan
 * @property int $id_cabang
 * @property int $status
 */
class AktPembelianHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_pembelian_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_pembelian_harta_tetap', 'tanggal', 'id_mata_uang', 'id_supplier', 'status', 'jenis_bayar'], 'required'],
            [['termin', 'id_kas_bank', 'jatuh_tempo', 'id_supplier', 'id_mata_uang', 'pajak',  'status', 'id_login',], 'integer'],
            [['tanggal', 'tanggal_tempo', 'uang_muka', 'tanggal_approve', 'ongkir', 'materai', 'diskon'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_harta_tetap' => 'Id Pembelian Harta Tetap',
            'no_pembelian_harta_tetap' => 'No Pembelian Harta Tetap',
            'tanggal' => 'Tanggal',
            'termin' => 'Termin',
            'id_kas_bank' => 'Kas Bank',
            'jatuh_tempo' => 'Jatuh Tempo',
            'tanggal_selesai' => 'Tanggal Selesai',
            'id_supplier' => 'Id Supplier',
            'id_mata_uang' => 'Id Mata Uang',
            'pajak' => 'Pajak',
            'keterangan' => 'Keterangan',
            'id_cabang' => 'Id Cabang',
            'status' => 'Status',
            'materai' => 'Materai',
            'ongkir' => 'Ongkir',
            'jenis_bayar' => 'Jenis Bayar'
        ];
    }

    public function getakt_mata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getakt_cabang()
    {
        return $this->hasOne(AktCabang::className(), ['id_cabang' => 'id_cabang']);
    }

    public function getakt_mitra_bisnis()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_supplier']);
    }

    public function getakt_kas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }

    public static function dataKasBank($model)
    {
        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'] . ' : ' . ribuan($model['saldo']);
            }
        );

        return $data_kas_bank;
    }

    public static function setfilterNamaAkun($model_akun, $nama_akun,  $model_jurnal_umum_detail, $nominal, $jt)
    {

        if (strtolower($model_akun->nama_akun) == strtolower($nama_akun) && $jt->tipe == 'D') {
            $model_jurnal_umum_detail->debit = $nominal;
            if ($model_akun->saldo_normal == 1) {
                $model_akun->saldo_akun = $model_akun->saldo_akun + $nominal;
            } else {
                $model_akun->saldo_akun = $model_akun->saldo_akun - $nominal;
            }
        } else if (strtolower($model_akun->nama_akun) == strtolower($nama_akun) && $jt->tipe == 'K') {
            $model_jurnal_umum_detail->kredit = $nominal;
            if ($model_akun->saldo_normal == 1) {
                $model_akun->saldo_akun = $model_akun->saldo_akun - $nominal;
            } else {
                $model_akun->saldo_akun = $model_akun->saldo_akun + $nominal;
            }
        }
    }


    public static function setAkunJurnalUmum($jurnal_transaksi_detail, $model, $data_jurnal_umum, $jurnal_umum)
    {
        foreach ($jurnal_transaksi_detail as $jt) {

            $jurnal_umum_detail = new AktJurnalUmumDetail();
            $jurnal_umum_detail->id_jurnal_umum = $jurnal_umum->id_jurnal_umum;
            $jurnal_umum_detail->id_akun = $jt->id_akun;
            $akun = AktAkun::find()->where(['id_akun' => $jt->id_akun])->one();

            AktPembelianHartaTetap::setfilterNamaAkun($akun, 'aset tetap', $jurnal_umum_detail, $data_jurnal_umum['pembelian_barang'], $jt);
            AktPembelianHartaTetap::setfilterNamaAkun($akun, 'ppn masukan', $jurnal_umum_detail, $data_jurnal_umum['pajak'], $jt);
            AktPembelianHartaTetap::setfilterNamaAkun($akun, 'piutang pengiriman', $jurnal_umum_detail, $data_jurnal_umum['ongkir'], $jt);
            AktPembelianHartaTetap::setfilterNamaAkun($akun, 'piutang pengiriman', $jurnal_umum_detail, $data_jurnal_umum['ongkir'], $jt);
            AktPembelianHartaTetap::setfilterNamaAkun($akun, 'biaya admin kantor', $jurnal_umum_detail, $data_jurnal_umum['materai'], $jt);
            AktPembelianHartaTetap::setfilterNamaAkun($akun, 'uang muka pembelian', $jurnal_umum_detail, $data_jurnal_umum['uang_muka'], $jt);

            if ($jt->id_akun == 64 && $jt->tipe == 'D') {
                $jurnal_umum_detail->debit = $data_jurnal_umum['grand_total'];
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun + $data_jurnal_umum['grand_total'];
                } else {
                    $akun->saldo_akun = $akun->saldo_akun - $data_jurnal_umum['grand_total'];
                }
            } else if ($jt->id_akun == 64 && $jt->tipe == 'K') {
                $jurnal_umum_detail->kredit = $data_jurnal_umum['grand_total'];
                if ($akun->saldo_normal == 1) {
                    $akun->saldo_akun = $akun->saldo_akun - $data_jurnal_umum['grand_total'];
                } else {
                    $akun->saldo_akun = $akun->saldo_akun + $data_jurnal_umum['grand_total'];
                }
            } else if ($model->id_kas_bank != null) {
                $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                if (strtolower($akun->nama_akun) == 'kas' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $data_jurnal_umum['uang_muka'];
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $data_jurnal_umum['uang_muka'];
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $data_jurnal_umum['uang_muka'];
                    }
                } else if (strtolower($akun->nama_akun) == 'kas' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $data_jurnal_umum['uang_muka'];
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $data_jurnal_umum['uang_muka'];
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $data_jurnal_umum['uang_muka'];
                    }
                }
                $akt_kas_bank->save(false);
            }
            $akun->save(false);
            $jurnal_umum_detail->keterangan = 'Pembelian Harta Tetap : ' .  $model->no_pembelian_harta_tetap;
            $jurnal_umum_detail->save(false);

            if (strtolower($akun->nama_akun) == 'kas') {
                $history_transaksi_kas = new AktHistoryTransaksi();
                $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
                $history_transaksi_kas->id_tabel = $model->id_kas_bank;
                $history_transaksi_kas->id_jurnal_umum = $jurnal_umum_detail->id_jurnal_umum_detail;
                $history_transaksi_kas->save(false);
            }
        }
    }
}
