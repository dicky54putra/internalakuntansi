<?php

use backend\models\AktPenjualanDetail;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Retur Penjualan</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>

<body width="100%;">
    <table>
        <tr>
            <td>
                <h2><?= $setting->nama ?></h2>
            </td>
        </tr>
        <tr>
            <td>
                <p type="ntext"><?= $setting->alamat ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Telp: <?= $setting->telepon ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>NPWP: <?= $setting->npwp ?></p>
            </td>
        </tr>
    </table>
    <br>
    <b>
        <p align="center">RETUR PENJUALAN</p>
    </b>
    <br>
    <table>
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>
        <tr>
            <td>No</td>
            <td>Kode Barang</td>
            <td>Nama Barang</td>
            <td>Qty Dikirim</td>
            <td>Retur</td>
            <td>Keterangan</td>
        </tr>
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>
        <?php
        $no = 1;
        foreach ($model_detail as $data) {
            $penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::findOne($data->id_penjualan_pengiriman_detail);
            $penjualan_detail = AktPenjualanDetail::findOne($penjualan_pengiriman_detail->id_penjualan_detail);
            $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
            $item = AktItem::findOne($item_stok->id_item);
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= $item->kode_item ?></td>
                <td><?= $item->nama_item ?></td>
                <td><?= $data->qty ?></td>
                <td><?= $data->retur ?></td>
                <td><?= $data->keterangan ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan=6>
                <hr>
            </td>
        </tr>
    </table>
</body>

</html>