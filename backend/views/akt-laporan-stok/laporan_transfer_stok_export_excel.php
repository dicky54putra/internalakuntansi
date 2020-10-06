<?php

use backend\models\AktTransferStok;
use backend\models\AktTransferStokDetail;
use backend\models\AktGudang;
use backend\models\AktItem;

$tanggal_awal = $_GET['tanggal_awal'];
$tanggal_akhir = $_GET['tanggal_akhir'];
$id_gudang_asal = $_GET['id_gudang_asal'];
$id_gudang_tujuan = $_GET['id_gudang_tujuan'];
?>
<style>
    .table,
    .table td,
    .table th {
        border: 1px solid #888888;
        text-align: center;
        font-size: 12px;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th,
    .table td {
        padding: 5px;
    }

    .tabel {
        font-size: 12px;
    }

    .tabel th {
        text-align: left;
    }

    .tabel td {
        text-align: left;
    }

    .tabel th,
    .tabel td {
        padding: 5px;
    }
</style>
<?php
$where_gudang_asal = "";
if ($id_gudang_asal != "") {
    # code...
    $where_gudang_asal = " AND id_gudang_asal = " . $id_gudang_asal . " ";
}
$where_gudang_tujuan = "";
if ($id_gudang_tujuan != "") {
    # code...
    $where_gudang_tujuan = " AND id_gudang_tujuan = " . $id_gudang_tujuan . " ";
}
$query_transfer_stok = AktTransferStok::find()->where("tanggal_transfer BETWEEN '$tanggal_awal' AND '$tanggal_akhir' $where_gudang_asal $where_gudang_tujuan")->orderBy("no_transfer ASC")->asArray()->all();
foreach ($query_transfer_stok as $key => $data) {
    # code...
    $gudang_asal_header = AktGudang::findOne($data['id_gudang_asal']);
    $gudang_tujuan_header = AktGudang::findOne($data['id_gudang_tujuan']);
?>

    <table class="tabel" border="0">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal Transfer</th>
                <th style="width: 1%;">:</th>
                <td style="width: 20%;"><?= tanggal_indo($data['tanggal_transfer'], true) ?></td>
                <th style="width: 15%;">Gudang Asal</th>
                <th style="width: 1%;">:</th>
                <td><?= $gudang_asal_header->nama_gudang ?></td>
            </tr>
            <tr>
                <th>No Transfer</th>
                <th>:</th>
                <td><?= $data['no_transfer'] ?></td>
                <th>Gudang Tujuan</th>
                <th>:</th>
                <td><?= $gudang_tujuan_header->nama_gudang ?></td>
            </tr>
        </thead>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query_transfer_stok_detail = AktTransferStokDetail::find()->where(['id_transfer_stok' => $data['id_transfer_stok']])->all();
            foreach ($query_transfer_stok_detail as $key => $dataa) {
                # code...
                $item = AktItem::findOne($dataa['id_item']);
            ?>
                <tr>
                    <td><?= $no++ . '.' ?></td>
                    <td><?= $item->nama_item ?></td>
                    <td><?= $dataa['qty'] ?></td>
                    <td><?= $item->satuan->nama_satuan ?></td>
                    <td><?= $dataa['keterangan'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br><br>
<?php } ?>

<?php
$fileName = "Laporan Transfer Stok.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>