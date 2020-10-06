<?php

use yii\helpers\Html;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktAkun;
use backend\models\AktStokKeluar;
use backend\models\AktStokKeluarDetail;
use backend\models\AktPenjualanPengiriman;
use backend\models\AktPenjualanPengirimanDetail;
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
$query_stok_keluar = AktStokKeluar::find()->where(["BETWEEN", "tanggal_keluar", $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_keluar ASC")->asArray()->all();
foreach ($query_stok_keluar as $key => $data) {
    # code...
?>
    <table class="table1">
        <thead>
            <tr>
                <th style="text-align: left;">No Transaksi</th>
                <th style="text-align: left;">Tanggal</th>
                <th style="text-align: left;">Tipe</th>
                <th style="text-align: left;">Keterangan</th>
            </tr>
            <tr>
                <td style="text-align: left;"><?= $data['nomor_transaksi'] ?></td>
                <td style="text-align: left;"><?= date('d/m/Y', strtotime($data['tanggal_keluar'])) ?></td>
                <td style="text-align: left;"><?= ($data['tipe'] == 1) ? 'Barang Keluar' : '' ?></td>
                <td style="text-align: left;"><?= $data['keterangan'] ?></td>
            </tr>
        </thead>
    </table>
    <table class="table2" border="1">
        <thead>
            <tr>
                <th style="width: 1%;text-align: center;">#</th>
                <th style="text-align: left;">Nama Barang</th>
                <th style="width: 5%;text-align: left;">Qty</th>
                <th style="width: 10%;text-align: left;">Satuan</th>
                <th style="width: 15%;text-align: left;">Gudang</th>
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
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= $item->nama_item ?></td>
                    <td style="white-space: nowrap;text-align: center;"><?= $dataa['qty'] ?></td>
                    <td style="white-space: nowrap;"><?= $item->satuan->nama_satuan ?></td>
                    <td><?= $gudang->nama_gudang ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
<?php } ?>
<?php
$query_penjualan_pengiriman = AktPenjualanPengiriman::find()->where(["BETWEEN", "tanggal_pengiriman", $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_pengiriman ASC")->andWhere(['status' => 1])->all();
foreach ($query_penjualan_pengiriman as $key => $data) {
    # code...
?>
    <table class="table1">
        <thead>
            <tr>
                <th style="text-align: left;">No Transaksi</th>
                <th style="text-align: left;">Tanggal</th>
                <th style="text-align: left;">Tipe</th>
                <th style="text-align: left;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left;"><?= $data['no_pengiriman'] ?></td>
                <td style="text-align: left;"><?= date('d/m/Y', strtotime($data['tanggal_pengiriman'])) ?></td>
                <td style="text-align: left;"><?= 'Pengiriman Penjualan' ?></td>
                <td style="text-align: left;"><?= $data['keterangan_pengantar'] ?></td>
            </tr>
        </tbody>
    </table>
    <table class="table2" border="1">
        <thead>
            <tr>
                <th style="width: 1%;text-align: center;">#</th>
                <th style="text-align: left;">Nama Barang</th>
                <th style="width: 5%;text-align: left;">Qty</th>
                <th style="width: 10%;text-align: left;">Satuan</th>
                <th style="width: 15%;text-align: left;">Gudang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query_penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_pengiriman' => $data['id_penjualan_pengiriman']])->all();
            foreach ($query_penjualan_pengiriman_detail as $key => $dataa) {
                # code...
                $retVal_id_penjualan_detail = (!empty($dataa->id_penjualan_detail)) ? $dataa->id_penjualan_detail : 0;
                $penjualan_detail = AktPenjualanDetail::findOne($retVal_id_penjualan_detail);
                $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
                $item = AktItem::findOne($item_stok->id_item);
                $gudang = AktGudang::findOne($item_stok->id_gudang);
            ?>
                <tr>
                    <td style="text-align: center;"><?= $no++ ?></td>
                    <td><?= $item->nama_item ?></td>
                    <td style="text-align: center;"><?= $dataa['qty_dikirim'] ?></td>
                    <td><?= $item->satuan->nama_satuan ?></td>
                    <td><?= $gudang->nama_gudang ?></td>
                </tr>
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