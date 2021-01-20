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
                                    <div class="form-group">Customer</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?php
                                        $data =  ArrayHelper::map(
                                            AktMitraBisnis::find()->where(['!=', 'tipe_mitra_bisnis', 2])->all(),
                                            'id_mitra_bisnis',
                                            'nama_mitra_bisnis'
                                        );

                                        echo Select2::widget([
                                            'name' => 'customer',
                                            'data' => $data,
                                            'options' => [
                                                'placeholder' => 'Pilih Customer'
                                            ],
                                            'value' => (!empty($customer)) ? $customer : '',
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
        <div class="box box-primary">
            <div class="box-body" style="overflow-x: auto;">

                <table style="width: 100%;">
                    <thead style="border-top: 1px solid #000000;border-bottom: 1px solid #000000; height: 30px;">
                        <tr>
                            <th style="width: 2%;">#</th>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 22%;">No. Pembayaran</th>
                            <th>Vendor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $totalan_debit = 0;
                        $totalan_kredit = 0;
                        $query_pembayaran = Yii::$app->db->createCommand("SELECT * FROM akt_pembayaran_biaya WHERE tanggal_pembayaran_biaya BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
                        foreach ($query_pembayaran as $key => $val) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $no . '.' ?></td>
                                <td><?= tanggal_indo($val['tanggal_pembayaran_biaya']) ?></td>
                                <td><?= 'ok' ?></td>
                                <td><?= $val['nominal'] ?></td>
                            </tr>
                            <tr>
                                <th colspan="4" style="color: blue;"></th>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <h4 style="color: blue;">Yang Dibayar</h4>
                                    <table class="table2" style="width: 90%; margin-right: 20px; float: right;">
                                        <thead style="border-top: 1px solid #000000;border-bottom: 1px solid #000000; height: 30px;">
                                            <tr>
                                                <th>Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Jumlah</th>
                                                <th>Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $yang_dibayar = Yii::$app->db->createCommand("SELECT * FROM akt_pembelian_detail LEFT JOIN akt_pembelian ON akt_pembelian.id_pembelian = akt_pembelian_detail.id_pembelian LEFT JOIN akt_pembayaran_biaya ON akt_pembayaran_biaya.id_pembelian = akt_pembelian.id_pembelian WHERE akt_pembelian.id_pembelian = '$val[id_pembelian]'")->query();
                                            foreach ($yang_dibayar as $key => $val2) {
                                            ?>
                                                <tr>
                                                    <td><?= $val2['no_pembelian'] ?></td>
                                                    <td>oaksdo</td>
                                                    <td>oaksdo</td>
                                                    <td>oaksdo</td>
                                                    <td>oaksdo</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <h4 style="color: blue;">Cara Bayar</h4>
                                    <table class="table2" style="width: 90%; margin-right: 20px; float: right;">
                                        <thead style="border-top: 1px solid #000000;border-bottom: 1px solid #000000; height: 30px;">
                                            <tr>
                                                <th>Cash</th>
                                                <th>No CBG</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>oaksdo</td>
                                                <td>oaksdo</td>
                                                <td>oaksdo</td>
                                                <td>oaksdo</td>
                                                <td>oaksdo</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" style="text-align: left;">Total</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    <?php } ?>
</div>