<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKasBank;
use backend\models\AktMitraBisnis;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Laporan Detail Pembayaran';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Kas', ['index']) ?></li>
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
                                        <input type="date" name="tanggal_awal" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : null; ?>" class="form-control" required>
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
                                        <input type="date" name="tanggal_akhir" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : null; ?>" class="form-control" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Supplier</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?php
                                        $data =  ArrayHelper::map(
                                            AktMitraBisnis::find()->where(['!=', 'tipe_mitra_bisnis', 1])->all(),
                                            'id_mitra_bisnis',
                                            'nama_mitra_bisnis'
                                        );

                                        echo Select2::widget([
                                            'name' => 'kasbank_asal',
                                            'data' => $data,
                                            'options' => [
                                                'placeholder' => 'Pilih Supplier'
                                            ],
                                            'value' => (!empty($kasbank_asal)) ? $kasbank_asal : '',
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]);
                                        ?>
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
            <?= Html::a('Export', ['laporan-jurnal-umum-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>
        <?php
        $query_jurnal_umum = AktJurnalUmum::find()->where(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->orderBy("tanggal ASC")->all();
        foreach ($query_jurnal_umum as $key => $data) {
            # code...
        ?>
            <div class="box">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="overflow-x: auto;">
                        <style>
                            .tabel {
                                width: 100%;
                            }

                            .tabel th,
                            .tabel td {
                                padding: 2px;
                            }
                        </style>
                        <table class="tabel">
                            <thead>
                                <tr>
                                    <th style="width: 12%;white-space: nowrap;">Tanggal Jurnal</th>
                                    <th style="width: 12%;white-space: nowrap;">No. Jurnal Umum</th>
                                    <th style="width: 12%;white-space: nowrap;">Tipe</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($data['tanggal'])) ?></td>
                                    <td><?= $data['no_jurnal_umum'] ?></td>
                                    <td><?= ($data['tipe'] == 1) ? 'Jurnal Umum' : '-' ?></td>
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
                                            <th style="width: 2%;">#</th>
                                            <th style="width: 7%;">No. Akun</th>
                                            <th style="width: 22%;">Nama Akun</th>
                                            <th>Keterangan</th>
                                            <th style="width: 10%; text-align: center;">Debet</th>
                                            <th style="width: 10%; text-align: center;">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $totalan_debit = 0;
                                        $totalan_kredit = 0;
                                        $query_jurnal_umum_detail = AktJurnalUmumDetail::findAll(['id_jurnal_umum' => $data['id_jurnal_umum']]);
                                        foreach ($query_jurnal_umum_detail as $key => $dataa) {
                                            # code...
                                            $no++;
                                            $akt_akun = AktAkun::findOne($dataa['id_akun']);

                                            $totalan_debit += $dataa['debit'];
                                            $totalan_kredit += $dataa['kredit'];
                                        ?>
                                            <tr>
                                                <td><?= $no . '.' ?></td>
                                                <td><?= $akt_akun->kode_akun ?></td>
                                                <td><?= $akt_akun->nama_akun ?></td>
                                                <td><?= $dataa['keterangan'] ?></td>
                                                <td style="text-align: right;"><?= ($dataa['debit'] != 0) ? ribuan($dataa['debit']) : '' ?></td>
                                                <td style="text-align: right;"><?= ($dataa['kredit'] != 0) ? ribuan($dataa['kredit']) : '' ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align: left;">Total</th>
                                            <th style="text-align: right;"><?= ribuan($totalan_debit) ?></th>
                                            <th style="text-align: right;"><?= ribuan($totalan_kredit) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

</div>