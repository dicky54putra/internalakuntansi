<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktJurnalPenyesuaian;
use backend\models\AktJurnalPenyesuaianDetail;

$this->title = 'Laporan Jurnal Penyesuaian';
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
            <?= Html::a('Cetak', ['laporan-jurnal-penyesuaian-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-jurnal-penyesuaian-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>
        <?php
        $query_jurnal_penyesuaian = AktJurnalPenyesuaian::find()->where(['BETWEEN', 'tanggal_jurnal_penyesuaian', $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_jurnal_penyesuaian ASC")->all();
        foreach ($query_jurnal_penyesuaian as $key => $data) {
            # code...
        ?>
            <div class="box">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <style>
                            .tabel {
                                width: 100%;
                            }

                            .tabel th,
                            .tabel td {
                                padding: 2px;
                            }

                            .tabel th {
                                width: 10%;
                            }
                        </style>
                        <table class="tabel">
                            <thead>
                                <tr>
                                    <th>No. Jurnal</th>
                                    <td>: <?= $data['no_jurnal_penyesuaian'] ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Jurnal</th>
                                    <td>: <?= date('d/m/Y', strtotime($data['tanggal_jurnal_penyesuaian'])) ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="box-body" style="overflow-x: auto;">

                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%;">#</th>
                                            <th style="width: 7%;">Tanggal</th>
                                            <th style="width: 7%;">Kode Akun</th>
                                            <th>Uraian</th>
                                            <th style="width: 10%;text-align: center;">Debit</th>
                                            <th style="width: 10%;text-align: center;">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $query_jurnal_penyesuaian_detail = AktJurnalPenyesuaianDetail::find()->where(['id_jurnal_penyesuaian' => $data['id_jurnal_penyesuaian']])->all();
                                        foreach ($query_jurnal_penyesuaian_detail as $key => $dataa) {
                                            # code...
                                            $no++;
                                            $akt_akun = AktAkun::findOne($dataa['id_akun']);
                                        ?>
                                            <tr>
                                                <td><?= $no . '.' ?></td>
                                                <td><?= date('d/m/Y', strtotime($data['tanggal_jurnal_penyesuaian'])) ?></td>
                                                <td><?= $akt_akun->kode_akun ?></td>
                                                <td><?= $akt_akun->nama_akun ?></td>
                                                <td style="text-align: right;"><?= ($dataa['debit'] != 0) ? ribuan($dataa['debit']) : '' ?></td>
                                                <td style="text-align: right;"><?= ($dataa['kredit'] != 0) ? ribuan($dataa['kredit']) : '' ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

</div>