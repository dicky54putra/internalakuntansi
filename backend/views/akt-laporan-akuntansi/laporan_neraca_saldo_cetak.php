<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKlasifikasi;
use backend\models\AktLabaRugi;
use backend\models\AktSaldoAwalAkunDetail;
use yii\helpers\Utils;

?>
<style>
    table,
    td {
        border: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }

    table,
    th {
        border: 1px solid #000000;
        padding: 5px;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        padding: 10px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    th,
    td {
        padding: 5px;
    }
</style>
<div style="page-break-after: always;">
    <h3 class="print">
        <?= 'Laporan Neraca Saldo Sebelum Penyesuaian: ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
    </h3>
    <div class="box">
        <?php
        $sum_nom_penjualan = 0;
        $penjualan = AktLabaRugi::getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, "AND jenis IN (21,26)")->query();
        foreach ($penjualan as $penjualan) {
            $sum_nom_penjualan += $penjualan['nominal'];
        }
        $sum_nom_pembelian = 0;
        // $laba_tahun_berjalan = $sum_nom_penjualan - $sum_nom_pembelian;
        $laba_tahun_berjalan = -1 * abs(AktLabaRugi::getLabaBerjalan($tanggal_awal, $tanggal_akhir));
        // $laba_tahun_berjalan = 0;
        $jenis = AktAkun::find()->where("jenis IN(1,2)")->groupBy('jenis')->all();
        foreach ($jenis as $jen) {
            $data_jenis = array(
                1 => 'Aset Lancar',
                2 => 'Aset Tetap',
            );
            //     3 => 'Aset Tetap Tidak Berwujud',
            //     4 => 'Pendapatan',
            //     // 2 => 'Kewajiban',
            //     5 => 'Liabilitas Jangka Pendek',
            //     6 => 'Liabilitas Jangka Panjang',
            //     // 3 => 'Modal',
            //     7 => 'Ekuitas',
            //     // 5 => 'Pendapatan Lain',
            //     8 => 'Beban',
            //     9 => 'Pengeluaran Lain',
            //     10 => 'Pendapatan Lain',
        ?>

            <table class="table" style="margin-bottom: 20px; margin-top: 20px; background: rgba(0, 0, 0, 0.55); color: white;">
                <tr>
                    <th><?= $data_jenis[$jen->jenis] ?? ''; ?></th>
                    <th style="width: 15%;text-align: right;">Debet</th>
                    <th style="width: 15%;text-align: right;">Kredit</th>
                </tr>
            </table>

            <?php
            $klasifikasi = AktAkun::find()->where("jenis = $jen->jenis")->groupBy('klasifikasi')->all();
            $sum_by_jenis_debet = 0;
            $sum_by_jenis_kredit = 0;
            foreach ($klasifikasi as $klas) {
                $klasname = AktKlasifikasi::find()->where(['id_klasifikasi' => $klas->klasifikasi])->one();
            ?>
                <table class="table" style="margin-top: 20px;">
                    <tr style="background-color: rgba(0,0,0,0.1);">
                        <th><?= $klasname->klasifikasi ?></th>
                    </tr>
                    <tr>
                        <table class="table">
                            <?php
                            $no = 1;
                            $query_akun = AktAkun::find()->where(['jenis' => $jen->jenis, 'klasifikasi' => $klas->klasifikasi])->orderBy("nama_akun")->all();
                            $t_debet = 0;
                            $t_kredit = 0;
                            foreach ($query_akun as $key => $data) {
                                $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();
                                $count_query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                    ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                    ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                    ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                                    ->orderBy("id_jurnal_umum_detail ASC")
                                    ->count();
                                $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0;
                                $saldo_awal = $nilai_saldo_awal_akun;
                                $sum_debit = Yii::$app->db->createCommand("SELECT SUM(debit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                                $sum_kredit = Yii::$app->db->createCommand("SELECT SUM(kredit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                                $saldo_debit = $saldo_awal + $sum_debit;
                                $change_saldo = $saldo_debit - $sum_kredit;
                            ?>
                                <tr>
                                    <td style="width: 5px;"><?= $no++ ?></td>
                                    <td style="width: 20%;"><?= $data['kode_akun'] ?></td>
                                    <td><?= $data['nama_akun'] ?></td>
                                    <td style="text-align: right; width: 15%;">
                                        <?php
                                        if ($data['nama_akun'] == 'Laba Tahun Berjalan') {
                                            if ($laba_tahun_berjalan > 0) {
                                                echo ribuan(abs($laba_tahun_berjalan));
                                                $t_debet += $laba_tahun_berjalan;
                                            }
                                        } else {
                                            if ($count_query_jurnal_umum_detail == 0) {
                                                if ($data['saldo_normal'] == 1) {
                                                    echo ribuan(abs($saldo_awal));
                                                    $t_debet += $saldo_awal;
                                                }
                                            } else {
                                                if ($saldo_debit >= $sum_kredit) {
                                                    echo ribuan(abs($change_saldo));
                                                    $t_debet += $change_saldo;
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: right; width: 15%;">
                                        <?php
                                        if ($data['nama_akun'] == 'Laba Tahun Berjalan') {
                                            if ($laba_tahun_berjalan < 0) {
                                                echo ribuan(abs($laba_tahun_berjalan));
                                                $t_kredit += $laba_tahun_berjalan;
                                            }
                                        } else {
                                            if ($count_query_jurnal_umum_detail == 0) {
                                                if ($data['saldo_normal'] == 2) {
                                                    echo ribuan(abs($saldo_awal));
                                                    $t_kredit += $saldo_awal;
                                                }
                                            } else {
                                                if ($saldo_debit <= $sum_kredit) {
                                                    echo ribuan(abs($change_saldo));
                                                    $t_kredit += $change_saldo;
                                                }
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td align="left" colspan="3" style="background-color: rgba(0,0,0,0.05);">Total <?= $klasname->klasifikasi ?></td>
                                <td align="right" style="background-color: rgba(0,0,0,0.05);text-align: right;">
                                    <?php
                                    echo ribuan(abs($t_debet));
                                    $sum_by_jenis_debet += $t_debet;
                                    ?>
                                </td>
                                <td align=" right" style="background-color: rgba(0,0,0,0.05);text-align: right;">
                                    <?php
                                    echo ribuan(abs($t_kredit));
                                    $sum_by_jenis_kredit += $t_kredit;
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </tr>
                </table>
            <?php } ?>
            <table class=" table" style="margin-top: 20px;margin-bottom: 20px;">
                <tr style="background-color: rgba(0,0,0,0.1);">
                    <th>Total <?= $data_jenis[$jen->jenis] ?? ''; ?></th>
                    <th style="width: 15%; text-align: right;"><?= ribuan(abs($sum_by_jenis_debet)) ?></th>
                    <th style="width: 15%; text-align: right;"><?= ribuan(abs($sum_by_jenis_kredit)) ?></th>
                </tr>
            </table>

        <?php } ?>
        <?php
        $akun_aktiva = AktAkun::find()->where("jenis in(1,2)")->all();
        $a_ak = '';
        foreach ($akun_aktiva as $aa) {
            $a_ak .= $aa->id_akun . ',';
        }
        $aktiva = substr($a_ak, 0, -1);

        $akun_pasiva = AktAkun::find()->where("jenis in(5,6,7)")->all();
        $a_ps = '';
        foreach ($akun_pasiva as $aa) {
            $a_ps .= $aa->id_akun . ',';
        }
        $pasiva = substr($a_ps, 0, -1);

        $sum_aktiva_kredit1 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $aktiva, '1', 'kredit');
        $sum_aktiva_debit1 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $aktiva, '1', 'debit');
        $sum_aktiva_kredit2 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $aktiva, '2', 'kredit');
        $sum_aktiva_debit2 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $aktiva, '2', 'debit');

        $sum_pasiva_kredit1 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $pasiva, '1', 'kredit');
        $sum_pasiva_debit1 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $pasiva, '1', 'debit');
        $sum_pasiva_kredit2 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $pasiva, '2', 'kredit');
        $sum_pasiva_debit2 = Utils::getSumAktivaPasiva($tanggal_awal, $tanggal_akhir, $pasiva, '2', 'debit');

        $total_sum_aktiva1 = $sum_aktiva_debit1 - $sum_aktiva_kredit1;
        // $total_sum_aktiva1 = $sum_aktiva_debit1;
        $total_sum_aktiva2 = $sum_aktiva_debit2 - $sum_aktiva_kredit2;
        $total_sum_pasiva1 = $sum_pasiva_kredit1 - $sum_pasiva_debit1;
        $total_sum_pasiva2 = $sum_pasiva_kredit2 - $sum_pasiva_debit2;
        // $total_sum_pasiva2 = $sum_pasiva_kredit2;
        ?>

        <table class="table" style="margin-bottom: 20px; border-bottom: solid 1px #fff; background: rgba(0,0,0,0.8); color: white;">
            <tr>
                <th>Total Aktiva</th>
                <th style="width: 15%;text-align: right;"><?= ribuan(abs($total_sum_aktiva1)) ?></th>
                <th style="width: 15%;text-align: right;"><?= ribuan(abs($total_sum_aktiva2)) ?></th>
            </tr>
        </table>
    </div>
</div>


<?php
$jenis = AktAkun::find()->where("jenis IN(5,6,7)")->groupBy('jenis')->all();
foreach ($jenis as $jen) {
    $data_jenis = array(
        5 => 'Liabilitas Jangka Pendek',
        6 => 'Liabilitas Jangka Panjang',
        7 => 'Ekuitas',
    );
?>

    <table class="table" style="margin-bottom: 20px;margin-top: 20px;background: rgba(0, 0, 0, 0.55); color: white;">
        <tr>
            <th><?= $data_jenis[$jen->jenis] ?? ''; ?></th>
            <th style="width: 15%;text-align: right;">Debet</th>
            <th style="width: 15%;text-align: right;">Kredit</th>
        </tr>
    </table>

    <?php
    $klasifikasi = AktAkun::find()->where("jenis = $jen->jenis")->groupBy('klasifikasi')->all();
    $sum_by_jenis_debet = 0;
    $sum_by_jenis_kredit = 0;
    foreach ($klasifikasi as $klas) {
        $klasname = AktKlasifikasi::find()->where(['id_klasifikasi' => $klas->klasifikasi])->one();
    ?>
        <table class="table" style="margin-top: 20px;">
            <tr style="background-color: rgba(0,0,0,0.1);">
                <th><?= $klasname->klasifikasi ?></th>
            </tr>
            <tr>
                <table class="table">
                    <?php
                    $no = 1;
                    $query_akun = AktAkun::find()->where(['jenis' => $jen->jenis, 'klasifikasi' => $klas->klasifikasi])->orderBy("nama_akun")->all();
                    $t_debet = 0;
                    $t_kredit = 0;
                    foreach ($query_akun as $key => $data) {
                        $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();
                        $count_query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                            ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                            ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                            ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                            ->orderBy("id_jurnal_umum_detail ASC")
                            ->count();
                        $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0;
                        $saldo_awal = $nilai_saldo_awal_akun;
                        $sum_debit = Yii::$app->db->createCommand("SELECT SUM(debit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                        $sum_kredit = Yii::$app->db->createCommand("SELECT SUM(kredit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                        $saldo_debit = $saldo_awal + $sum_debit;
                        $change_saldo = $saldo_debit - $sum_kredit;
                    ?>
                        <tr>
                            <td style="width: 5px;"><?= $no++ ?></td>
                            <td style="width: 20%;"><?= $data['kode_akun'] ?></td>
                            <td><?= $data['nama_akun'] ?></td>
                            <td style="text-align: right; width: 15%;">
                                <?php
                                if ($data['nama_akun'] == 'Laba Tahun Berjalan') {
                                    if ($laba_tahun_berjalan > 0) {
                                        echo ribuan(abs($laba_tahun_berjalan));
                                        $t_debet += $laba_tahun_berjalan;
                                    }
                                } else {
                                    if ($count_query_jurnal_umum_detail == 0) {
                                        if ($data['saldo_normal'] == 1) {
                                            echo ribuan(abs($saldo_awal));
                                            $t_debet += $saldo_awal;
                                        }
                                    } else {
                                        if ($saldo_debit >= $sum_kredit) {
                                            echo ribuan(abs($change_saldo));
                                            $t_debet += $change_saldo;
                                        }
                                    }
                                }
                                ?>
                            </td>
                            <td style="text-align: right; width: 15%;">
                                <?php
                                if ($data['nama_akun'] == 'Laba Tahun Berjalan') {
                                    if ($laba_tahun_berjalan < 0) {
                                        echo ribuan(abs($laba_tahun_berjalan));
                                        $t_kredit += $laba_tahun_berjalan;
                                    }
                                } else {
                                    if ($count_query_jurnal_umum_detail == 0) {
                                        if ($data['saldo_normal'] == 2) {
                                            echo ribuan(abs($saldo_awal));
                                            $t_kredit += $saldo_awal;
                                        }
                                    } else {
                                        if ($saldo_debit <= $sum_kredit) {
                                            echo ribuan(abs($change_saldo));
                                            $t_kredit += $change_saldo;
                                        }
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td align="left" colspan="3" style="background-color: rgba(0,0,0,0.05);">Total <?= $klasname->klasifikasi ?></td>
                        <td align="right" style="background-color: rgba(0,0,0,0.05);text-align: right;">
                            <?php
                            echo ribuan(abs($t_debet));
                            $sum_by_jenis_debet += $t_debet;
                            ?>
                        </td>
                        <td align="right" style="background-color: rgba(0,0,0,0.05);text-align: right;">
                            <?php
                            echo ribuan(abs($t_kredit));
                            $sum_by_jenis_kredit += $t_kredit;
                            ?>
                        </td>
                    </tr>
                </table>
            </tr>
        </table>
    <?php } ?>
    <table class="table" style="margin-top: 20px;">
        <tr style="background-color: rgba(0,0,0,0.1);">
            <th>Total <?= $data_jenis[$jen->jenis] ?? ''; ?></th>
            <th style="width: 15%; text-align: right;"><?= ribuan(abs($sum_by_jenis_debet)) ?></th>
            <th style="width: 15%; text-align: right;"><?= ribuan(abs($sum_by_jenis_kredit)) ?></th>
        </tr>
    </table>
<?php } ?>


<table class="table" style="margin-bottom: 20px; margin-top: 20px; border-bottom: solid 1px #fff; background: rgba(0,0,0,0.8);color: white;">
    <tr>
        <?php
        if ($laba_tahun_berjalan > 0) {
            $laba_tahun_pasiva1 = $laba_tahun_berjalan;
            $laba_tahun_pasiva2 = 0;
        } else {
            $laba_tahun_pasiva1 = 0;
            $laba_tahun_pasiva2 = abs($laba_tahun_berjalan);
        }

        ?>
        <th>Total Pasiva</th>
        <th style="width: 15%;text-align: right;"><?= ribuan(abs($total_sum_pasiva1 + $laba_tahun_pasiva1)) ?></th>
        <th style="width: 15%;text-align: right;"><?= ribuan(abs($total_sum_pasiva2 + $laba_tahun_pasiva2)) ?></th>
    </tr>
</table>

<script>
    window.print();
    setTimeout(window.close, 500);
</script>