<?php

use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktSatuan;
?>
<style>
    .table1 {
        border: 0px solid #000000;
        width: 100%;
        font-size: 15px;
        text-align: left;
    }

    .table2 {
        border: 0px solid #000000;
        width: 100%;
    }

    .table2 th {
        text-align: center;
    }

    .table3 {
        border: 0px solid #000000;
        width: 100%;
        text-align: left;
    }

    .table3 th,
    .table3 td {
        border: 0px solid #000000;
    }

    .titik2 {
        width: 1%;
    }

    .nomor_tanggal {
        width: 5%;
    }

    .kiri_nomor_tanggal {
        width: 60%;
        font-size: 15px;
    }

    .table4,
    .table4 td {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table4,
    .table4 th {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table4 {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
    }

    .table4 th,
    .table4 td {
        padding: 5px;
        border-bottom: 1px solid #000000;
    }

    hr {
        border: 1px solid black;
    }

    .ptext {
        margin-top: -15px;
        font-weight: bold;
        font-size: 14px;
    }

    .table5 {
        width: 100%;
    }

    .table5 th {
        padding: 5px;
        text-align: center;
    }
</style>
<table class="table1">
    <thead>
        <tr>
            <th><?= $data_setting->nama ?></th>
        </tr>
        <tr>
            <th><?= $data_setting->alamat ?></th>
        </tr>
        <tr>
            <th>Telephone : <?= $data_setting->telepon ?></th>
        </tr>
    </thead>
</table>
<table class="table2">
    <thead>
        <tr>
            <th>
                <h3>SURAT PENGANTAR BARANG</h3>
            </th>
        </tr>
    </thead>
</table>
<table class="table3">
    <thead>
        <tr>
            <th colspan="4">Kepada Yth.</th>
        </tr>
        <tr>
            <th class="kiri_nomor_tanggal"><?= $model->customer->nama_mitra_bisnis ?></th>
            <th class="nomor_tanggal">Nomor</th>
            <th class="titik2">:</th>
            <th><?= $model->no_spb ?></th>
        </tr>
        <tr>
            <th class="kiri_nomor_tanggal"><?= (!empty($model->mitra_bisnis_alamat->keterangan_alamat)) ? $model->mitra_bisnis_alamat->keterangan_alamat : '' ?></th>
            <th class="nomor_tanggal">Tanggal</th>
            <th class="titik2">:</th>
            <th><?= date('d/m/Y') ?></th>
        </tr>
        <tr>
            <th class="kiri_nomor_tanggal"><?= (!empty($model->mitra_bisnis_alamat->kota->nama_kota)) ? $model->mitra_bisnis_alamat->kota->nama_kota : '' ?></th>
        </tr>
        <tr>
            <th class="kiri_nomor_tanggal">Telephone : <?= (!empty($model->mitra_bisnis_alamat->telephone)) ? $model->mitra_bisnis_alamat->telephone : '' ?></th>
        </tr>
    </thead>
</table>
<br>
<table class="table4">
    <thead>
        <tr>
            <th style="width: 1%;">#</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Qty</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query_pembelian_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
        foreach ($query_pembelian_detail as $key => $data) {
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
                <td><?= $data['qty'] ?></td>
                <td><?= (!empty($satuan->nama_satuan)) ? $satuan->nama_satuan : '' ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<br>
<br>
<!-- <hr> -->
<p class="ptext">
    Barang tersebut di atas telah diserahkan dan diterima pihak pembeli dalam kondisi yang baik.
</p>
<table class="table5">
    <thead>
        <tr>
            <th>Hormat Kami,</th>
            <th style="width: 60%;">&nbsp;</th>
            <th>Yang Menerima,</th>
        </tr>
        <tr>
            <th style="height: 60px;"></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th>________________</th>
            <th></th>
            <th>________________</th>
        </tr>
    </thead>
</table>
<script>
    // window.print();
</script>