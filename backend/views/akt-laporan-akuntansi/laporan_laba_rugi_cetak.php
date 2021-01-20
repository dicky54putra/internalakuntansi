<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKlasifikasi;
use backend\models\AktLabaRugi;
use backend\models\Setting;

$this->title = 'Laporan Laba Rugi';
?>
<style>
    .tabel {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .tabel th,
    .tabel td {
        padding: 2px;
        text-align: left;
        font-size: 12px;
    }

    .table td {
        border-bottom: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }

    .table th {
        text-align: left;
        padding: 5px;
    }

    .table thead {
        border-bottom: 1px solid #000000;
        padding: 5px;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .table th,
    .table td {
        padding: 5px;
    }
</style>
<?php
if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    # code...
?>
    <center>
        <table style="width: 80%; border-top: 2px solid black;border-left: 2px solid black;border-right: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <td colspan="4" align="center">
                    <p class="table" style="font-size: 20px; font-weight: bold;">
                        LAPORAN LABA RUGI
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="table" style="font-size: 20px;">
                        <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
                    </p>
                </td>
                <td colspan="2" align="right">
                    <p class="table" style="font-size: 20px;">
                        <?php
                        $nama = Setting::find()->one();
                        echo $nama->nama;
                        ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="center">
                    <br>
                    <hr>
                </td>
            </tr>
            <?php
            // array no urut 
            $nomer_urut = AktLabaRugi::arrayPembagian();

            foreach ($nomer_urut as $nomer_urut) {
                $in = AktLabaRugi::getAkunLaporanDetail($nomer_urut['no_urut']);
                // query laba rugi
                $q_laba_rugi = AktLabaRugi::getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, "AND akt_akun.id_akun IN($in) AND akt_akun_laporan.id_akun_laporan = 11")->query();
                $sum = 0;
                foreach ($q_laba_rugi as $val) {
            ?>
                    <tr>
                        <td><?= ($val['nama_akun'] == 'HPP') ? 'PERSEDIAAN AWAL' : strtoupper($val['nama_akun']); ?></td>
                        <td style="text-align: right;">
                            <?php
                            if ($val['no_urut'] == 2 || $val['no_urut'] == 3) {
                                if ($val['nama_akun'] == 'Persediaan Barang Dagang') {
                                    echo ($val['nominal'] <= 0) ? ribuan($val['nominal']) : '(' . ribuan(abs($val['nominal'])) . ')';
                                } else if ($val['nama_akun'] == 'HPP') {
                                    echo ribuan(0);
                                } else {
                                    echo ($val['nominal'] < 0) ? '(' . ribuan(abs($val['nominal'])) . ')' : ribuan(abs($val['nominal']));
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: right;">
                            <?php
                            if ($val['no_urut'] == 1 || $val['no_urut'] == 4) {
                                echo ($val['nominal'] <= 0) ? ribuan(abs($val['nominal'])) : '(' . ribuan(abs($val['nominal'])) . ')';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    $sum += $val['nominal'];
                    ?>
                <?php } ?>
                <?php
                if ($nomer_urut['no_urut'] == 2 || $nomer_urut['no_urut'] == 3) {
                    $bor = 'border-top: 2px solid black;';
                    $bor2 = 'bottom';
                } else  if ($nomer_urut['no_urut'] == 1 || $nomer_urut['no_urut'] == 4) {
                    $bor = '';
                    $bor2 = 'top';
                }
                $persediaan_barang_dagang = AktLabaRugi::getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, "AND akt_akun.id_akun IN(117) AND akt_akun_laporan.id_akun_laporan = 11")->queryOne();
                $hpp = AktLabaRugi::getQuery4LabaRugi($tanggal_awal, $tanggal_akhir, "AND akt_akun.id_akun IN(114) AND akt_akun_laporan.id_akun_laporan = 11")->queryOne();

                // sum hpp / bagian 2
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
                ?>
                    <tr>
                        <td><b><?= strtoupper('TOTAL ' . $nomer_urut['nama']) ?></b></td>
                        <td style="<?= $bor ?>"></td>
                        <td style="border-<?= $bor2 ?>: 2px solid black; text-align: right; font-weight: bold;">
                            <?php
                            if ($nomer_urut['no_urut'] == 1) {
                                echo ($sum <= 0) ? ribuan(abs($sum_penjualan = $sum)) : '(' . ribuan(abs($sum)) . ')';
                            } else if ($nomer_urut['no_urut'] == 2) {
                                echo ribuan($sum_total);
                            } else if ($nomer_urut['no_urut'] == 3) {
                                echo ribuan($sum);
                            }
                            ?>
                        </td>
                    </tr>
                    <?php if ($nomer_urut['no_urut'] == 2) { ?>
                        <tr>
                            <td><?= strtoupper('laba kotor') ?></td>
                            <td></td>
                            <td style="text-align: right; font-weight: bold;">
                                <?php
                                if (!empty($sum_p) || !empty($sum_b) || !empty($sum_by)) {
                                    $laba_kotor = $sum_p - $sum_b;
                                    echo ($laba_kotor < 0) ? '(' . ribuan(abs($laba_kotor)) . ')' : ribuan($laba_kotor);
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } else if ($nomer_urut['no_urut'] == 3) { ?>
                        <tr>
                            <td><?= strtoupper('laba bersih') ?></td>
                            <td></td>
                            <td style="text-align: right;">
                                <?php
                                if (!empty($sum_p) || !empty($sum_b) || !empty($sum_by)) {
                                    $laba_bersih1 = $sum_p - $sum_b - $sum_by;
                                    echo ($laba_bersih1 < 0) ? '(' . ribuan(abs($laba_bersih1)) . ')' : ribuan($laba_bersih1);
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php if ($nomer_urut['no_urut'] == 4) {  ?>
                    <tr>
                        <td><b><?= strtoupper('laba bersih') ?></b></td>
                        <td></td>
                        <td style="border-<?= $bor2 ?>: 2px solid black; text-align: right; font-weight: bold;">
                            <?php
                            if (!empty($sum_p) || !empty($sum_b) || !empty($sum_by) || !empty($sum_bb)) {
                                $laba_bersih = $sum_p - $sum_b - $sum_by + $sum_bb;
                                echo ($laba_bersih < 0) ? '(' . ribuan(abs($laba_bersih)) . ')' : ribuan($laba_bersih);
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($nomer_urut['no_urut'] != 3) { ?>
                    <tr>
                        <td colspan="3"><br></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </center>
<?php } ?>

<script>
    window.print();
    setTimeout(window.close, 500);
</script>