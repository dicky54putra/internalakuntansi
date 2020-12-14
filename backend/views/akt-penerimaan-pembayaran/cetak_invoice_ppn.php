<?php

use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktMitraBisnisBankPajak;
use backend\models\AktSatuan;
?>
<style>
    .table1 {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    .table1,
    .table1 th {
        border: 0px solid #000000;
    }

    .table1 th {
        padding: 5px;
    }

    .header_kiri {
        text-align: left;
    }

    hr {
        border: 1px solid black;
    }

    .table2,
    .table2 td {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table2,
    .table2 th {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table2 {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
    }

    .table2 th {
        padding: 5px;
        border-bottom: 1px solid #000000;
    }

    .table2 td {
        padding: 5px;
    }

    .table3 th {
        text-align: right;
        border-collapse: collapse;
        padding: 5px;
    }

    .table3 {
        border-collapse: collapse;
        font-size: 12px;
        width: 100%;
    }

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }
    }
</style>
<table class="table1">
    <thead>
        <tr>
            <th align="left" rowspan="3"> <?= $data_setting->nama_usaha ?><br><?= $data_setting->alamat ?><br>
                <?= $retVal = (!empty($data_setting->kota->nama_kota)) ? $data_setting->kota->nama_kota . ', Telp ' . $data_setting->telepon  : 'Telp ' . $data_setting->telepon; ?><br>
                NPWP: <?= $data_setting->npwp ?></th>
            <th align="center" rowspan="3" style="vertical-align: middle; width:50%;">FAKTUR PENJUALAN</th>
            <th class="header_kiri">Nomor Invoice</th>
            <th class="header_kiri">: <?= $model->no_penjualan ?></th>
        </tr>
        <tr align="left">
            <th class="header_kiri" align="right">Tanggal Penjualan</th>
            <th class="header_kiri">: <?= tanggal_indo($model->tanggal_penjualan) ?></th>
        </tr>
        <tr align="left">
            <th class="header_kiri">Jatuh Tempo</th>
            <th class="header_kiri">: <?= !empty($model->tanggal_tempo) ?  tanggal_indo($model->tanggal_tempo) : "" ?></th>
        </tr>
        <tr align="left">
            <th colspan="2"></th>
            <th class="header_kiri">Sales</th>
            <th class="header_kiri">: <?= (!empty($model->sales->nama_sales)) ? $model->sales->nama_sales : '' ?></th>
        </tr>
        <tr>
            <th colspan="5"></th>
        </tr>
        <tr align="left">
            <th>Kepada Yth. </th>
        </tr>
        <tr align="left">
            <th class="header_kiri">
                <?= (!empty($model->customer->nama_mitra_bisnis)) ? $model->customer->nama_mitra_bisnis : '' ?>
                <br>
                <?php
                $npwp = AktMitraBisnisBankPajak::find()->where(['id_mitra_bisnis' => $model->customer->id_mitra_bisnis])->one();
                ?>
                <?= (!empty($model->customer->alamat->alamat_lengkap)) ? $model->customer->alamat->alamat_lengkap . '<br>' : '' ?>
                <?= (!empty($npwp->npwp)) ? 'NPWP: ' . $npwp->npwp  : ''  ?>
            </th>
        </tr>
    </thead>
</table>
<hr>
<table class="table2">
    <thead>
        <tr>
            <th style="width: 1%;">#</th>
            <th style="width: 13%;">Kode Barang</th>
            <th>Nama Barang</th>
            <th style="width: 10%;">Jumlah</th>
            <th style="text-align: right;">Harga Satuan</th>
            <th style="text-align: center; width: 10%;">Diskon %</th>
            <th style="text-align: right;">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query_penjualan_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
        $dpp = 0;
        foreach ($query_penjualan_detail as $key => $data) {
            # code...
            $item_stok = AktItemStok::findOne($data['id_item_stok']);
            $item = AktItem::findOne($item_stok->id_item);
            $gudang = AktGudang::findOne($item_stok->id_gudang);
            $satuan = AktSatuan::findOne($item->id_satuan);
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= (!empty($item->kode_item)) ? $item->kode_item : '' ?></td>
                <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                <td><?= (!empty($satuan->nama_satuan)) ? $data['qty'] . ' ' . $satuan->nama_satuan : $data['qty'] ?></td>
                <td style="text-align: right;">
                    <?php
                    $pajak_harga = $data['harga'] + (0.1 * $data['harga']);
                    $diskon_per_barang = $data['diskon'] / 100 * $pajak_harga;
                    $total_per_barang =  ($pajak_harga - $diskon_per_barang) * $data['qty'];
                    $dpp += $total_per_barang;
                    echo ribuan($pajak_harga)
                    ?>
                </td>
                <td style="text-align: center;"><?= $data['diskon'] ?></td>
                <td style="text-align: right;"><?= ribuan($total_per_barang) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<hr>
<table class="table3" border="0">
    <thead>
        <tr>
            <th style="text-align: left; font-size: 13px;" colspan="3"> Terbilang<br /><br /><span style="max-width:200px;"> <?= terbilang($model->total) ?> </span></th>
            <?php
            $model->diskon != 0 ?    $diskon = $total_penjualan_barang - ($model->diskon / 100 * $total_penjualan_barang) : $diskon = 0;
            ?>
            <th>
                <table class="table3">
                    <tr>
                        <th>DPP</th>
                        <th><?= ribuan($dpp) ?></th>
                    </tr>
                    <?php if ($model->diskon != 0) { ?>
                        <tr>
                            <th>Diskon <?= $model->diskon ?>%</th>
                            <th>
                                <?php
                                echo ribuan($diskon);
                                ?>
                            </th>
                        </tr>
                    <?php } ?>
                    <?php if ($model->ongkir != 0) { ?>
                        <tr>
                            <th>Ongkir </th>
                            <th> <?= ribuan($model->ongkir) ?></th>
                        </tr>
                    <?php } ?>
                    <?php if ($model->materai != 0) { ?>
                        <tr>
                            <th>Materai </th>
                            <th> <?= ribuan($model->materai) ?></th>
                        </tr>
                    <?php } ?>
                    <?php if ($model->uang_muka != 0) { ?>
                        <tr>
                            <th>Uang Muka </th>
                            <th> <?= ribuan($model->uang_muka) ?></th>
                        </tr>
                    <?php } ?>
                    <?php if ($sum_retur != 0) { ?>
                        <tr>
                            <th>Total Retur </th>
                            <th> <?= ribuan($sum_retur) ?></th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th style="font-weight: bold; font-size: 15px;">Tagihan</th>
                        <th style="font-weight: bold; font-size: 15px;"><?= ribuan($dpp  + $model->ongkir - $diskon - $model->uang_muka - $sum_retur) ?></th>
                    </tr>
                </table>
            </th>
        </tr>
        <tr style="padding-top: 30px;">
            <td colspan="3"></td>
            <th style="text-align: center; font-size: 15px;">Hormat Kami</th>
        </tr>
        <tr>
            <td><br /> <br /> <br /> <br /><br /> <br /></td>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 15px;">PENERIMA</th>
            <th style="text-align: center; font-size: 15px;">BAG. GUDANG</th>
            <th style="text-align: center; font-size: 15px;">EKSPEDISI</th>
            <th style="text-align: center; font-size: 15px;">DIREKTUR</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    window.print();
    // setTimeout(window.close, 500);
</script>