<?php

use backend\models\AktPembelian;
use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
?>
<style>
    @media print {
        @page {
            size: auto;
            margin: 0mm;
            /* margin: 10mm; */
        }
    }

    .table1 {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-size: 14px;
    }

    .table1 th,
    .table1 td {
        padding: 5px;
        line-height: 12px;
        text-align: left;
    }

    .table {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-size: 14px;
        border-collapse: collapse;
        text-align: left;
    }

    .table th,
    .table td {
        border: 1px solid #000000;
        padding: 5px;
    }

    .margin-style {
        margin: 40px;
    }
</style>
<div class="margin-style">
    <p>
        <h3 style="text-align: center;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Laporan Pembelian <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?></h3>
    </p>
    <?php
    $query_pembelian = AktPembelian::find()->where(['BETWEEN', 'tanggal_pembelian', $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_pembelian ASC")->all();
    foreach ($query_pembelian as $key => $data) {
        # code...
    ?>
        <table class="table1">
            <thead>
                <tr>
                    <th>No. pembelian</th>
                    <th>Tanggal pembelian</th>
                    <th>Customer</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $data->no_pembelian ?></td>
                    <td><?= date('d/m/Y', strtotime($data->tanggal_pembelian)) ?></td>
                    <td><?= $data->customer->nama_mitra_bisnis ?></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 1%;">No</th>
                    <th>Nama Barang</th>
                    <th>Gudang</th>
                    <th style="width: 5%;">Qty</th>
                    <th style="width: 5%;">Harga</th>
                    <th style="width: 5%;white-space: nowrap;">Diskon %</th>
                    <th>Keterangan</th>
                    <th style="width: 5%;">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $totalan_sub_total = 0;
                $query_pembelian_detail = AktPembelianDetail::findAll(['id_pembelian' => $data->id_pembelian]);
                foreach ($query_pembelian_detail as $key => $dataa) {
                    # code...
                    $no++;
                    $retVal_id_item_stok = (!empty($dataa->id_item_stok)) ? $dataa->id_item_stok : 0;
                    $item_stok = AktItemStok::findOne($retVal_id_item_stok);
                    $retVal_id_item = (!empty($item_stok->id_item)) ? $item_stok->id_item : 0;
                    $item = AktItem::findOne($retVal_id_item);
                    $retVal_id_item_harga_jual = (!empty($dataa->id_item_harga_jual)) ? $dataa->id_item_harga_jual : 0;
                    $item_harga_jual = AktItemHargaJual::findOne($retVal_id_item_harga_jual);

                    $retVal_id_gudang = (!empty($item_stok->id_gudang)) ? $item_stok->id_gudang : 0;
                    $gudang = AktGudang::findOne($retVal_id_gudang);

                    $totalan_sub_total += $dataa->total;
                ?>
                    <tr>
                        <td><?= $no . '.' ?></td>
                        <td><?= $item->nama_item ?></td>
                        <td><?= $gudang->nama_gudang ?></td>
                        <td><?= $dataa->qty ?></td>
                        <td style="text-align: right;white-space: nowrap;"><?= ribuan($dataa->harga) ?></td>
                        <td><?= $dataa->diskon ?></td>
                        <td><?= $dataa->keterangan ?></td>
                        <td style="text-align: right;white-space: nowrap;"><?= ribuan($dataa->total) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7">Total</th>
                    <th style="text-align: right;"><?= ribuan($totalan_sub_total) ?></th>
                </tr>
            </tfoot>
        </table>
        <br>
    <?php } ?>

</div>

<script>
    window.print();
    setTimeout(window.close, 1000);
</script>