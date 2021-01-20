<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_penjualan_harta_tetap".
 *
 * @property int $id_penjualan_harta_tetap
 * @property string $no_penjualan_harta_tetap
 * @property string $tanggal_penjualan_harta_tetap
 * @property int $id_customer
 * @property int $id_sales
 * @property int $id_mata_uang
 * @property int $the_approver
 * @property string $the_approver_date
 * @property string $no_faktur_penjualan_harta_tetap
 * @property string $tanggal_faktur_penjualan_harta_tetap
 * @property int $ongkir
 * @property int $pajak
 * @property int $uang_muka
 * @property int $id_kas_bank
 * @property int $total
 * @property int $diskon
 * @property int $jenis_bayar
 * @property int $jumlah_tempo
 * @property string $tanggal_tempo
 * @property int $materai
 * @property int $status
 */
class AktPenjualanHartaTetap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penjualan_harta_tetap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_penjualan_harta_tetap', 'tanggal_penjualan_harta_tetap', 'id_customer', 'id_mata_uang', 'status'], 'required'],
            [['tanggal_penjualan_harta_tetap', 'the_approver_date', 'tanggal_faktur_penjualan_harta_tetap', 'tanggal_tempo', 'total', 'diskon'], 'safe'],
            [['id_customer', 'id_sales', 'id_mata_uang', 'the_approver', 'pajak', 'id_kas_bank', 'jenis_bayar', 'jumlah_tempo', 'status'], 'integer'],
            [['no_penjualan_harta_tetap', 'no_faktur_penjualan_harta_tetap'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_harta_tetap' => 'Id Penjualan Harta Tetap',
            'no_penjualan_harta_tetap' => 'No Penjualan Harta Tetap',
            'tanggal_penjualan_harta_tetap' => 'Tanggal Penjualan Harta Tetap',
            'id_customer' => 'Customer',
            'id_sales' => 'Sales',
            'id_mata_uang' => 'Mata Uang',
            'the_approver' => 'The Approver',
            'the_approver_date' => 'The Approver Date',
            'no_faktur_penjualan_harta_tetap' => 'No Faktur Penjualan Harta Tetap',
            'tanggal_faktur_penjualan_harta_tetap' => 'Tanggal Faktur Penjualan Harta Tetap',
            'ongkir' => 'Ongkir',
            'pajak' => 'Pajak',
            'uang_muka' => 'Uang Muka',
            'id_kas_bank' => 'Kas Bank',
            'total' => 'Total',
            'diskon' => 'Diskon %',
            'jenis_bayar' => 'Jenis Bayar',
            'jumlah_tempo' => 'Jumlah Tempo',
            'tanggal_tempo' => 'Tanggal Tempo',
            'materai' => 'Materai',
            'status' => 'Status',
        ];
    }

    public function getcustomer()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_customer']);
    }

    public function getsales()
    {
        return $this->hasOne(AktSales::className(), ['id_sales' => 'id_sales']);
    }

    public function getmata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getapprover()
    {
        return $this->hasOne(Login::className(), ['id_login' => 'the_approver']);
    }

    public function getkas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }

    public static function dataMataUang($model)
    {

        $data_mata_uang = ArrayHelper::map(
            AktMataUang::find()
                ->where(["=", 'status_default', 1])
                ->all(),
            'id_mata_uang',
            function ($model) {
                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
            }
        );

        return $data_mata_uang;
    }

    public static function dataCustomer($model)
    {
        $data_customer = ArrayHelper::map(
            AktMitraBisnis::find()
                ->where(["!=", 'tipe_mitra_bisnis', 2])
                ->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
            }
        );

        return $data_customer;
    }

    public static function dataKasBank($model)
    {
        $data_kas_bank = ArrayHelper::map(
            AktKasBank::find()
                ->where(["=", 'status_aktif', 1])
                ->all(),
            'id_kas_bank',
            function ($model) {
                return $model['kode_kas_bank'] . ' - ' . $model['keterangan'] . ' : ' . ribuan($model['saldo']);
            }
        );

        return $data_kas_bank;
    }

    public static function dataSales($model)
    {
        $data_sales = ArrayHelper::map(
            AktSales::find()
                ->where(["=", 'status_aktif', 1])
                ->all(),
            'id_sales',
            function ($model) {
                return $model['kode_sales'] . ' - ' . $model['nama_sales'];
            }
        );

        return $data_sales;
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

            AktPenjualanHartaTetap::setfilterNamaAkun($akun, 'aset tetap', $jurnal_umum_detail, $data_jurnal_umum['penjualan_barang'], $jt);
            AktPenjualanHartaTetap::setfilterNamaAkun($akun, 'piutang usaha', $jurnal_umum_detail, $data_jurnal_umum['grand_total'], $jt);
            AktPenjualanHartaTetap::setfilterNamaAkun($akun, 'ppn keluaran', $jurnal_umum_detail, $data_jurnal_umum['pajak'], $jt);
            AktPenjualanHartaTetap::setfilterNamaAkun($akun, 'hutang pengiriman', $jurnal_umum_detail, $data_jurnal_umum['ongkir'], $jt);
            AktPenjualanHartaTetap::setfilterNamaAkun($akun, 'biaya admin kantor', $jurnal_umum_detail, $data_jurnal_umum['materai'], $jt);
            AktPenjualanHartaTetap::setfilterNamaAkun($akun, 'uang muka penjualan', $jurnal_umum_detail, $data_jurnal_umum['uang_muka'], $jt);

            if ($model->id_kas_bank != null) {
                $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                if ($akun->nama_akun == 'kas' && $jt->tipe == 'D') {
                    $jurnal_umum_detail->debit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                    }
                } else if ($akun->nama_akun == 'kas' && $jt->tipe == 'K') {
                    $jurnal_umum_detail->kredit = $model->uang_muka;
                    if ($akun->saldo_normal == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->uang_muka;
                    } else {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->uang_muka;
                    }
                }
                $akt_kas_bank->save(false);
            }
            $akun->save(false);
            $jurnal_umum_detail->keterangan = 'Penjualan Harta Tetap : ' .  $model->no_penjualan_harta_tetap;
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
