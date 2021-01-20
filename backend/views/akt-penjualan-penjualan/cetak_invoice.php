<?php

use backend\models\AktPenjualanDetail;
use backend\models\AktPenjualanPengiriman;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktSatuan;
?>
<style>
    .table1 {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
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
        border: 1px solid #000000;
        font-size: 14px;
    }

    .table2 td {
        padding: 5px;
    }

    .table2 tbody {
        border-bottom: 1px solid #000000;
        border-left: 1px solid #000000;
        border-right: 1px solid #000000;
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
            <th class="header_kiri" style="font-size: 15px; font-weight: bold;" style="width: ;">
                <img width="150px" src="upload/<?= $data_setting->foto ?>" alt="">
                <!-- <?= $data_setting->nama ?> -->
            </th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th class="header_kiri" style="font-size: 13px; font-weight: bold;">
                <?= $data_setting->alamat . '<br>' . $data_setting->kota->nama_kota . ', Telp ' . $data_setting->telepon ?>
                <!-- <?= $data_setting->nama ?> -->
            </th>
            <th colspan="2" style="font-size: 15px; font-weight: bold;">FAKTUR PENJUALAN</th>
            <th class="header_kiri">No. Faktur</th>
            <th class="header_kiri">: <?= $model->no_faktur_penjualan ?></th>
        </tr>
        <tr>
            <th class="header_kiri"></th>
            <th class="header_kiri"></th>
            <th class="header_kiri"></th>
            <th class="header_kiri">Tanggal Penjualan</th>
            <th class="header_kiri">: <?= !empty($model->tanggal_penjualan) ? tanggal_indo($model->tanggal_penjualan) : null ?></th>
        </tr>
        <tr>
            <th class="header_kiri">Kepada Yth : </th>
            <th class="header_kiri"></th>
            <th class="header_kiri"></th>
            <?php
            if ($model->jenis_bayar == 1) {
                # code...
            ?>
                <th class="header_kiri">Jatuh Tempo</th>
                <th class="header_kiri">: <?= !empty($model->tanggal_faktur_penjualan) ? tanggal_indo($model->tanggal_faktur_penjualan) : null ?></th>
            <?php
            } elseif ($model->jenis_bayar == 2) {
                # code...
            ?>
                <th class="header_kiri">Jatuh Tempo</th>
                <th class="header_kiri">: <?= !empty($model->tanggal_tempo) ? tanggal_indo($model->tanggal_tempo) : null ?></th>
            <?php
            }
            ?>
        </tr>
        <tr>
            <th class="header_kiri"><?= (!empty($model->customer->nama_mitra_bisnis)) ? $model->customer->nama_mitra_bisnis : '' ?></th>
            <th class="header_kiri"></th>
            <th class="header_kiri"></th>
            <th class="header_kiri">No.SJ</th>
            <th class="header_kiri">:
                <?php
                $aktPenjualanPengiriman = AktPenjualanPengiriman::find()->where(['id_penjualan' => $model->id_penjualan])->one();
                echo $aktPenjualanPengiriman->no_pengiriman
                ?>
            </th>
        </tr>
        <tr>
            <th class="header_kiri"></th>
            <th class="header_kiri"></th>
            <th class="header_kiri"></th>
            <th class="header_kiri">Sales</th>
            <th class="header_kiri">: <?= $model->sales->nama_sales ?></th>
        </tr>
    </thead>
</table>
<table class="table2">
    <thead>
        <tr>
            <th style="width: 1%;">No</th>
            <th>Nama Barang</th>
            <th style="width: 5%;">Qty</th>
            <th style="width: 5%;">Satuan</th>
            <th style="width: 5%;">Harga</th>
            <th style="width: 5%;">Disc</th>
            <th style="width: 10%;">Sub Total</th>
            <th style="width: 10%;">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query_penjualan_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
        foreach ($query_penjualan_detail as $key => $data) {
            # code...
            $item_stok = AktItemStok::findOne($data['id_item_stok']);
            $item = AktItem::findOne($item_stok->id_item);
            $gudang = AktGudang::findOne($item_stok->id_gudang);
            $satuan = AktSatuan::findOne($item->id_satuan);
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                <td><?= (!empty($satuan->nama_satuan)) ? $data['qty'] : $data['qty'] ?></td>
                <td style="white-space: nowrap;"><?= $satuan->nama_satuan ?></td>
                <td style="white-space: nowrap;"><?= ribuan($data['harga']) ?></td>
                <td style="white-space: nowrap;">
                    <?php if ($data['jenis_diskon'] == 1) { ?>
                        <?= $data['diskon'] ?>%

                    <?php } else if ($data['jenis_diskon'] == 2) { ?>

                        <?= $data['diskon'] == null ? 0 :  $data['diskon'] ?>% | <?= $data['diskon2'] == null ? 0 :  $data['diskon2'] ?>% | <?= $data['diskon3'] == null ? 0 :  $data['diskon3'] ?>% | <?= $data['diskon4'] == null ? 0 :  $data['diskon4'] ?>% | <?= $data['diskon5'] == null ? 0 :  $data['diskon5'] ?>%

                    <?php } else { ?>

                        Rp. <?= ribuan($data['diskon']) ?>

                    <?php } ?>


                </td>
                <td style="text-align: right;">
                    <?php if ($data['jenis_diskon'] == 1) { ?>
                        <?php
                        $hasil_diskon = $data['harga'] - (($data['harga'] * $data['diskon']) / 100);
                        echo ribuan($hasil_diskon);
                        ?>

                    <?php } else if ($data['jenis_diskon'] == 2) { ?>

                        <?php
                        #1
                        $diskonBertingkat = $data['harga'] - (($data['harga'] * $data['diskon']) / 100);

                        #2
                        if ($data['diskon2'] > 0) {
                            # code...
                            $diskonBertingkat = $diskonBertingkat - (($diskonBertingkat * $data['diskon2']) / 100);
                        }

                        #3
                        if ($data['diskon3'] > 0) {
                            # code...
                            $diskonBertingkat = $diskonBertingkat - (($diskonBertingkat * $data['diskon3']) / 100);
                        }

                        #4
                        if ($data['diskon4'] > 0) {
                            # code...
                            $diskonBertingkat = $diskonBertingkat - (($diskonBertingkat * $data['diskon4']) / 100);
                        }

                        #5
                        if ($data['diskon5'] > 0) {
                            # code...
                            $diskonBertingkat = $diskonBertingkat - (($diskonBertingkat * $data['diskon5']) / 100);
                        }

                        echo ribuan($diskonBertingkat);
                        ?>

                    <?php } else { ?>

                        <?= ribuan($data['diskon']) ?>

                    <?php } ?>
                </td>
                <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<table class="table3" border="0">
    <thead>
        <tr>
            <th colspan="3" style="text-align: left; font-size: 13px;">Terbilang:</th>
            <th style="text-align: center;"></th>
            <th style="text-align: left;">DPP</th>
            <th><?= ribuan($total_penjualan_barang) ?></th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: left; font-size: 13px;">**<?= terbilang($model->total) ?>**</th>
            <?php
            $diskon = ($model->diskon * $total_penjualan_barang) / 100;
            $pajak_ = (($total_penjualan_barang - $diskon) * 10) / 100;
            // $pajak = ($model->pajak == 1) ? $pajak_ : 0;
            $pajak = $pajak_;
            ?>
            <th style="border-bottom: 1px solid #000000;text-align: left;">Pajak</th>
            <th style="border-bottom: 1px solid #000000;"><?= ribuan($pajak); ?></th>
        </tr>
        <?php
        if ($model->diskon > 0) {
            # code...
        ?>
            <tr>
                <th rowspan="4" colspan="4"></th>
                <th style="text-align: left;">Diskon <?= $model->diskon ?>%</th>
                <th>
                    <?php
                    $diskon = ($model->diskon * $total_penjualan_barang) / 100;
                    echo ribuan($diskon);
                    ?>
                </th>
            </tr>
        <?php } else {
            # jumlah rowspan
            $cekValOngkir = ($model->ongkir > 0) ? 1 : 0;
            $cekValMaterai = ($model->materai > 0) ? 1 : 0;
            $cekValUangMuka = ($model->uang_muka > 0) ? 1 : 0;
            $penjumlahanCek = $cekValOngkir + $cekValMaterai + $cekValUangMuka + 1;
        ?>
            <tr>
                <th rowspan="<?= $penjumlahanCek ?>" colspan="4"></th>
                <th></th>
                <th>

                </th>
            </tr>
        <?php } ?>
        <?php
        if ($model->ongkir > 0) {
            # code...
        ?>
            <tr>
                <th style="text-align: left;">Ongkir</th>
                <th><?= ribuan($model->ongkir) ?></th>
            </tr>
        <?php } ?>
        <?php
        if ($model->materai > 0) {
            # code...
        ?>
            <tr>
                <th style="text-align: left;">Materai</th>
                <th><?= ribuan($model->materai) ?></th>
            </tr>
        <?php } ?>
        <?php
        if ($model->uang_muka > 0) {
            # code...
        ?>
            <tr>
                <th style="text-align: left;">Uang Muka</th>
                <th><?= ribuan($model->uang_muka) ?></th>
            </tr>
        <?php } ?>
        <tr>
            <th style="text-align: center; font-size: 15px;">Keuangan</th>
            <th style="text-align: center; font-size: 15px;"></th>
            <th style="text-align: center; font-size: 15px;">Penagihan</th>
            <th style="text-align: center; font-size: 15px;"></th>
            <th style="font-weight: bold; font-size: 15px;text-align: center;">Total</th>
            <?php $grandtotal = $total_penjualan_barang + $model->ongkir + $pajak - ($diskon + $retValUangMuka = ($model->uang_muka > 0) ? $model->uang_muka : 0) ?>
            <th style="font-weight: bold; font-size: 15px;"><?= ribuan($grandtotal) ?></th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    window.print();
    setTimeout(window.close, 500);
</script>