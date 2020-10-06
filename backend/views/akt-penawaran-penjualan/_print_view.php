<style>
    table {
        width: 100%;
    }

    .table2 {
        border-collapse: collapse;
    }

    .thead_table2 {
        border: 1px solid #000000;
        padding: 5px;
        font-size: 13px;
    }

    .tbody_table2 {
        border-left: 1px solid #000000;
        border-right: 1px solid #000000;
        padding: 5px;
        font-size: 13px;
    }

    .tfoot_table2 {
        /* border: 1px solid #000000; */
        padding: 5px;
        font-size: 13px;
    }
</style>
<table>
    <tr>
        <td style="font-size: 20px;font-weight: bold;"><?= $setting->nama ?></td>
    </tr>
    <tr>
        <td>
            <p type="ntext"><?= $setting->alamat ?></p>
        </td>
    </tr>
    <tr>
        <td>Telp: <?= $setting->telepon ?></td>
    </tr>
    <tr>
        <td>NPWP: <?= $setting->npwp ?></td>
    </tr>
</table>
<table class="table2" border="0">
    <thead>
    	<tr>
    		<th colspan="8" style="padding: 5px;">PENAWARAN PENJUALAN</th>
    	</tr>
        <tr>
            <th class="thead_table2" style="width: 1px;">No.</th>
            <th class="thead_table2">Kode Barang</th>
            <th class="thead_table2">Nama Barang</th>
            <th class="thead_table2">Harga Satuan</th>
            <th class="thead_table2" style="width: 1px;">Qty</th>
            <th class="thead_table2">Diskon %</th>
            <th class="thead_table2">Keterangan</th>
            <th class="thead_table2">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $dpp = 0;
        foreach ($daftar_item as $key => $v) {
            if ($v['diskon'] > 0) {
                $total = ($v["harga"] * $v['qty']) - ($v["harga"] * $v['qty']) * $v['diskon'] / 100;
            } else {
                $total = $v["harga"] * $v['qty'];
            }
            $dpp += $total;
        ?>
            <tr>
                <td class="tbody_table2"><?= $no++ . '.' ?></td>
                <td class="tbody_table2"><?= $v->item_stok->item["kode_item"] ?></td>
                <td class="tbody_table2"><?= $v->item_stok->item["nama_item"] ?></td>
                <td class="tbody_table2" style="text-align: right;"><?= ribuan($v["harga"]) ?></td>
                <td class="tbody_table2"><?= $v['qty'] ?></td>
                <td class="tbody_table2"><?= $v["diskon"] ?>%</td>
                <td class="tbody_table2"><?= $v["keterangan"] ?></td>
                <td class="tbody_table2" style="text-align: right;"><?= ribuan($total) ?></td>
            </tr>
        <?php } ?>
        <?php
        for ($i = $count_daftar_item; $i < 10; $i++) {
            # code...
        ?>
            <tr>
                <td class="tbody_table2">&nbsp;</td>
                <td class="tbody_table2">&nbsp;</td>
                <td class="tbody_table2">&nbsp;</td>
                <td class="tbody_table2" style="text-align: right;">&nbsp;</td>
                <td class="tbody_table2">&nbsp;</td>
                <td class="tbody_table2">&nbsp;</td>
                <td class="tbody_table2">&nbsp;</td>
                <td class="tbody_table2" style="text-align: right;">&nbsp;</td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="tfoot_table2" colspan="5" style="padding-left: 5px;border-top: 1px solid #000000;"><?= terbilang($penawaran_penjualan->total) ?></td>
            <td class="tfoot_table2" align="center" style="border-top: 1px solid #000000;">Hormat Kami,</td>
            <td class="tfoot_table2" align="right" style="border-top: 1px solid #000000;">DPP</td>
            <td class="tfoot_table2" align="right" style="border-top: 1px solid #000000;"><?= ribuan($dpp) ?></td>
        </tr>
        <tr>
            <td class="tfoot_table2" colspan="7" align="right">Diskon</td>
            <td class="tfoot_table2" align="right">
                <?php
                $diskon = ($dpp * $penawaran_penjualan->diskon) / 100;
                echo ribuan($diskon);
                ?>
            </td>
        </tr>
        <tr>
            <td class="tfoot_table2" colspan="7" align="right">PPN</td>
            <td class="tfoot_table2" align="right">
                <?php
                $diskon = ($dpp * $penawaran_penjualan->diskon) / 100;
                $pajak = (($dpp - $diskon) * $penawaran_penjualan->pajak) / 100;
                echo ribuan($pajak);
                ?>
            </td>
        </tr>
        <tr>
            <td class="tfoot_table2" colspan="2" style="text-align: center;">Penerima</td>
            <td class="tfoot_table2" colspan="1" style="text-align: center;">Gudang</td>
            <td class="tfoot_table2" colspan="2" style="text-align: center;">Ekspedisi</td>
            <td class="tfoot_table2" style="text-align: center;"><?= $setting->direktur ?></td>
            <td class="tfoot_table2" align="right">Tagihan</td>
            <td class="tfoot_table2" align="right"><?= ribuan($penawaran_penjualan->total) ?></td>
        </tr>
    </tfoot>
</table>