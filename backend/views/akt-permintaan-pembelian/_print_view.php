<style>
    table {
        width: 100%;
    }
</style>
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
    <p align="center">PERMINTAAN PEMBELIAN</p>
</b>
<br>
<table>
    <tr>
        <td colspan="7">
            <hr>
        </td>
    </tr>
    <tr>
        <td>No</td>
        <td>Kode Barang</td>
        <td colspan="2">Nama Barang</td>
        <td align="right">Harga Satuan</td>
        <td align="right">Qty</td>
        <td align="right">Total</td>
    </tr>
    <tr>
        <td colspan="7">
            <hr>
        </td>
    </tr>
    <?php
    $no = 1;
    $dpp = 0;
    foreach ($daftar_item as $key => $v) {
    ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $v->item_stok->item["kode_item"] ?></td>
            <td colspan="2"><?= $v->item_stok->item["nama_item"] ?></td>
            <td align="right"><?= ribuan($v->item_stok["hpp"]) ?></td>
            <td align="right"><?= $v['quantity'] ?></td>
            <td align="right"><?php
                                $total = $v->item_stok["hpp"] * $v['quantity'];
                                echo ribuan($total);
                                ?>
            </td>
        </tr>
    <?php
        $dpp += $total;
    } ?>
    <tr>
        <td colspan="7"><br><br><br><br><br>
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <?php
            $pajak = 10 * $dpp / 100;
            $tagihan =  $pajak + $dpp;
            echo terbilang($tagihan);
            ?>
        </td>
        <td>Hormat Kami,</td>
        <td align="right">DPP</td>
        <td align="right"><?php
                            echo ribuan($dpp);
                            ?></td>
    </tr>
    <tr>
        <td colspan="6" align="right">PPN</td>
        <td align="right"><?php
                            echo ribuan($pajak);
                            ?>
        </td>
    </tr>
    <tr>
        <td>Penerima</td>
        <td>Gudang</td>
        <td colspan="2">Ekspedisi</td>
        <td><?= $setting->direktur ?></td>
        <td align="right"><b>Tagihan</b></td>
        <td align="right">
            <b>
                <?= ribuan($tagihan) ?>
            </b>
        </td>
    </tr>
</table>