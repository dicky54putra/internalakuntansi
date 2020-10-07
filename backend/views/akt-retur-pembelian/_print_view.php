<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Retur Pembelian</title>
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
        <p align="center">RETUR PEMBELIAN</p>
    </b>
    <br>
    <table>
        <tr>
            <td colspan="10">
                <hr>
            </td>
        </tr>
        <tr>
            <td>No</td>
            <td>Kode Barang</td>
            <td>Nama Barang</td>
            <td>Qty</td>
            <td>Retur</td>
            <td>Harga</td>
            <td colspan="3">Keterangan</td>
            <td>Total</td>
        </tr>
        <tr>
            <td colspan="10">
                <hr>
            </td>
        </tr>
       <?php
        $no = 1;
        $grandtotal = 0;
        foreach ($detail_retur as $data) {
            $diskon = $data['harga'] * $data['diskon'] / 100;
            $total = $data['harga'] -  $diskon;
            $subTotal = $total * $data['retur'];
            $grandtotal += $subTotal ;
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['kode_item'] ?></td>
                <td><?= $data['nama_item'] ?></td>
                <td><?= $data['qty_pembelian'] ?></td>
                <td><?= $data['retur']?></td>
                <td><?= ribuan($total) ?></td>
                <td colspan="3"><?= $data['ket_retur'] ?></td>
                <td align="right"> <?=  ribuan($subTotal)?> </td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="10">
                <hr>
            </td>
        </tr>
        <tr> 
            <td colspan="8"></td>
            <td>Subtotal</td>
            <td align="right"><?= ribuan($grandtotal); ?></td>
        </tr>
    </table>
</body>
</html>
