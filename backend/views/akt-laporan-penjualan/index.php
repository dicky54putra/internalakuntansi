<?php

use yii\helpers\Html;
use backend\models\AktPenjualan;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;

$this->title = 'Laporan Penjualan';
?>
<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="box">
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
                                        <input type="date" name="tanggal_awal" class="form-control" required>
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
                                        <input type="date" name="tanggal_akhir" class="form-control" required>
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
    </div>

    <?php
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?= Html::a('Cetak', ['laporan-penjualan-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-penjualan-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>
        <?php
        $query_penjualan = AktPenjualan::find()->where(['BETWEEN', 'tanggal_penjualan', $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_penjualan ASC")->all();
        foreach ($query_penjualan as $key => $data) {
            # code...
        ?>
            <div class="box">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <style>
                            .table1 th,
                            .table1 td {
                                padding: 5px;
                            }
                        </style>
                        <table class="table1">
                            <thead>
                                <tr>
                                    <th>No. Penjualan</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $data->no_penjualan ?></td>
                                    <td><?= date('d/m/Y', strtotime($data->tanggal_penjualan)) ?></td>
                                    <td><?= $data->customer->nama_mitra_bisnis ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="box-body">

                                <table class="table table-responsive table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%;">No</th>
                                            <th>Nama Barang</th>
                                            <th style="width: 5%;">Jenis</th>
                                            <th>Gudang</th>
                                            <th style="width: 5%;">Qty</th>
                                            <th style="width: 5%;">Harga</th>
                                            <th style="width: 5%;white-space: nowrap;">Diskon %</th>
                                            <th>Keterangan</th>
                                            <th style="width: 5%;">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $totalan_sub_total = 0;
                                        $query_penjualan_detail = AktPenjualanDetail::findAll(['id_penjualan' => $data->id_penjualan]);
                                        foreach ($query_penjualan_detail as $key => $dataa) {
                                            # code...
                                            $no++;
                                            $retVal_id_item_stok = (!empty($dataa->id_item_stok)) ? $dataa->id_item_stok : 0;
                                            $item_stok = AktItemStok::findOne($retVal_id_item_stok);
                                            $retVal_id_item = (!empty($item_stok->id_item)) ? $item_stok->id_item : 0;
                                            $item = AktItem::findOne($retVal_id_item);
                                            $retVal_id_item_harga_jual = (!empty($dataa->id_item_harga_jual)) ? $dataa->id_item_harga_jual : 0;
                                            $item_harga_jual = AktItemHargaJual::findOne($retVal_id_item_harga_jual);
                                            $retVal_id_level_harga = (!empty($item_harga_jual->id_level_harga)) ? $item_harga_jual->id_level_harga : 0;
                                            $level_harga = AktLevelHarga::findOne($retVal_id_level_harga);
                                            $retVal_id_gudang = (!empty($item_stok->id_gudang)) ? $item_stok->id_gudang : 0;
                                            $gudang = AktGudang::findOne($retVal_id_gudang);

                                            $totalan_sub_total += $dataa->total;
                                        ?>
                                            <tr>
                                                <td><?= $no . '.' ?></td>
                                                <td><?= $item->nama_item ?></td>
                                                <td style="white-space: nowrap;"><?= $level_harga->keterangan ?></td>
                                                <td><?= $gudang->nama_gudang ?></td>
                                                <td><?= $dataa->qty ?></td>
                                                <td style="text-align: right;white-space: nowrap;"><?= ribuan($dataa->harga) ?></td>
                                                <td><?= $dataa->diskon ?></td>
                                                <td><?= $dataa->keterangan ?></td>
                                                <td style="text-align: right;white-space: nowrap;"><?= ribuan($dataa->total) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="8">Total</th>
                                            <th style="text-align: right;"><?= ribuan($totalan_sub_total) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

</div>