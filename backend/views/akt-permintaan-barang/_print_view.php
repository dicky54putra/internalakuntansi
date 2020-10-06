<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Permintaan Barang</title>
    <style>
        /* .table-content td {
            border: 1px solid black;
        } */
    </style>
</head>
<body>
<table width="100%">
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
<b><p align="center">PERMINTAAN BARANG</p></b>
<br>

<table width="100%" class="table-content">
    <tr>
        <td colspan="9">
            <hr>
        </td>
    </tr>
    <tr>
        <td>No</td>
        <td>Kode Barang</td>
        <td colspan="2">Nama Barang</td>
        <td align="right">Qty</td>
        <td align="right">Qty Ordered</td>
        <td align="right">Qty Rejected</td>
    </tr>
    <tr>
        <td colspan="9">
            <hr>
        </td>
    </tr>
    <?php
    $no = 1;
    foreach ($daftar_permintaan as $item) {
    ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $item['kode_item'] ?></td>
            <td colspan="2"><?= $item['nama_item'] ?></td>
            <td align="right"><?= $item['qty'] ?></td>
            <td align="right"><?= $item['qty_ordered'] ?></td>
            <td align="right"><?= $item['qty_rejected'] ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>