<?php

use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktSatuan;
use backend\models\AktMitraBisnisBankPajak;
?>
<style type="text/css">
    .table1 {
        width: 100%;
        border-collapse: collapse;
        /*font-family: Arial;*/
        font-size: 15px;
    }

    .table1 th {
        text-align: left;
        padding: 5px;
    }

    .header_kiri {
        width: 25%;
    }

    .header_kanan {
        width: 15%;
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
        font-family: Arial;
    }

    .table2 th {
        padding: 5px;
        border-bottom: 1px solid #000000;
    }

    .table2 td {
        padding: 5px;
    }

    .table3 {
        border-collapse: collapse;
        width: 100%;
        font-size: 15px;
    }

    .table3,
    .table3 th {
        border: 0px solid #000000;
    }

    .table3 th {
        padding: 5px;
    }

    .header_kiri {
        text-align: left;
    }

    .table4 {
        width: 100%;
    }

    @media print {
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0mm;
            /* this affects the margin in the printer settings */
        }
    }
</style>
<table class="table3">
    <thead>
        <tr>
            <th class="header_kiri" style="font-size: 15px; font-weight: bold;"><?= $data_setting->nama ?></th>
        </tr>
        <tr>
            <th class="header_kiri"><?= $data_setting->nama_usaha ?></th>
        </tr>
        <tr>
            <th class="header_kiri"><?= $data_setting->alamat ?></th>
        </tr>
        <tr>
            <th class="header_kiri">Telp : <?= $data_setting->telepon ?>, Fax : <?= $data_setting->fax ?></th>
        </tr>
        <tr>
            <th class="header_kiri">NPWP : <?= $data_setting->npwp ?></th>
        </tr>
    </thead>
</table>
<center>
    <h3>Purchase Order</h3>
</center>
<hr>
<table class="table1" border="0">
    <thead>
        <tr>
            <th class="header_kiri">No. Order Pembelian</th>
            <th style="width: 1%;">:</th>
            <th><?= $model->no_order_pembelian ?></th>
            <th class="header_kanan">Jenis Bayar</th>
            <th>:</th>
            <th><?= ($model->jenis_bayar == 1) ? 'Cash' : 'Credit'; ?></th>
        </tr>
        <tr>
            <th class="header_kiri">Tanggal Order</th>
            <th>:</th>
            <th><?= tanggal_indo($model->tanggal_order_pembelian, true) ?></th>
            <th class="header_kanan">Status</th>
            <th>:</th>
            <th><?= ($model->status == 1) ? 'Order Pembelian' : $retVal = ($model->status == 2) ? 'Pembelian' : $retVal = ($model->status == 3) ? 'Penerimaan' : 'Diterima'; ?></th>
        </tr>
        <tr>
            <th class="header_kiri">Supplier</th>
            <th>:</th>
            <th><?= $model->customer->nama_mitra_bisnis ?></th>
            <?php
            if ($model->jenis_bayar == 1) {
            } else {
            ?>
                <th class="header_kanan">Jatuh Tempo</th>
                <th>:</th>
                <th><?= ($model->jenis_bayar == 2) ? $model->jatuh_tempo . ' hari' : ''; ?></th>
            <?php } ?>
        </tr>
        <tr>
            <th class="header_kanan">Mata Uang</th>
            <th>:</th>
            <th><?= $model->mata_uang->mata_uang ?></th>
        </tr>
        <tr>
            <th class="header_kanan">NPWP</th>
            <th>:</th>
            <?php
            $id = $model->customer->id_mitra_bisnis;
            $akt_bank_pajak = Yii::$app->db->createCommand("SELECT npwp FROM akt_mitra_bisnis_bank_pajak WHERE id_mitra_bisnis = '$id'")->queryScalar();
            ?>
            <th> <?= $akt_bank_pajak == false ? 'Data Kosong' : $akt_bank_pajak ?></th>
        </tr>
    </thead>
</table>
<hr>
<table class="table2">
    <thead>
        <tr>
            <th style="width: 1%;">#</th>
            <th style="width: 10%;">Jumlah</th>
            <th style="width: 13%;">Kode Barang</th>
            <th>Nama Barang</th>
            <th style="text-align: right;">Harga Satuan</th>
            <th style="text-align: center; width: 10%;">Diskon %</th>
            <th style="text-align: right;">Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $totalan_total = 0;
        $totalan_sub_total = 0;
        $query_pembelian_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
        foreach ($query_pembelian_detail as $key => $data) {
            # code...
            $item_stok = AktItemStok::findOne($data['id_item_stok']);
            $item = AktItem::findOne($item_stok->id_item);
            $gudang = AktGudang::findOne($item_stok->id_gudang);
            $satuan = AktSatuan::findOne($item->id_satuan);

            $totalan_total += $data['total'];
            $totalan_sub_total += $data['total'];
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= (!empty($satuan->nama_satuan)) ? $data['qty'] . ' ' . $satuan->nama_satuan : $data['qty'] ?></td>
                <td><?= (!empty($item->kode_item)) ? $item->kode_item : '' ?></td>
                <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                <td style="text-align: right;"><?= ribuan($data['harga']) ?></td>
                <td style="text-align: center;"><?= $data['diskon'] ?></td>
                <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align: right;">Total</th>
            <th style="text-align: right;"><?= ribuan($totalan_total) ?></th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: right;">Diskon <?= $model->diskon ?> %</th>
            <th style="text-align: right;">
                <?php
                $diskon = ($model->diskon * $totalan_total) / 100;
                echo ribuan($diskon);
                ?>
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: right;">Pajak 10 %</th>
            <th style="text-align: right;">
                <?php
                $diskon = ($model->diskon * $totalan_total) / 100;
                $pajak_ = (($totalan_total - $diskon) * 10) / 100;
                $pajak = ($model->pajak == 1) ? $pajak_ : 0;
                echo ribuan($pajak);
                ?>
            </th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: right;">Ongkir</th>
            <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: right;">Materai</th>
            <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: right;">Uang Muka</th>
            <th style="text-align: right;"><?= ribuan($model->uang_muka) ?></th>
        </tr>
        <tr>
            <th colspan="6" style="text-align: right;">Grand Total</th>
            <th style="text-align: right;"><?= ribuan($model->total) ?></th>
        </tr>
    </tfoot>
</table>
<hr>
<script type="text/javascript">
    window.print();
    // setTimeout(window.close, 500);
</script>