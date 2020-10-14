<?php

use backend\models\AktPenjualan;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
?>
<p>
    <h3 style="text-align: center;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Laporan Penjualan <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?></h3>
</p>
<?php
$query_penjualan = AktPenjualan::find()->where(['BETWEEN', 'tanggal_penjualan', $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_penjualan ASC")->all();
foreach ($query_penjualan as $key => $data) {
    # code...
?>

    <style>
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
    </style>
    <table class="table1">
        <thead>
            <tr>
                <th>No. Penjualan</th>
                <th>Tanggal Penjualan</th>
                <th>Customer</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $data->no_penjualan ?></td>
                <td><?= date('d/m/Y', strtotime($data->tanggal_penjualan)) ?></td>
                <td><?= $data->customer->nama_mitra_bisnis ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table table-responsive table-bordered table-hover">
        <thead>
            <tr>
                <th style="width: 1%;">No</th>
                <th>Nama Barang</th>
                <th style="width: 5%;">Jenis</th>
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
            $query_penjualan_detail = AktPenjualanDetail::findAll(['id_penjualan' => $data->id_penjualan]);
            foreach ($query_penjualan_detail as $key => $dataa) {
                # code...
                $no++;
                $retVal_id_item_stok = (!empty($dataa->id_item_stok)) ? $dataa->id_item_stok : 0;
                $item_stok = AktItemStok::findOne($retVal_id_item_stok);
                $retVal_id_item = (!empty($item_stok->id_item)) ? $item_stok->id_item : 0;
                $item = AktItem::findOne($retVal_id_item);
                $retVal_id_item_harga_jual = (!empty($dataa->id_item_harga_jual)) ? $dataa->id_item_harga_jual : 0;
                $item_harga_jual = AktItemHargaJual::findOne($retVal_id_item_harga_jual);
                $retVal_id_level_harga = (!empty($item_harga_jual->id_level_harga)) ? $item_harga_jual->id_level_harga : 0;
                $level_harga = AktLevelHarga::findOne($retVal_id_level_harga);
                $retVal_id_gudang = (!empty($item_stok->id_gudang)) ? $item_stok->id_gudang : 0;
                $gudang = AktGudang::findOne($retVal_id_gudang);

                $totalan_sub_total += $dataa->total;
            ?>
                <tr>
                    <td><?= $no . '.' ?></td>
                    <td><?= $item->nama_item ?></td>
                    <td style="white-space: nowrap;"><?= $level_harga->keterangan ?></td>
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
                <th colspan="8" style="text-align: right;">Total</th>
                <th style="text-align: right;"><?= ribuan($totalan_sub_total) ?></th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: right;">Diskon 0 %</th>
                <th style="text-align: right;">
                    <?php
                    $diskon = ($data->diskon * $totalan_sub_total) / 100;
                    echo ribuan($diskon);
                    ?>
                </th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: right;">Pajak 10 % ()</th>
                <th style="text-align: right;">
                    <?php
                    $diskon = ($data->diskon * $totalan_sub_total) / 100;
                    $pajak_ = (($totalan_sub_total - $diskon) * 10) / 100;
                    $pajak = ($data->pajak == 1) ? $pajak_ : 0;
                    echo ribuan($pajak);
                    ?>
                </th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: right;">Ongkir</th>
                <th style="text-align: right;"><?= ribuan($data->ongkir) ?></th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: right;">Materai</th>
                <th style="text-align: right;"><?= ribuan($data->materai) ?></th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: right;">Uang Muka</th>
                <th style="text-align: right;"><?= ribuan($data->uang_muka) ?></th>
            </tr>
            <tr>
                <th colspan="8" style="text-align: right;">Grand Total</th>
                <th style="text-align: right;"><?= ribuan($data->total) ?></th>
            </tr>
        </tfoot>
    </table>
    <br>
<?php } ?>
<script>
    window.print();
    setTimeout(window.close, 1000);
</script>