<?php

use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktKasBank;
use backend\models\AktPembayaranBiaya;
use backend\models\AktPembayaranBiayaHartaTetap;
use backend\models\AktPembelianDetail;
use backend\models\AktPembelianHartaTetapDetail;

$this->title = 'Laporan Detail Pembayaran';
?>
<style>
    .table_parent {
        width: 80%;
    }

    .table_parent tr td {
        text-align: center;
    }

    .table_child {
        width: 80%;
        background: rgba(0, 0, 0, 0.1);
        align-content: right;
    }
</style>
<div class="absensi-index">

    <?php
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
        </p>
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
            <table class="table_parent" style="margin-bottom: -10px;">
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
                <tr>
                    <td colspan="3">
                        <table class="table_child">
                            <tr>
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
                        <table class="table_child">
                            <tr>
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
                    </td>
                </tr>
            </table>
        <?php } ?>

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
    <?php } ?>
</div>

<?php
// $fileName = "Laporan Detail Pembayaran.xls";
// header("Content-Disposition: attachment; filename=$fileName");
// header("Content-Type: application/vnd.ms-excel");
?>