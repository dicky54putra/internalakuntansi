<?php

use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktSatuan;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
use backend\models\AktMitraBisnisAlamat;
?>
<style>
    .table,
    .table td {
        border: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }

    .table,
    .table th {
        border: 1px solid #000000;
        padding: 5px;
        text-align: center;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        padding: 10px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .table th,
    .table td {
        padding: 5px;
    }

    .table2 {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-size: 14px;
        border-collapse: collapse;
        width: 100%;
        padding: 10px;
    }

    .table2 th,
    .table2 td {
        padding: 2px;
        text-align: left;
    }

    .table3 {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-size: 14px;
        border-collapse: collapse;
        width: 100%;
        padding: 10px;
    }

    .table3 th,
    .table3 td {
        padding: 2px;
    }
</style>
<p>
    <h3 style="text-align: center;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Surat Pesanan</h3>
</p>
<table class="table3">
    <thead>
        <tr>
            <th style="text-align: right;">Sales</th>
            <th style="text-align: left;width: 15%;white-space: nowrap;">: <?= (!empty($model->sales->nama_sales)) ? $model->sales->nama_sales : '' ?></th>
        </tr>
        <tr>
            <th style="text-align: right;">Tanggal</th>
            <th style="text-align: left;width: 15%;white-space: nowrap;">: <?= !empty($model->tanggal_order_penjualan) ? tanggal_indo($model->tanggal_order_penjualan, false) : tanggal_indo($model->tanggal_penjualan, false) ?></th>
        </tr>
        <tr>
            <th style="text-align: right;">No. PO</th>
            <th style="text-align: left;width: 15%;white-space: nowrap;">: <?= !empty($model->no_order_penjualan) ? $model->no_order_penjualan : $model->no_penjualan ?></th>
        </tr>
    </thead>
</table>
<table class="table2">
    <thead>
        <tr>
            <th>Up :</th>
        </tr>
        <tr>
            <td><?= $model_customer->nama_mitra_bisnis ?></td>
        </tr>
        <tr>
            <th>Alamat Kantor :</th>
        </tr>
        <tr>
            <td>
                <?php
                $alamat = array();
                foreach ($model_customer_alamat as $key => $value) {
                    # code...
                    $alamat[] = $value['keterangan_alamat'] . ', ' . $value['alamat_lengkap'];
                }
                $hasil_alamat = implode("<br>", $alamat);
                echo $hasil_alamat;
                ?>
            </td>
        </tr>
        <tr>
            <th>Alamat Pengiriman :</th>
        </tr>
        <tr>
            <td>
                <?php
                $alamat_pengantaran = array();
                foreach ($model_penjualan_pengiriman as $key => $value) {
                    # code...
                    $mitra_bisnis_alamat = AktMitraBisnisAlamat::findOne($value['id_mitra_bisnis_alamat']);
                    $alamat_pengantaran[] = $mitra_bisnis_alamat['keterangan_alamat'] . '<br>' . $mitra_bisnis_alamat['alamat_lengkap'] . '<br> Telp/Fax : ' . $mitra_bisnis_alamat['telephone'] . ' / ' . $mitra_bisnis_alamat['fax'];
                }
                $hasil_alamat_pengantaran = implode("<br>", $alamat_pengantaran);
                echo $hasil_alamat_pengantaran;
                ?>
            </td>
        </tr>
        <tr>
            <th>No. NPWP :</th>
        </tr>
        <tr>
            <td>
                <?php
                $npwp = array();
                foreach ($model_customer_bank_pajak as $key => $value) {
                    # code...
                    $npwp[] = $value['npwp'];
                }
                $hasil_npwp = implode("<br>", $npwp);
                echo $hasil_npwp;
                ?>
            </td>
        </tr>
    </thead>
</table>
<br>
<table class="table">
    <thead>
        <tr>
            <th style="width: 1%;">No.</th>
            <th style="width: 20%;">Nama Barang</th>
            <th style="width: 10%;">Satuan</th>
            <th style="width: 5%;">Qty</th>
            <th style="width: 10%;">Harga</th>
            <th style="width: 10%;">Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $totalan_total = 0;
        $query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
        foreach ($query_detail as $key => $data) {
            # code...
            $item_stok = AktItemStok::findOne($data['id_item_stok']);
            $retVal_id_item = (!empty($item_stok->id_item)) ? $item_stok->id_item : 0;
            $item = AktItem::findOne($retVal_id_item);
            $retVal_id_gudang = (!empty($item_stok->id_gudang)) ? $item_stok->id_gudang : 0;
            $gudang = AktGudang::findOne($retVal_id_gudang);
            $harga_jual = AktItemHargaJual::findOne($data['id_item_harga_jual']);
            $retVal_id_level_harga = (!empty($harga_jual->id_level_harga)) ? $harga_jual->id_level_harga : 0;
            $level_harga = AktLevelHarga::findOne($retVal_id_level_harga);
            $retVal_id_satuan = (!empty($item->id_satuan)) ? $item->id_satuan : 0;
            $satuan = AktSatuan::findOne($retVal_id_satuan);

            $totalan_total += $data['total'];
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                <td style="text-align: center;"><?= (!empty($satuan->nama_satuan)) ? $satuan->nama_satuan : '' ?></td>
                <td style="text-align: center;"><?= $data['qty'] ?></td>
                <td style="text-align: right;"><?= ribuan($data['harga']) ?></td>
                <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" style="text-align: right;">Total</th>
            <th style="text-align: right;"><?= ribuan($totalan_total) ?></th>
        </tr>
    </tfoot>
</table>
<script>
    window.print();
    setTimeout(window.close, 500);
</script>