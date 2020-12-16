?php

use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktPembelianDetail;
use backend\models\AktPenjualanDetail;

$this->title = 'Laporan Stok Keluar';
?>
<style>
    .table1 {
        font-size: 15px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .table1 th,
    .table1 td {
        padding: 3px;
        line-height: 12px;
        text-align: left;
    }

    .table2 {
        font-size: 15px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        border-collapse: collapse;
    }

    .table2 th,
    .table2 td {
        border: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }
</style>
<p>
    <h3 style="text-align: center;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Laporan Stok Keluar <?= date('d/m/Y', strtotime($tanggal_awal)) ?> s/d <?= date('d/m/Y', strtotime($tanggal_akhir)) ?></h3>
</p>
<?php

use backend\models\AktGudang;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktPembelianDetail;
use backend\models\AktPenjualanDetail;

$query = Yii::$app->db->createCommand("SELECT id_penjualan_pengiriman as id, no_pengiriman as nomor, tanggal_pengiriman as tanggal, 'penjualan' as tipe, keterangan_pengantar as keterangan FROM akt_penjualan_pengiriman WHERE tanggal_pengiriman BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
UNION
SELECT id_stok_keluar as id, nomor_transaksi as nomor, tanggal_keluar as tanggal, 'stok keluar' as tipe, keterangan as keterangan FROM akt_stok_keluar WHERE tanggal_keluar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
UNION
SELECT id_retur_pembelian as id, no_retur_pembelian as nomor, tanggal_retur_pembelian as tanggal, 'retur pembelian' as tipe, '' as keterangan FROM akt_retur_pembelian WHERE tanggal_retur_pembelian BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_retur = 2")->queryAll();
foreach ($query as $key => $data) {
?>
    <table class="table1">
        <thead>
            <tr>
                <th style="width: 5%;white-space: nowrap;">No Transaksi</th>
                <th style="width: 5%;">Tanggal</th>
                <th style="width: 5%;">Tipe</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $data['nomor'] ?></td>
                <td><?= date('d/m/Y', strtotime($data['tanggal'])) ?></td>
                <td style="white-space: nowrap;"><?= $data['tipe'] ?></td>
                <td><?= $data['keterangan'] ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table2">
        <thead>
            <tr>
                <th style="width: 1%;">#</th>
                <th>Nama Barang</th>
                <th style="width: 5%;">Qty</th>
                <th style="width: 5%;">tipe</th>
                <th style="width: 10%;">Satuan</th>
                <th style="width: 15%;">Gudang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query_detail = Yii::$app->db->createCommand("SELECT id_penjualan_pengiriman_detail as id, id_penjualan_pengiriman as id_parent, id_penjualan_detail as to_item_stok, qty_dikirim as qty, keterangan as keterangan, 'penjualan' as tipe FROM akt_penjualan_pengiriman_detail WHERE 'penjualan' = 'penjualan' AND id_penjualan_pengiriman = $data[id]
                                    UNION
                                    SELECT id_stok_keluar_detail as id, id_stok_keluar as id_parent, id_item_stok as to_item_stok, qty as qty, '' as keterangan, 'stok keluar' as tipe FROM akt_stok_keluar_detail WHERE 'stok keluar' = 'stok keluar' AND id_stok_keluar = $data[id]
                                    UNION
                                    SELECT id_retur_pembelian_detail as id, id_retur_pembelian as id_parent, id_pembelian_detail as to_item_stok, retur as qty, keterangan as keterangan, 'retur pembelian' as tipe FROM akt_retur_pembelian_detail WHERE 'retur pembelian' = 'retur pembelian' AND id_retur_pembelian = $data[id]")->queryAll();
            foreach ($query_detail as $qd) {
                if ($qd['tipe'] == $data['tipe']) {
                    if ($qd['tipe'] != 'stok keluar') {
                        if ($qd['tipe'] == 'penjualan') {
                            $id_item_stok = AktPenjualanDetail::findOne($qd['to_item_stok']);
                        } elseif ($qd['tipe'] == 'retur pembelian') {
                            $id_item_stok = AktPembelianDetail::findOne($qd['to_item_stok']);
                        }
                        $item_stok = AktItemStok::findOne(!empty($id_item_stok) ? $id_item_stok : 0);
                    } else {
                        $item_stok = AktItemStok::findOne($qd['to_item_stok']);
                    }
                    $item = AktItem::findOne(!empty($item_stok->id_item) ? $item_stok->id_item : 0);
                    $gudang = AktGudang::findOne(!empty($item_stok->id_gudang) ? $item_stok->id_gudang : 0);
            ?>
                    <tr>
                        <td><?= $no++ . '.' ?></td>
                        <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                        <td><?= $qd['qty'] ?></td>
                        <td><?= $qd['tipe'] ?></td>
                        <td><?= (!empty($item->satuan->nama_satuan)) ? $item->satuan->nama_satuan : '' ?></td>
                        <td><?= (!empty($gudang->nama_gudang)) ? $gudang->nama_gudang : '' ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <br>
<?php } ?>

<?php
$fileName = $this->title . ".xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>