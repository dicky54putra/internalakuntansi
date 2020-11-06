<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKasBank;
use backend\models\Setting;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Laporan Transfer Kas';
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
                                        <input type="date" name="tanggal_awal" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))); ?>" class="form-control" required>
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
                                        <input type="date" name="tanggal_akhir" value="<?= (!empty($tanggal_akhir)) ? $tanggal_akhir : date('Y-m-d'); ?>" class="form-control" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Kas/ Bank Asal</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?php
                                        $data =  ArrayHelper::map(
                                            AktKasBank::find()->all(),
                                            'id_kas_bank',
                                            'keterangan'
                                        );

                                        echo Select2::widget([
                                            'name' => 'kasbank_asal',
                                            'data' => $data,
                                            'options' => [
                                                'placeholder' => 'Pilih Kas/ Bank Asal'
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
                                <td width="10%">
                                    <div class="form-group">Kas/ Bank Tujuan</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?php
                                        $data =  ArrayHelper::map(
                                            AktKasBank::find()->all(),
                                            'id_kas_bank',
                                            'keterangan'
                                        );

                                        echo Select2::widget([
                                            'name' => 'kasbank_tujuan',
                                            'data' => $data,
                                            'options' => [
                                                'placeholder' => 'Pilih Kas/ Bank Tujuan'
                                            ],
                                            'value' => (!empty($kasbank_tujuan)) ? $kasbank_tujuan : '',
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
        <div class="box">
            <div class="box box-primary">
                <div class="box-heading" style="overflow-x: auto;">
                </div>
                <div class="box-body" style="overflow-x: auto;">
                    <table class="table">
                        <tr>
                            <?php
                            $setting = Setting::find()->one();
                            if (!empty($setting->foto)) {
                            ?>
                                <th rowspan="3" style="width: 150px;"><img style="float: right;" width="150px" src="upload/<?= $setting->foto ?>" alt=""></th>
                            <?php } ?>
                            <th style="text-align: center;">
                                <h3 style="margin-top: -5px;margin-bottom: -5px;"><?= $setting->nama ?></h3>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                <h3 style="margin-top: -5px;margin-bottom: -5px;">Mutasi Kas</h3>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: right;"><?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?></th>
                        </tr>
                    </table>
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>No Transaksi</th>
                                <th>Kas Asal</th>
                                <th>Kas Tujuan</th>
                                <th>Jumlah Kas Asal</th>
                                <th>Jumlah Kas Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 0;
                            $sum_asal = 0;
                            $sum_tujuan = 0;
                            if ($kasbank_asal == null && $kasbank_tujuan == null) {
                                $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE tanggal BETWEEN $tanggal_awal AND $tanggal_akhir")->query();
                            } elseif ($kasbank_asal == null) {
                                $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE id_tujuan_kas = '$kasbank_tujuan' AND tanggal BETWEEN $tanggal_awal AND $tanggal_akhir")->query();
                            } elseif ($kasbank_tujuan == null) {
                                $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE id_asal_kas = '$kasbank_asal' AND tanggal BETWEEN $tanggal_awal AND $tanggal_akhir")->query();
                            } else {
                                $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE id_asal_kas = '$kasbank_asal' AND id_tujuan_kas = '$kasbank_tujuan' AND tanggal BETWEEN $tanggal_awal AND $tanggal_akhir")->query();
                            }
                            foreach ($query_transfer_kasbank as $key => $value) {
                                $no++;
                                $sum_asal += $value->jumlah1;
                                $sum_tujuan += $value->jumlah2;
                                $kas_asal = AktKasBank::find()->where(['id_kas_bank' => 'id_asal_kas'])->one();
                                $kas_tujuan = AktKasBank::find()->where(['id_kas_bank' => 'id_tujuan_kas'])->one();
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $value->tanggal ?></td>
                                    <td><?= $value->no_transfer_kas ?></td>
                                    <td><?= $kas_asal->keterangan ?></td>
                                    <td><?= $kas_tujuan->keterangan ?></td>
                                    <td>Rp. <?= ribuan($value->jumlah1) ?></td>
                                    <td>Rp. <?= ribuan($value->jumlah2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align: left;">Total</th>
                                <th style="text-align: right;">Rp. <?= ribuan($sum_asal) ?></th>
                                <th style="text-align: right;">Rp. <?= ribuan($sum_tujuan) ?></th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    <?php } ?>

</div>