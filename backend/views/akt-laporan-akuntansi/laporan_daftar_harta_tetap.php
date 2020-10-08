<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktKlasifikasi;

$this->title = 'Laporan Daftar Harta Tetap';
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
                                        <input type="date" name="tanggal_awal" class="form-control" required>
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
                                        <input type="date" name="tanggal_akhir" class="form-control" required>
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
            <?= Html::a('Cetak', ['laporan-jurnal-umum-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-jurnal-umum-export', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table" border="1" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Kode Harta Tetap</th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Nama Harta Tetap</th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Tanggal Perolehan</th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Nilai Perolehan <?= date('Y', strtotime('-1 year')) ?></th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Beli <?= date('Y') ?></th>
                                        <th colspan="2" style="text-align: center;">Jual</th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Nilai Perolehan <?= date('Y') ?></th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Depresiasi per Tahun</th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Depresiasi <?= date('Y', strtotime('-1 year')) ?></th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Akumulasi Depresiasi <?= date('Y', strtotime('-1 year')) ?></th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Nilai Buku <?= date('Y', strtotime('-1 year')) ?></th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Depresiasi <?= date('Y') ?></th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Akumulasi Depresiasi <?= date('Y') ?></th>
                                        <th rowspan="3" style="vertical-align: middle;text-align: center;">Nilai Buku <?= date('Y') ?></th>
                                    </tr>
                                    <tr>
                                        <th>Nilai</th>
                                        <th>L/R</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2" style="text-align: center;"><?= date('Y') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>FA00001051</td>
                                        <td>Bangunan Workshop Saradang</td>
                                        <td>01/07/2019</td>
                                        <td style="text-align: right;">408,495,000</td>
                                        <td style="text-align: right;">-</td>
                                        <td style="text-align: right;">-</td>
                                        <td style="text-align: right;">-</td>
                                        <td style="text-align: right;">408,495,000 </td>
                                        <td style="text-align: right;">20,424,750</td>
                                        <td style="text-align: right;">10,212,378</td>
                                        <td style="text-align: right;">10,212,378</td>
                                        <td style="text-align: right;">398,282,62</td>
                                        <td style="text-align: right;">-</td>
                                        <td style="text-align: right;">10,212,378</td>
                                        <td style="text-align: right;">398,282,622</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align: right;">Total Per</th>
                                        <th style="text-align: right;">408,495,000</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>