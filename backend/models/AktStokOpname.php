<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_stok_opname".
 *
 * @property int $id_stok_opname
 * @property string $no_transaksi
 * @property string $tanggal_opname
 * @property int $id_pegawai
 * @property int $id_akun_persediaan
 */
class AktStokOpname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_stok_opname';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transaksi', 'tanggal_opname'], 'required'],
            [['tanggal_opname', 'keterangan'], 'safe'],
            [['no_transaksi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_opname' => 'Id Stok Opname',
            'no_transaksi' => 'No Transaksi',
            'tanggal_opname' => 'Tanggal Opname',
            'Keterangan' => 'Keterangan',
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

        $stok_opname = JurnalTransaksi::find()
            ->where(['nama_transaksi' => 'Stok Opname'])
            ->one();

        $jurnal_transaksi_detail = JurnalTransaksiDetail::find()
            ->where(['id_jurnal_transaksi' => $stok_opname['id_jurnal_transaksi']])
            ->all();

        return $jurnal_transaksi_detail;
    }

    public static function getHistoryTransaksi($id)
    {

        $akt_history_transaksi = AktHistoryTransaksi::find()
            ->where(['id_tabel' => $id])
            ->andWhere(['nama_tabel' => 'akt_stok_opname'])
            ->one();

        return $akt_history_transaksi;
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
