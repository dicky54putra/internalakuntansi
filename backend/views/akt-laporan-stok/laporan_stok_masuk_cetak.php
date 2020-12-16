<?php

use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktStokMasuk;
use backend\models\AktStokMasukDetail;
use backend\models\AktPembelianPenerimaan;
use backend\models\AktPembelianPenerimaanDetail;
use backend\models\AktPembelianDetail;
use backend\models\AktPenjualanDetail;

$this->title = 'Laporan Stok Masuk';
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
    <h3 style="text-align: center;font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;">Laporan Stok Masuk <?= date('d/m/Y', strtotime($tanggal_awal)) ?> s/d <?= date('d/m/Y', strtotime($tanggal_akhir)) ?></h3>
</p>
<?php
$query = Yii::$app->db->createCommand("SELECT id_pembelian_penerimaan as id, no_penerimaan as nomor, tanggal_penerimaan as tanggal, 'pembelian' as tipe, keterangan_pengantar as keterangan FROM akt_pembelian_penerimaan WHERE tanggal_penerimaan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
UNION 
SELECT id_stok_masuk as id, nomor_transaksi as nomor, tanggal_masuk as tanggal, 'stok masuk' as tipe, keterangan as keterangan FROM akt_stok_masuk WHERE tanggal_masuk BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
UNION
SELECT id_retur_penjualan as id, no_retur_penjualan as nomor, tanggal_retur_penjualan as tanggal, 'retur penjualan' as tipe, '' as keterangan FROM akt_retur_penjualan WHERE tanggal_retur_penjualan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'AND status_retur = 1")->queryAll();
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
                <th style="width: 10%;">Satuan</th>
                <th style="width: 15%;">Gudang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query_detail = Yii::$app->db->createCommand("SELECT id_pembelian_penerimaan_detail as id, id_pembelian_penerimaan as id_parent, id_pembelian_detail as to_item_stok, qty_diterima as qty, keterangan as keterangan, 'pembelian' as tipe FROM akt_pembelian_penerimaan_detail WHERE id_pembelian_penerimaan = $data[id]
                                    UNION
                                    SELECT id_stok_masuk_detail as id, id_stok_masuk as id_parent, id_item_stok as to_item_stok, qty as qty, '' as keterangan, 'stok masuk' as tipe FROM akt_stok_masuk_detail WHERE id_stok_masuk = $data[id]
                                    UNION
                                    SELECT id_retur_penjualan_detail as id, id_retur_penjualan as id_parent, id_penjualan_detail as to_item_stok, retur as qty, keterangan as keterangan, 'retur penjualan' as tipe FROM akt_retur_penjualan_detail WHERE id_retur_penjualan = $data[id]")->queryAll();
            foreach ($query_detail as $qd) {
                if ($qd['tipe'] == $data['tipe']) {
                    if ($qd['tipe'] != 'stok masuk') {
                        if ($qd['tipe'] == 'pembelian') {
                            $id_item_stok = AktPembelianDetail::findOne($qd['to_item_stok']);
                        } elseif ($qd['tipe'] == 'retur penjualan') {
                            $id_item_stok = AktPenjualanDetail::findOne($qd['to_item_stok']);
                        }
                        $item_stok = AktItemStok::findOne(!empty($id_item_stok->id_item_stok) ? $id_item_stok->id_item_stok : 0);
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
                        <td><?= (!empty($item->satuan->nama_satuan)) ? $item->satuan->nama_satuan : '' ?></td>
                        <td><?= (!empty($gudang->nama_gudang)) ? $gudang->nama_gudang : '' ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <br>
<?php } ?>

<script>
    window.print();
    setTimeout(window.close, 1000);
</script>