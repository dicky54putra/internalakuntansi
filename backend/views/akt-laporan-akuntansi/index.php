<?php

use yii\helpers\Html;

$this->title = 'Daftar Laporan Akuntansi';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <table class="table table-condensed">
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Daftar Akun', ['laporan-daftar-akun']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Jurnal Umum', ['laporan-jurnal-umum']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Buku Besar', ['laporan-buku-besar']) ?></td>
                            </tr>
                            <!-- <tr>
                                <td><?php // Html::a('<span class="fa fa-file-text"></span> Laporan Neraca Saldo Sebelum Penyesuaian (rumah V)', ['laporan-neraca-saldo-sebelum-penyesuaian']) 
                                    ?></td>
                            </tr>
                            <tr>
                                <td><?php // Html::a('<span class="fa fa-file-text"></span> Laporan Jurnal Penyesuaian', ['laporan-jurnal-penyesuaian']) 
                                    ?></td>
                            </tr>
                            <tr>
                                <td><?php // Html::a('<span class="fa fa-file-text"></span> Laporan Neraca Saldo Setelah Penyesuaian (Rumah X)', ['laporan-neraca-saldo-setelah-penyesuaian']) 
                                    ?></td>
                            </tr> -->
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Neraca Lajur', ['laporan-neraca-lajur']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Laba Rugi', ['akt-laporan-akuntansi/laporan-laba-rugi/']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Perubahan Ekuitas + Posisi Keuangan', ['akt-laba-rugi/']) ?></td>
                            </tr>
                            <!-- <tr>
                                <td>// Html::a('<span class="fa fa-file-text"></span> Laporan Perubahan Ekuitas (rumah V)', ['laporan-perubahan-ekuitas']) ?></td>
                            </tr> -->
                            <!-- <tr>
                                <td>// Html::a('<span class="fa fa-file-text"></span> Laporan Posisi Keuangan (rumah X)', ['laporan-posisi-keuangan']) ?></td>
                            </tr> -->
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Arus Kas', ['laporan-arus-kas']) ?></td>
                            </tr>
                            <!-- <tr>
                                <td><?php // Html::a('<span class="fa fa-file-text"></span> Laporan Daftar Harta Tetap (rumah V)', ['laporan-daftar-harta-tetap']) 
                                    ?></td>
                            </tr> -->
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Pajak PPN ', ['laporan-pajak-ppn'])
                                    ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Rekonsiliasi PPN ', ['laporan-rekonsiliasi-ppn'])
                                    ?></td>
                            </tr>
                            <!-- <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Pajak PPH', ['laporan-pajak-pph'])
                                    ?></td>
                            </tr> -->
                            <!-- <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Rekonsiliasi Pajak PPN (rumah V)', ['laporan-rekonsiliasi-pajak-ppn'])
                                    ?></td>
                            </tr> -->
                            <!-- <tr>
                                <td><?php // Html::a('<span class="fa fa-file-text"></span> Laporan Anggaran vs Realisasi (rumah V)', ['laporan-anggaran-vs-realisasi']) 
                                    ?></td>
                            </tr> -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>