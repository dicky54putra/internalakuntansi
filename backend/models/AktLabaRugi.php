<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_laba_rugi".
 *
 * @property int $id_laba_rugi
 * @property string $tanggal
 * @property int $periode
 * @property int $id_login
 */
class AktLabaRugi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_laba_rugi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'periode'], 'required'],
            [['tanggal', 'tanggal_approve'], 'safe'],
            [['periode', 'id_login'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_laba_rugi' => 'Id Laba Rugi',
            'tanggal' => 'Tanggal',
            'periode' => 'Periode',
            'id_login' => 'Id Login',
        ];
    }

    public static function getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, $where)
    {
        $penjualan = Yii::$app->db->createCommand("SELECT akt_akun.id_akun as akun_id, akt_akun.nama_akun, akt_akun.kode_akun, akt_akun.saldo_normal,akt_akun_laporan_detail.no_urut,(
            SELECT SUM(debit-kredit) FROM akt_jurnal_umum_detail
            LEFT JOIN akt_akun ON akt_akun.id_akun = akt_jurnal_umum_detail.id_akun
            LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum
            WHERE akt_jurnal_umum_detail.id_akun = akun_id
            AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) as nominal 
        FROM akt_akun 
        LEFT JOIN akt_akun_laporan_detail ON akt_akun.id_akun = akt_akun_laporan_detail.id_akun
        LEFT JOIN akt_akun_laporan ON akt_akun_laporan_detail.id_akun_laporan = akt_akun_laporan.id_akun_laporan
        WHERE 1 
        $where
        HAVING (
            SELECT ABS(SUM(debit-kredit)) FROM akt_jurnal_umum_detail
            LEFT JOIN akt_akun ON akt_akun.id_akun = akt_jurnal_umum_detail.id_akun
            LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum
            WHERE akt_akun.id_akun = akun_id
            AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        ) IS NOT NULL
        ORDER BY akt_akun_laporan_detail.no_urut ASC, akt_akun.nama_akun ASC
        ");

        return $penjualan;
    }

    public static function getQueryByJenis($jenis, $where = NULL)
    {
        return Yii::$app->db->createCommand("SELECT akt_klasifikasi.id_klasifikasi, akt_klasifikasi.klasifikasi, akt_akun.jenis FROM akt_klasifikasi LEFT JOIN akt_akun ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = $jenis $where GROUP BY akt_klasifikasi.klasifikasi ORDER BY akt_klasifikasi.klasifikasi ASC")->query();
    }
    public static function getQueryKlasikasiByJenis($jenis, $klasifikasi, $id_akun)
    {
        return Yii::$app->db->createCommand("SELECT * FROM akt_akun LEFT JOIN akt_klasifikasi ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = $jenis AND akt_klasifikasi.klasifikasi = '$klasifikasi' AND akt_akun.id_akun IN($id_akun)")->query();
    }

    public static function getQuerySumJurnalUmumDetail($id_akun, $tanggal_awal, $tanggal_akhir, $jenis)
    {
        return AktJurnalUmumDetail::find()->leftJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')->where(['id_akun' => $id_akun])->andWhere(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->sum($jenis);
    }

    public static function arrayPembagian()
    {
        return [
            [
                'no_urut' => 1,
                'nama' => 'penjualan'
            ],
            [
                'no_urut' => 2,
                'nama' => 'hpp'
            ],
            [
                'no_urut' => 3,
                'nama' => 'biaya'
            ],
            [
                'no_urut' => 4,
                'nama' => ''
            ],
        ];
    }

    public static function getAkunLaporanDetail($nomer_urut)
    {
        // query laporan akun detail
        $akun_laporan = AktAkunLaporanDetail::find()->where(['id_akun_laporan' => 11, 'no_urut' => $nomer_urut])->all();

        // jadiin coma
        $for_in = '';
        foreach ($akun_laporan as $al) {
            $for_in .= $al->id_akun . ',';
        }
        $in = substr($for_in, 0, -1);
        return $in;
    }

    public static function getLabaBerjalan($tanggal_awal, $tanggal_akhir)
    {
        // array no urut 
        $nomer_urut = AktLabaRugi::arrayPembagian();
        $laba_bersih = 0;
        foreach ($nomer_urut as $nomer_urut) {
            $in = AktLabaRugi::getAkunLaporanDetail($nomer_urut['no_urut']);
            // query laba rugi
            $q_laba_rugi = AktLabaRugi::getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, "AND akt_akun.id_akun IN($in) AND akt_akun_laporan.id_akun_laporan = 11")->query();
            $sum = 0;
            foreach ($q_laba_rugi as $val) {
                if ($val['no_urut'] == 1 || $val['no_urut'] == 4) {
                    ($val['nominal'] <= 0) ? abs($val['nominal']) : '(' . abs($val['nominal']) . ')';
                }
                $sum += $val['nominal'];
            }

            $persediaan_barang_dagang = AktLabaRugi::getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, "AND akt_akun.id_akun IN(117) AND akt_akun_laporan.id_akun_laporan = 11")->queryOne();
            $hpp = AktLabaRugi::getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, "AND akt_akun.id_akun IN(114) AND akt_akun_laporan.id_akun_laporan = 11")->queryOne();

            $sum_total = $sum - ($persediaan_barang_dagang['nominal'] * 2) - $hpp['nominal'];

            if ($nomer_urut['no_urut'] == 1) {
                $sum_p = ($sum <= 0) ? abs($sum_penjualan = $sum) : -1 * abs($sum);
            } else if ($nomer_urut['no_urut'] == 2) {
                $sum_b = $sum_total;
            } else if ($nomer_urut['no_urut'] == 3) {
                $sum_by = $sum;
            } else if ($nomer_urut['no_urut'] == 4) {
                $sum_bb = ($sum <= 0) ? abs($sum_penjualan = $sum) : -1 * abs($sum);
            }

            if ($nomer_urut['no_urut'] != 4) {
                strtoupper('TOTAL ' . $nomer_urut['nama']);
                if ($nomer_urut['no_urut'] == 2) {
                    strtoupper('laba kotor');
                    if (!empty($sum_p) || !empty($sum_b) || !empty($sum_by)) {
                        $laba_kotor = $sum_p - $sum_b;
                    }
                } else if ($nomer_urut['no_urut'] == 3) {
                    strtoupper('laba bersih');

                    if (!empty($sum_p) || !empty($sum_b) || !empty($sum_by)) {
                        $laba_bersih1 = $sum_p - $sum_b - $sum_by;
                    }
                }
            }
            if ($nomer_urut['no_urut'] == 4) {
                strtoupper('laba bersih');
                if (!empty($sum_p) || !empty($sum_b) || !empty($sum_by) || !empty($sum_bb)) {
                    $laba_bersih = $sum_p - $sum_b - $sum_by + $sum_bb;
                }
            }
        }

        return $laba_bersih;
    }
}
