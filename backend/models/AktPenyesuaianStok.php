<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_penyesuaian_stok".
 *
 * @property int $id_penyesuaian_stok
 * @property string $no_transaksi
 * @property string $tanggal_penyesuaian
 * @property int $tipe_penyesuaian
 * @property int $metode
 * @property int $id_akun_persediaan
 * @property string $keterangan_penyesuaian
 */
class AktPenyesuaianStok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penyesuaian_stok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transaksi', 'tanggal_penyesuaian', 'tipe_penyesuaian'], 'required'],
            [['tanggal_penyesuaian'], 'safe'],
            [['tipe_penyesuaian'], 'integer'],
            [['keterangan_penyesuaian'], 'string'],
            [['no_transaksi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penyesuaian_stok' => 'Id Penyesuaian Stok',
            'no_transaksi' => 'No Transaksi',
            'tanggal_penyesuaian' => 'Tanggal',
            'tipe_penyesuaian' => 'Tipe',
            'keterangan_penyesuaian' => 'Keterangan',
        ];
    }

    public function getJurnalUmum($id = null)
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

    public static function getHistoryTransaksi($id)
    {

        $akt_history_transaksi = AktHistoryTransaksi::find()
            ->where(['id_tabel' => $id])
            ->andWhere(['nama_tabel' => 'akt_penyesuaian_stok'])
            ->one();

        return $akt_history_transaksi;
    }

    public function getJurnalTransaksi()
    {

        $penyesuaian_stok = JurnalTransaksi::find()
            ->where(['nama_transaksi' => 'Penyesuaian Stok'])
            ->one();

        $jurnal_transaksi_detail = JurnalTransaksiDetail::find()
            ->where(['id_jurnal_transaksi' => $penyesuaian_stok['id_jurnal_transaksi']])
            ->all();

        return $jurnal_transaksi_detail;
    }

    public static function getJurnalUmumDetail($id_akun, $id_jurnal_umum = null)
    {

        if ($id_jurnal_umum != null) {
            $jurnal_umum_detail = AktJurnalUmumDetail::find()
                ->where(['id_akun' => $id_akun])
                ->andWhere(['id_jurnal_umum' => $id_jurnal_umum])
                ->one();
        } else if ($id_jurnal_umum == null) {
            $jurnal_umum_detail = AktJurnalUmumDetail::find()
                ->where(['id_jurnal_umum' => $id_jurnal_umum])
                ->all();
        }

        return $jurnal_umum_detail;
    }
}
