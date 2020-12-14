<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKasBank;
use backend\models\AktMitraBisnis;
use backend\models\AktPembayaranBiaya;
use backend\models\AktPembayaranBiayaHartaTetap;
use backend\models\AktPembelian;
use backend\models\AktPembelianDetail;
use backend\models\AktPembelianHartaTetapDetail;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Laporan Detail Pembayaran';
?>
<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb print-none">
        <li><a href="/">Home </a> </li>
        <li><?= Html::a('Daftar Laporan Kas', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p class="print-none">
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box print-none" id="panel">
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
                                            'name' => 'supplier',
                                            'data' => $data,
                                            'options' => [
                                                'placeholder' => 'Pilih Supplier'
                                            ],
                                            'value' => (!empty($supplier)) ? $supplier : '',
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
            <button class="btn btn-primary btn-cetak print-none" onclick="funcPrint()">Cetak</button>
            <?php if (!empty($supplier)) { ?>
                <?= Html::a('Export', ['laporan-detail-pembayaran-export', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'supplier' => $supplier], ['class' => 'btn btn-success print-none', 'target' => '_blank', 'method' => 'post']) ?>
            <?php } else { ?>
                <?= Html::a('Export', ['laporan-detail-pembayaran-export', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success print-none', 'target' => '_blank', 'method' => 'post']) ?>
            <?php } ?>
        </p>
        <div class="box box-primary">
            <div class="row">
                <div class="col-md-6">
                    <div class="box-body" style="overflow-x: auto;">
                        PEMBELIAN
                        <?php
                        $no = 0;
                        $totalan_debit = 0;
                        $totalan_kredit = 0;
                        if (!empty($supplier)) {
                            $query_pembayaran = Yii::$app->db->createCommand("SELECT * FROM akt_pembayaran_biaya LEFT JOIN akt_pembelian ON akt_pembelian.id_pembelian = akt_pembayaran_biaya.id_pembelian WHERE tanggal_pembayaran_biaya BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_pembelian.id_customer = $supplier")->query();
                        } else {
                            $query_pembayaran = Yii::$app->db->createCommand("SELECT * FROM akt_pembayaran_biaya LEFT JOIN akt_pembelian ON akt_pembelian.id_pembelian = akt_pembayaran_biaya.id_pembelian WHERE tanggal_pembayaran_biaya BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
                        }

                        foreach ($query_pembayaran as $key => $val) {
                            $no++;
                        ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <table class="table" style="margin-bottom: -10px;">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No Pembayaran</th>
                                            <th style="width: 30%;">Vendor</th>
                                        </tr>
                                        <tr>
                                            <td><?= tanggal_indo($val['tanggal_pembayaran_biaya']) ?></td>
                                            <td><?= $val['no_pembelian'] ?></td>
                                            <td><?= ($val['jenis_bayar'] == 1) ? 'CASH' : 'KREDIT' ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" style="padding: 0;">
                                        <div class="box-body">
                                            Yang Dibayar
                                            <table class="table" style="margin-top: 20px;">
                                                <tr style="background-color: rgba(0,0,0,0.1);">
                                                    <th style="width: 5%;">No</th>
                                                    <th>Keterangan</th>
                                                    <th>Jumlah</th>
                                                    <th style="width: 25%;text-align: right;">Total Bayar</th>
                                                </tr>
                                                <?php
                                                $no_pembelian_detail = 0;
                                                $sum_pembelian = 0;
                                                $pembelian_detail = AktPembelianDetail::find()->where(['id_pembelian' => $val['id_pembelian']])->all();
                                                foreach ($pembelian_detail as $pem) {
                                                    $barang_stok = AktItemStok::find()->where(['id_item_stok' => $pem->id_item_stok])->one();
                                                    $barang = AktItem::find()->where(['id_item' => $barang_stok->id_item])->one();
                                                    $sum_pembelian += $pem->total;
                                                    $no_pembelian_detail++
                                                ?>
                                                    <tr>
                                                        <td><?= $no_pembelian_detail ?></td>
                                                        <td><?= (!empty($barang->nama_item)) ? $barang->nama_item : '' ?></td>
                                                        <td><?= $pem->qty ?></td>
                                                        <td style="text-align: right;"><?= ribuan($pem->total) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if (!empty($val['diskon'])) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Diskon</td>
                                                        <td></td>
                                                        <td style="text-align: right;"><?= ribuan($diskon = $sum_pembelian * $val['diskon'] / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $diskon = 0;
                                                } ?>
                                                <?php if ($val['pajak'] == 1) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Pajak</td>
                                                        <td></td>
                                                        <td style="text-align: right;"><?= ribuan($pajak = ($sum_pembelian + $diskon) * 10 / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $pajak = 0;
                                                } ?>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="border-top: 1px solid #000;text-align: right;"><?= ribuan($sum_pembelian - $diskon + $pajak) ?></td>
                                                </tr>
                                            </table>
                                            Cara Bayar
                                            <table class="table" style="margin-top: 20px;">
                                                <tr style="background-color: rgba(0,0,0,0.1);">
                                                    <th style="width: 5%;">No</th>
                                                    <th>Cash</th>
                                                    <th>Keterangan</th>
                                                    <th style="width: 25%;text-align: right;">Total Bayar</th>
                                                </tr>
                                                <?php
                                                $no_bayar = 1;
                                                $sum_bayar = 0;
                                                $bayar = AktPembayaranBiaya::find()->where(['id_pembelian' => $val['id_pembelian']])->all();
                                                foreach ($bayar as $bayar) {
                                                    $kasbank = AktKasBank::find()->where(['id_kas_bank' => $bayar->id_kas_bank])->one();
                                                    $sum_bayar += $bayar->nominal;
                                                ?>
                                                    <tr>
                                                        <td><?= $no_bayar++ ?></td>
                                                        <td><?= $kasbank->keterangan ?></td>
                                                        <td><?= $bayar->keterangan ?></td>
                                                        <td style="text-align: right;"><?= ribuan($bayar->nominal) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="border-top: 1px solid #000;text-align: right;"><?= ribuan($sum_bayar) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box-body" style="overflow-x: auto;">
                        PEMBELIAN HARTA TETAP
                        <?php
                        $no = 0;
                        $totalan_debit = 0;
                        $totalan_kredit = 0;
                        if (!empty($supplier)) {
                            $query_pembayaran = Yii::$app->db->createCommand("SELECT * FROM akt_pembayaran_biaya_harta_tetap LEFT JOIN akt_pembelian_harta_tetap ON akt_pembelian_harta_tetap.id_pembelian_harta_tetap = akt_pembayaran_biaya_harta_tetap.id_pembelian_harta_tetap WHERE tanggal_pembayaran_biaya BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_pembelian_harta_tetap.id_supplier = $supplier")->query();
                        } else {
                            $query_pembayaran = Yii::$app->db->createCommand("SELECT * FROM akt_pembayaran_biaya_harta_tetap LEFT JOIN akt_pembelian_harta_tetap ON akt_pembelian_harta_tetap.id_pembelian_harta_tetap = akt_pembayaran_biaya_harta_tetap.id_pembelian_harta_tetap WHERE tanggal_pembayaran_biaya BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
                        }

                        foreach ($query_pembayaran as $key => $val) {
                            $no++;
                        ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <table class="table" style="margin-bottom: -10px;">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No Pembayaran</th>
                                            <th style="width: 30%;">Vendor</th>
                                        </tr>
                                        <tr>
                                            <td><?= tanggal_indo($val['tanggal_pembayaran_biaya']) ?></td>
                                            <td><?= $val['no_pembelian_harta_tetap'] ?></td>
                                            <td><?= ($val['jenis_bayar'] == 1) ? 'CASH' : 'KREDIT' ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" style="padding: 0;">
                                        <div class="box-body">
                                            Yang Dibayar
                                            <table class="table" style="margin-top: 20px;">
                                                <tr style="background-color: rgba(0,0,0,0.1);">
                                                    <th style="width: 5%;">No</th>
                                                    <th>Keterangan</th>
                                                    <th>Jumlah</th>
                                                    <th style="width: 25%;text-align: right;">Total Bayar</th>
                                                </tr>
                                                <?php
                                                $no_pembelian_detail = 0;
                                                $sum_pembelian = 0;
                                                $pembelian_detail = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $val['id_pembelian_harta_tetap']])->all();
                                                foreach ($pembelian_detail as $pem) {
                                                    $sum_pembelian += $pem->total;
                                                    $no_pembelian_detail++
                                                ?>
                                                    <tr>
                                                        <td><?= $no_pembelian_detail ?></td>
                                                        <td><?= $pem->nama_barang ?></td>
                                                        <td><?= $pem->qty ?></td>
                                                        <td style="text-align: right;"><?= ribuan($pem->total) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if (!empty($val['diskon'])) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Diskon</td>
                                                        <td></td>
                                                        <td style="text-align: right;"><?= ribuan($diskon = $sum_pembelian * $val['diskon'] / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $diskon = 0;
                                                } ?>
                                                <?php if ($val['pajak'] == 1) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Pajak</td>
                                                        <td></td>
                                                        <td style="text-align: right;"><?= ribuan($pajak = ($sum_pembelian + $diskon) * 10 / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $pajak = 0;
                                                } ?>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="border-top: 1px solid #000;text-align: right;"><?= ribuan($sum_pembelian - $diskon + $pajak) ?></td>
                                                </tr>
                                            </table>
                                            Cara Bayar
                                            <table class="table" style="margin-top: 20px;">
                                                <tr style="background-color: rgba(0,0,0,0.1);">
                                                    <th style="width: 5%;">No</th>
                                                    <th>Cash</th>
                                                    <th>Keterangan</th>
                                                    <th style="width: 25%;text-align: right;">Total Bayar</th>
                                                </tr>
                                                <?php
                                                $no_bayar = 1;
                                                $sum_bayar = 0;
                                                $bayar = AktPembayaranBiayaHartaTetap::find()->where(['id_pembelian_harta_tetap' => $val['id_pembelian_harta_tetap']])->all();
                                                foreach ($bayar as $bayar) {
                                                    $kasbank = AktKasBank::find()->where(['id_kas_bank' => $bayar->id_kas_bank])->one();
                                                    $sum_bayar += $bayar->nominal;
                                                ?>
                                                    <tr>
                                                        <td><?= $no_bayar++ ?></td>
                                                        <td><?= $kasbank->keterangan ?></td>
                                                        <td><?= $bayar->keterangan ?></td>
                                                        <td style="text-align: right;"><?= ribuan($bayar->nominal) ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="border-top: 1px solid #000;text-align: right;"><?= ribuan($sum_bayar) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    const element = document.getElementById("panel");
    // const element = document.querySelectorAll("panel");

    function funcPrint() {
        element.classList.remove("panel-primary");
        window.print();
    }

    window.onafterprint = function() {
        element.classList.add("panel-primary");
    }
</script>
<style>
    @media print {
        .print-none {
            display: none;
        }

        .panel-primary {
            background: none;
            border: none;
        }
    }
</style>