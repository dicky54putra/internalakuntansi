<?php

use yii\helpers\Html;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktAkun;
use backend\models\AktStokKeluar;
use backend\models\AktStokKeluarDetail;

$tanggal_awal = $_GET['tanggal_awal'];
$tanggal_akhir = $_GET['tanggal_akhir'];

$this->title = 'Laporan Stok Keluar';
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
$query_stok_keluar = AktStokKeluar::find()->where(["BETWEEN", "tanggal_keluar", $tanggal_awal, $tanggal_akhir])->orderBy("nomor_transaksi ASC")->asArray()->all();
foreach ($query_stok_keluar as $key => $data) {
    # code...
    $akun_persediaan = AktAkun::findOne($data['id_akun_persediaan']);
?>

    <table class="tabel">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 1%;">:</th>
                <td style="width: 20%;"><?= tanggal_indo($data['tanggal_keluar'], true) ?></td>
                <th style="width: 5%;">Tipe</th>
                <th style="width: 1%;">:</th>
                <td style="width: 15%;"><?= ($data['tipe'] == 1) ? 'Barang Keluar' : '' ?></td>
                <th style="width: 15%;">Akun Persediaan</th>
                <th style="width: 1%;">:</th>
                <td><?= (!empty($akun_persediaan->nama_akun)) ? $akun_persediaan->nama_akun : '' ?></td>
            </tr>
            <tr>
                <th>No Transaksi</th>
                <th>:</th>
                <td><?= $data['nomor_transaksi'] ?></td>
                <th>Metode</th>
                <th>:</th>
                <td><?= ($data['metode'] == 1) ? 'Akun' : ''; ?></td>
                <th>Keterangan</th>
                <th>:</th>
                <td><?= $data['keterangan'] ?></td>
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
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query_stok_keluar_detail = AktStokKeluarDetail::find()->where(['id_stok_keluar' => $data['id_stok_keluar']])->all();
            foreach ($query_stok_keluar_detail as $key => $dataa) {
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
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br><br>
<?php } ?>

<?php
$fileName = $this->title . ".xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>