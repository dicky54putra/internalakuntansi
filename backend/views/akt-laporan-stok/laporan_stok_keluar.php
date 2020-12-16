<?php

use yii\helpers\Html;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktAkun;
use backend\models\AktPembelianDetail;
use backend\models\AktStokKeluar;
use backend\models\AktStokKeluarDetail;
use backend\models\AktPenjualanPengiriman;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\AktPenjualanDetail;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Stok Keluar';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-item-stok-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Stok', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= Html::beginForm(['', array('class' => 'form-inline')]) ?>

                    <table border="0" width="100%">
                        <tr>
                            <td width="10%">
                                <div class="form-group">Dari Tanggal</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <input type="date" name="tanggal_awal" class="form-control" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))) ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%">
                                <div class="form-group">Sampai Tanggal</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <input type="date" name="tanggal_akhir" class="form-control" value="<?= (!empty($tanggal_akhir)) ? $tanggal_akhir : date('Y-m-d') ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="form-group">
                                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    if ($tanggal_awal != "" && $tanggal_akhir != "") {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= date('d/m/Y', strtotime($tanggal_awal)) ?> s/d <?= date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?= Html::a('Cetak', ['laporan-stok-keluar-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-stok-keluar-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>

        </p>
        <?php
        $query = Yii::$app->db->createCommand("SELECT id_penjualan_pengiriman as id, no_pengiriman as nomor, tanggal_pengiriman as tanggal, 'penjualan' as tipe, keterangan_pengantar as keterangan FROM akt_penjualan_pengiriman WHERE tanggal_pengiriman BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        UNION
        SELECT id_stok_keluar as id, nomor_transaksi as nomor, tanggal_keluar as tanggal, 'stok keluar' as tipe, keterangan as keterangan FROM akt_stok_keluar WHERE tanggal_keluar BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
        UNION
        SELECT id_retur_pembelian as id, no_retur_pembelian as nomor, tanggal_retur_pembelian as tanggal, 'retur pembelian' as tipe, '' as keterangan FROM akt_retur_pembelian WHERE tanggal_retur_pembelian BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND status_retur = 2")->queryAll();
        foreach ($query as $key => $data) {
        ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <style>
                        .tabel {
                            width: 100%;
                        }

                        .tabel th,
                        .tabel td {
                            padding: 3px;
                        }
                    </style>
                    <table class="tabel">
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
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">
                            <table class="table">
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
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php
    }
    ?>

</div>