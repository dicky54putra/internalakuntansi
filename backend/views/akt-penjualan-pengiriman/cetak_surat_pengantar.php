<?php

use backend\models\AktPenjualanDetail;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktSatuan;
?>
<style>
    .table1 {
        border: 0px solid #000000;
        width: 100%;
        font-size: 15px;
        text-align: left;
    }

    .table1 th {
        border: 0px solid #000000;
    }

    .table2 {
        border: 0px solid #000000;
        width: 100%;
    }

    .table2 th {
        text-align: center;
    }

    .table3 {
        border: 0px solid #000000;
        width: 100%;
        text-align: left;
    }

    .table3 th,
    .table3 td {
        border: 0px solid #000000;
    }

    .titik2 {
        width: 27%;
    }

    .nomor_tanggal {
        width: 19%;
        text-align: left;
    }

    .kiri_nomor_tanggal {
        width: 30%;
        font-size: 15px;
    }

    .table4,
    .table4 td {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table4,
    .table4 th {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table4 {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
    }

    .table4 th,
    .table4 td {
        padding: 5px;
        /* border-bottom: 1px solid #000000; */
    }

    .table4 th {
        border: 1px solid #000000;
    }

    hr {
        border: 1px solid black;
    }

    .ptext {
        margin-top: -15px;
        font-weight: bold;
        font-size: 14px;
    }

    .table5 {
        width: 100%;
    }

    .table5 th {
        padding: 5px;
        text-align: center;
        /* border: 1px solid #000000; */
    }

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }
    }

    .margin-style {
        margin: 40px;
    }
</style>
<div class="margin-style">
    <table class="table1">
        <thead>
            <tr>
                <th style="width: 30%;white-space: nowrap;"><?= $data_setting->nama ?></th>
                <th rowspan="4" style="vertical-align: middle;text-align: center;">SURAT JALAN</th>
                <th style="width: 15%;white-space: nowrap;">No.</th>
                <th style="width: 10%;white-space: nowrap;">: <?= $model->no_pengiriman ?></th>
            </tr>
            <tr>
                <th style="white-space: nowrap;"><?= $data_setting->alamat ?></th>
                <th style="white-space: nowrap;">Tanggal</th>
                <th style="white-space: nowrap;">: <?= date('d/m/Y') ?></th>
            </tr>
            <tr>
                <th style="white-space: nowrap;">Telp : <?= $data_setting->telepon ?></th>
                <th style="white-space: nowrap;">Cara Pengiriman</th>
                <th style="white-space: nowrap;">: Dikirim</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th style="white-space: nowrap;">Termin Pembayaran</th>
                <th style="white-space: nowrap;">: tempo <?= (!empty($model_penjualan->jumlah_tempo)) ? $model_penjualan->jumlah_tempo : 0 ?> hari</th>
            </tr>
        </thead>
    </table>
    <table class="table3">
        <thead>
            <tr>
                <th colspan="4">Dikirim Ke :</th>
            </tr>
            <tr>
                <th class="kiri_nomor_tanggal"><?= $model_penjualan->customer->nama_mitra_bisnis ?></th>
                <th rowspan="2">&nbsp;</th>
                <th class="nomor_tanggal" style="text-align: left;">Pengemudi</th>
                <th class="titik2" colspan="2">: &nbsp;</th>
            </tr>
            <tr>
                <th class="kiri_nomor_tanggal"><?= (!empty($model->mitra_bisnis_alamat->alamat_lengkap)) ? $model->mitra_bisnis_alamat->alamat_lengkap : '' ?></th>
                <th class="nomor_tanggal" style="text-align: left;">No. Unit</th>
                <th class="titik2" colspan="2">: &nbsp;</th>
            </tr>
        </thead>
    </table>
    <br>
    <table class="table4">
        <thead>
            <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 10%;white-space: nowrap;">Kode Barang</th>
                <th>Nama Barang</th>
                <th style="width: 10%;white-space: nowrap;">Qty Dikirim</th>
                <th style="width: 10%;white-space: nowrap;">Satuan</th>
                <!-- <th style="width: 10%;white-space: nowrap;">Bobot</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $angka = 0;
            $totalan_qty_dikirim = 0;
            $totalan_bobot = 0;
            $penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::findAll(['id_penjualan_pengiriman' => $model->id_penjualan_pengiriman]);
            $count_penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_pengiriman' => $model->id_penjualan_pengiriman])->count();
            foreach ($penjualan_pengiriman_detail as $key => $dataa) {
                # code...
                $angka++;
                $retVal_id_penjualan_detail = (!empty($dataa->id_penjualan_detail)) ? $dataa->id_penjualan_detail : 0;
                $penjualan_detail = AktPenjualanDetail::findOne($retVal_id_penjualan_detail);
                $retVal_id_item_stok = (!empty($penjualan_detail->id_item_stok)) ? $penjualan_detail->id_item_stok : 0;
                $item_stok = AktItemStok::findOne($retVal_id_item_stok);
                $retVal_id_item = (!empty($item_stok->id_item)) ? $item_stok->id_item : 0;
                $item = AktItem::findOne($retVal_id_item);

                $totalan_qty_dikirim += $dataa->qty_dikirim;
            ?>
                <tr>
                    <td style="border-left: 1px solid #000000;"><?= $angka . '.' ?></td>
                    <td><?= (!empty($item->kode_item)) ? $item->kode_item : '' ?></td>
                    <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                    <td style="text-align: center;"><?= $dataa->qty_dikirim ?></td>
                    <td style="text-align: center;border-right: 1px solid #000000;"><?= (!empty($item->satuan->nama_satuan)) ? $item->satuan->nama_satuan : '' ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="border-left: 1px solid #000000;border-bottom: 1px solid #000000;"><b>Jumlah Barang</b></td>
                <td style="text-align: center;border-bottom: 1px solid #000000;"><b><?= number_format($totalan_qty_dikirim) ?></b></td>
                <td style="text-align: center;border-bottom: 1px solid #000000;border-right: 1px solid #000000;"></td>
            </tr>
        </tfoot>
    </table>
    <br>
    <br>
    <!-- <hr> -->
    <table class="table5">
        <thead>
            <tr>
                <th>Kepala Gudang</th>
                <th>Pengemudi</th>
                <th>Pelanggan</th>
            </tr>
            <tr>
                <th style="height: 60px;"></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th>________________</th>
                <th>________________</th>
                <th>________________</th>
            </tr>
        </thead>
    </table>

</div>

<script>
    window.print();
    // setTimeout(window.close, 1000);
</script>