<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;

$this->title = 'Laporan Anggaran vs Realisasi';
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
                                <td width="5%"></td>
                                <td width="10%">
                                    <div class="form-group">Jenis</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?= Select2::widget([
                                            'name' => 'jenis',
                                            'hideSearch' => false,
                                            'data' => $data_jenis,
                                            'options' => ['placeholder' => 'Pilih Jenis'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]); ?>
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
                                <td width="5%"></td>
                                <td width="10%">
                                    <div class="form-group">Klasifikasi</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?= Select2::widget([
                                            'name' => 'klasifikasi',
                                            'hideSearch' => false,
                                            'data' => $data_klasifikasi,
                                            'options' => ['placeholder' => 'Pilih Klasifikasi'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Akun</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?= Select2::widget([
                                            'name' => 'akun',
                                            'hideSearch' => false,
                                            'data' => $data_akun,
                                            'options' => ['placeholder' => 'Pilih Akun'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]); ?>
                                    </div>
                                </td>
                                <td width="5%"></td>
                                <td width="10%">
                                    <div class="form-group"></div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group"></div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">

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
            <?= Html::a('Cetak', ['laporan-buku-besar-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-buku-besar-export', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>
        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 1%;">#</th>
                                        <th style="width: 10%;">No. Akun</th>
                                        <th>Nama Akun</th>
                                        <th style="width: 15%;">Realisasi</th>
                                        <th style="width: 15%;">Budget</th>
                                        <th style="width: 15%;">Selisih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $filter_jenis = "";
                                    if (!empty($jenis)) {
                                        # code...
                                        $filter_jenis = " AND jenis = '$jenis'";
                                    }
                                    $filter_klasifikasi = "";
                                    if (!empty($klasifikasi)) {
                                        # code...
                                        $filter_klasifikasi = " AND klasifikasi = '$klasifikasi'";
                                    }
                                    $filter_akun = "";
                                    if (!empty($akun)) {
                                        # code...
                                        $filter_akun = " AND id_akun = '$akun' ";
                                    }

                                    $no = 1;
                                    $query_akun = AktAkun::find()->where("1 $filter_akun $filter_jenis $filter_klasifikasi")->orderBy("nama_akun")->all();
                                    foreach ($query_akun as $key => $data) {
                                        # code...
                                    ?>
                                        <tr>
                                            <td><?= $no++ . '.' ?></td>
                                            <td><?= $data['kode_akun'] ?></td>
                                            <td><?= $data['nama_akun'] ?></td>
                                            <td style="text-align: right;">2,678,521,623</td>
                                            <td style="text-align: right;">0</td>
                                            <td style="text-align: right;">2,678,521,623</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" style="text-align: right;">Total</th>
                                        <th style="text-align: right;">Total</th>
                                        <th style="text-align: right;">Total</th>
                                        <th style="text-align: right;">Total</th>
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