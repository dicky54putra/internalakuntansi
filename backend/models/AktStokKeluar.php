<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_stok_keluar".
 *
 * @property int $id_stok_keluar
 * @property string $nomor_transaksi
 * @property string $tanggal_keluar
 * @property int $tipe
 * @property int $metode
 * @property int $id_akun_persediaan
 * @property string $keterangan
 */
class AktStokKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_stok_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_transaksi', 'tanggal_keluar', 'tipe'], 'required'],
            [['tanggal_keluar'], 'safe'],
            [['tipe'], 'integer'],
            [['keterangan'], 'string'],
            [['nomor_transaksi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_keluar' => 'Id Stok Keluar',
            'nomor_transaksi' => 'Nomor Transaksi',
            'tanggal_keluar' => 'Tanggal Keluar',
            'tipe' => 'Tipe',
            'keterangan' => 'Keterangan',
        ];
    }


    public static function getJurnalUmum($id = null)
    {

        if ($id == null) {
            $jurnal_umum = AktJurnalUmum::find()
                ->select(["no_jurnal_umum"])
                ->orderBy("id_jurnal_umum DESC")
                ->limit(1)
                ->one();
        } elseif ($id != null) {

            $jurnal_umum = AktJurnalUmum::find()
                ->where(['id_jurnal_umum' => $id])
                ->one();
        }

        return $jurnal_umum;
    }

    public static function getJurnalTransaksi()
    {

        $stok_keluar = JurnalTransaksi::find()
            ->where(['nama_transaksi' => 'Stok Keluar'])
            ->one();

        $jurnal_transaksi_detail = JurnalTransaksiDetail::find()
            ->where(['id_jurnal_transaksi' => $stok_keluar['id_jurnal_transaksi']])
            ->all();

        return $jurnal_transaksi_detail;
    }

    public static function getHistoryTransaksi($id)
    {

        $akt_history_transaksi = AktHistoryTransaksi::find()
            ->where(['id_tabel' => $id])
            ->andWhere(['nama_tabel' => 'akt_stok_keluar'])
            ->one();

        return $akt_history_transaksi;
    }

    public static function getJurnalUmumDetail($id)
    {

        $jurnal_umum_detail = AktJurnalUmumDetail::find()
            ->where(['id_jurnal_umum' => $id])
            ->all();

        return $jurnal_umum_detail;
    }
}
