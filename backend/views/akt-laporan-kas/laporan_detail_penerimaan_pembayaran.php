<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKasBank;
use backend\models\AktMitraBisnis;
use backend\models\AktPenerimaanPembayaran;
use backend\models\AktPenerimaanPembayaranHartaTetap;
use backend\models\AktPenjualanDetail;
use backend\models\AktPenjualanHartaTetapDetail;
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
            <div class="row">
                <div class="col-md-6">
                    <div class="box-body" style="overflow-x: auto;">
                        PENJUALAN
                        <?php
                        $no = 0;
                        $totalan_debit = 0;
                        $totalan_kredit = 0;
                        if (!empty($supplier)) {
                            $query_penerimaan = Yii::$app->db->createCommand("SELECT * FROM akt_penerimaan_pembayaran LEFT JOIN akt_penjualan ON akt_penjualan.id_penjualan = akt_penerimaan_pembayaran.id_penjualan WHERE tanggal_penerimaan_pembayaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_penjualan.id_customer = $supplier")->query();
                        } else {
                            $query_penerimaan = Yii::$app->db->createCommand("SELECT * FROM akt_penerimaan_pembayaran LEFT JOIN akt_penjualan ON akt_penjualan.id_penjualan = akt_penerimaan_pembayaran.id_penjualan WHERE tanggal_penerimaan_pembayaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
                        }

                        foreach ($query_penerimaan as $key => $val) {
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
                                            <td><?= tanggal_indo($val['tanggal_penerimaan_pembayaran']) ?></td>
                                            <td><?= $val['no_penjualan'] ?></td>
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
                                                $no_penjualan_detail = 0;
                                                $sum_penjualan = 0;
                                                $penjualan_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $val['id_penjualan']])->all();
                                                foreach ($penjualan_detail as $pem) {
                                                    $barang_stok = AktItemStok::find()->where(['id_item_stok' => $pem->id_item_stok])->one();
                                                    $barang = AktItem::find()->where(['id_item' => $barang_stok->id_item])->one();
                                                    $sum_penjualan += $pem->total;
                                                    $no_penjualan_detail++
                                                ?>
                                                    <tr>
                                                        <td><?= $no_penjualan_detail ?></td>
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
                                                        <td style="text-align: right;"><?= ribuan($diskon = $sum_penjualan * $val['diskon'] / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $diskon = 0;
                                                } ?>
                                                <?php if ($val['pajak'] == 1) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Pajak</td>
                                                        <td></td>
                                                        <td style="text-align: right;"><?= ribuan($pajak = ($sum_penjualan + $diskon) * 10 / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $pajak = 0;
                                                } ?>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="border-top: 1px solid #000;text-align: right;"><?= ribuan($sum_penjualan - $diskon + $pajak) ?></td>
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
                                                $bayar = AktPenerimaanPembayaran::find()->where(['id_penjualan' => $val['id_penjualan']])->all();
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
                        PENJUALAN HARTA TETAP
                        <?php
                        $no = 0;
                        $totalan_debit = 0;
                        $totalan_kredit = 0;
                        if (!empty($supplier)) {
                            $query_pembayaran = Yii::$app->db->createCommand("SELECT * FROM akt_penerimaan_pembayaran_harta_tetap LEFT JOIN akt_penjualan_harta_tetap ON akt_penjualan_harta_tetap.id_penjualan_harta_tetap = akt_penerimaan_pembayaran_harta_tetap.id_penjualan_harta_tetap WHERE tanggal_penerimaan_pembayaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_penjualan_harta_tetap.id_supplier = $supplier")->query();
                        } else {
                            $query_pembayaran = Yii::$app->db->createCommand("SELECT * FROM akt_penerimaan_pembayaran_harta_tetap LEFT JOIN akt_penjualan_harta_tetap ON akt_penjualan_harta_tetap.id_penjualan_harta_tetap = akt_penerimaan_pembayaran_harta_tetap.id_penjualan_harta_tetap WHERE tanggal_penerimaan_pembayaran BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
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
                                            <td><?= tanggal_indo($val['tanggal_penerimaan_pembayaran']) ?></td>
                                            <td><?= $val['no_penjualan_harta_tetap'] ?></td>
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
                                                $no_penjualan_detail = 0;
                                                $sum_penjualan = 0;
                                                $penjualan_detail = AktPenjualanHartaTetapDetail::find()->where(['id_penjualan_harta_tetap' => $val['id_penjualan_harta_tetap']])->all();
                                                foreach ($penjualan_detail as $pem) {
                                                    $sum_penjualan += $pem->total;
                                                    $no_penjualan_detail++
                                                ?>
                                                    <tr>
                                                        <td><?= $no_penjualan_detail ?></td>
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
                                                        <td style="text-align: right;"><?= ribuan($diskon = $sum_penjualan * $val['diskon'] / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $diskon = 0;
                                                } ?>
                                                <?php if ($val['pajak'] == 1) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td>Pajak</td>
                                                        <td></td>
                                                        <td style="text-align: right;"><?= ribuan($pajak = ($sum_penjualan + $diskon) * 10 / 100) ?></td>
                                                    </tr>
                                                <?php } else {
                                                    $pajak = 0;
                                                } ?>
                                                <tr>
                                                    <td colspan="3"></td>
                                                    <td style="border-top: 1px solid #000;text-align: right;"><?= ribuan($sum_penjualan - $diskon + $pajak) ?></td>
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
                                                $bayar = AktPenerimaanPembayaranHartaTetap::find()->where(['id_penjualan_harta_tetap' => $val['id_penjualan_harta_tetap']])->all();
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