<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktAkunLaporan;
use backend\models\AktAkunLaporanDetail;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKlasifikasi;
use backend\models\AktLabaRugi;

$this->title = 'Laporan Laba Rugi';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Akuntansi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= Html::beginForm(['', array('class' => 'form-inline')]) ?>

                        <table border="0" width="100%">
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Dari Tanggal</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <input type="date" name="tanggal_awal" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))) ?>" class="form-control" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Sampai Tanggal</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <input type="date" name="tanggal_akhir" value="<?= (!empty($tanggal_akhir)) ? $tanggal_akhir : date('Y-m-d') ?>" class="form-control" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <?= Html::endForm() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?= Html::a('Cetak', ['laporan-laba-rugi-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-laba-rugi-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>
        <!-- pendapatan -->
        <div class="panel panel-primary">
            <div class="panel-heading">Laporan Laba Rugi</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <table class="table">
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
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>