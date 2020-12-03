<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "akt_retur_penjualan".
 *
 * @property int $id_retur_penjualan
 * @property string $no_retur_penjualan
 * @property string $tanggal_retur_penjualan
 * @property int $id_penjualan_pengiriman
 * @property int $status_retur
 */
class AktReturPenjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_retur_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_retur_penjualan', 'tanggal_retur_penjualan', 'id_penjualan', 'status_retur'], 'required'],
            [['tanggal_retur_penjualan'], 'safe'],
            [['id_penjualan', 'status_retur', 'id_kas_bank'], 'integer'],
            [['no_retur_penjualan'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_retur_penjualan' => 'Id Retur Penjualan',
            'no_retur_penjualan' => 'No. Retur',
            'tanggal_retur_penjualan' => 'Tanggal Retur',
            'id_penjualan' => 'No Penjualan',
            'status_retur' => 'Status',
            'id_kas_bank' => 'Kas Bank'
        ];
    }

    public function getpenjualan()
    {
        return $this->hasOne(AktPenjualan::className(), ['id_penjualan' => 'id_penjualan']);
    }
    public static function getJurnalTransaksi($nama_transaksi)
    {
        $jurnal_transaksi = JurnalTransaksi::find()->where(['nama_transaksi' => $nama_transaksi])->one();
        $jurnal_transaksi_detail = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $jurnal_transaksi['id_jurnal_transaksi']])->all();

        return $jurnal_transaksi_detail;
    }

    public function getkas()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }

    public static function getKasBank()
    {
        $model_kas_bank = new AktKasBank();
        $kas_bank =  ArrayHelper::map(
            AktKasBank::find()
                ->all(),
            'id_kas_bank',
            function ($model_kas_bank) {
                return $model_kas_bank->kode_kas_bank . ' - ' . $model_kas_bank->keterangan;
            }
        );

        return $kas_bank;
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
}
