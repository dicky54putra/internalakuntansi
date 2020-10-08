<?php

use backend\controllers\AktPembelianPenerimaanController;
use backend\models\AktPembelianDetail;
use backend\models\AktPembelianPenerimaanDetail;
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
        width: 10%;
    }

    .nomor_tanggal {
        width: 1%;
    }

    .kiri_nomor_tanggal {
        width: 25%;
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

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }
    }

    .margin-style {
        margin: 40px;
    }
</style>
<div class="margin-style">
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
    <br>
    <table class="table4">
        <thead>
            <tr>
                <th style="width: 1%;">No</th>
                <th style="width: 10%;white-space: nowrap;">Kode Barang</th>
                <th>Nama Barang</th>
                <th style="width: 10%;white-space: nowrap;">Qty Dikirim</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $angka = 0;
            $pembelian_pengiriman_detail = AktPembelianPenerimaanDetail::findAll(['id_pembelian_penerimaan' => $model->id_pembelian_penerimaan]);
            $count_pembelian_penerimaan_detail = AktPembelianPenerimaanDetail::find()->where(['id_pembelian_penerimaan' => $model->id_pembelian_penerimaan])->count();
            foreach ($pembelian_pengiriman_detail as $key => $dataa) {
                # code...
                $angka++;
                $retVal_id_pembelian_detail = (!empty($dataa->id_pembelian_detail)) ? $dataa->id_pembelian_detail : 0;
                $pembelian_detail = AktPembelianDetail::findOne($retVal_id_pembelian_detail);
                $retVal_id_item_stok = (!empty($pembelian_detail->id_item_stok)) ? $pembelian_detail->id_item_stok : 0;
                $item_stok = AktItemStok::findOne($retVal_id_item_stok);
                $retVal_id_item = (!empty($item_stok->id_item)) ? $item_stok->id_item : 0;
                $item = AktItem::findOne($retVal_id_item);
            ?>
                <tr>
                    <td><?= $angka . '.' ?></td>
                    <td><?= (!empty($item->kode_item)) ? $item->kode_item : '' ?></td>
                    <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                    <td style="text-align: center;"><?= $dataa->qty_diterima ?></td>
                    <td><?= $dataa->keterangan ?></td>
                </tr>
            <?php } ?>
            <?php
            for ($i = $count_pembelian_penerimaan_detail; $i < 10; $i++) {
                # code...
            ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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

</div>

<script>
    window.print();
    setTimeout(window.close, 1000);
</script>