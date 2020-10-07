<?php

use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktPenyesuaianStok;
use backend\models\AktPenyesuaianStokDetail;
use backend\models\AktAkun;

$tanggal_awal = $_GET['tanggal_awal'];
$tanggal_akhir = $_GET['tanggal_akhir'];
$metode = $_GET['metode'];

$this->title = 'Laporan Penyesuaian Stok';
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
$where_metode = "";
if ($metode != "") {
    # code...
    $where_metode = " AND metode = " . $metode . " ";
}

$query_penyesuaian_stok = AktPenyesuaianStok::find()->where("tanggal_penyesuaian BETWEEN '$tanggal_awal' AND '$tanggal_akhir' $where_metode")->asArray()->all();
foreach ($query_penyesuaian_stok as $key => $data) {
    # code...
    $akun_persediaan = AktAkun::findOne($data['id_akun_persediaan']);
?>

    <table class="tabel">
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 1%;">:</th>
                <td style="width: 20%;"><?= tanggal_indo($data['tanggal_penyesuaian'], true) ?></td>
                <th style="width: 5%;">Tipe</th>
                <th style="width: 1%;">:</th>
                <td style="width: 14%;"><?= ($data['tipe_penyesuaian'] == 1) ? 'Penyesuaian Stok' : '' ?></td>
                <th style="width: 15%;">Akun Persediaan</th>
                <th style="width: 1%;">:</th>
                <td><?= (!empty($akun_persediaan->nama_akun)) ? $akun_persediaan->nama_akun : '' ?></td>
            </tr>
            <tr>
                <th>No Transaksi</th>
                <th>:</th>
                <td><?= $data['no_transaksi'] ?></td>
                <th>Metode</th>
                <th>:</th>
                <td><?= ($data['metode'] == 1) ? 'Akun' : $retVal = ($data['metode'] == 2) ? 'Round Down' : 'Replace'; ?></td>
                <th>Keterangan</th>
                <th>:</th>
                <td><?= $data['keterangan_penyesuaian'] ?></td>
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
                <th>Gudang</th>
                <th>HPP</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query_penyesuaian_stok_detail = AktPenyesuaianStokDetail::find()->where(['id_penyesuaian_stok' => $data['id_penyesuaian_stok']])->all();
            foreach ($query_penyesuaian_stok_detail as $key => $dataa) {
                # code...
                $item_stok = AktItemStok::findOne($dataa['id_item_stok']);
                $item = AktItem::findOne($item_stok->id_item);
                $gudang = AktGudang::findOne($item_stok->id_gudang);
            ?>
                <tr>
                    <td><?= $no++ . '.' ?></td>
                    <td><?= $item->nama_item ?></td>
                    <td><?= $dataa['qty'] ?></td>
                    <td><?= $item->satuan->nama_satuan ?></td>
                    <td><?= $gudang->nama_gudang ?></td>
                    <td><?= $dataa['hpp'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br><br>
<?php } ?>

<?php
$fileName = "Laporan Penyesuaian Stok.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>