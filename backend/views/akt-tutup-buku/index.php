<?php

use yii\helpers\Html;

use backend\models\AktPenjualan;
use backend\models\AktPenjualanDetail;
use backend\models\AktPembelian;
use backend\models\AktPembelianDetail;
use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktMataUang;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktItem;
use backend\models\AktItemStok;

$this->title = 'Tutup Buku';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tutup-buku-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-book"></span> <?= $this->title ?></div>
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
                            <td width="10%">
                                <div class="form-group">Tutup Buku</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <select name="tutup_buku" class="form-control" required>
                                        <option value="">Pilih Tutup Buku</option>
                                        <option value="1">Pembelian</option>
                                        <option value="2">Penjualan</option>
                                    </select>
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
    if (!empty($tutup_buku) && $tutup_buku == 1 && !empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p>
            <h3>
                <span class="fa fa-shopping-cart"></span> <?= $this->title ?> Pembelian
                <?= Html::a('Cetak', ['cetak-tutup-buku-pembelian', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tutup_buku' => $tutup_buku], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
                <?= Html::a('Export', ['export-tutup-buku-pembelian', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tutup_buku' => $tutup_buku], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
            </h3>
        </p>
        <?php
        $query_pembelian = AktPembelian::find()->where(['BETWEEN', 'tanggal_order_pembelian', $tanggal_awal, $tanggal_akhir])->asArray()->all();
        foreach ($query_pembelian as $key => $data) {
            # code...
            $customer = AktMitraBisnis::findOne($data['id_customer']);
            $sales = AktSales::findOne($data['id_sales']);
            $mata_uang = AktMataUang::findOne($data['id_mata_uang']);
            $penagih = AktMitraBisnis::findOne($data['id_penagih']);
            $alamat_pengantaran = AktMitraBisnisAlamat::findOne($data['id_mitra_bisnis_alamat']);
        ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <style>
                        .table_heading th,
                        .table_heading td {
                            padding: 5px;
                        }
                    </style>
                    <table class="table_heading">
                        <thead>
                            <tr>
                                <th>No. Order</th>
                                <td>: <?= $data['no_order_pembelian'] ?></td>
                                <th>No. Faktur</th>
                                <td>: <?= $data['no_faktur_pembelian'] ?></td>
                                <th>No. SPB</th>
                                <td>: <?= $data['no_spb'] ?></td>
                                <th>Tanggal Penerimaan</th>
                                <td>: <?= (!empty($data['tanggal_penerimaan'])) ? date('d/m/Y', strtotime($data['tanggal_penerimaan'])) : '&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Order</th>
                                <td>: <?= date('d/m/Y', strtotime($data['tanggal_order_pembelian'])) ?></td>
                                <th>Tanggal Faktur</th>
                                <td>: <?= (!empty($data['tanggal_faktur_pembelian'])) ? date('d/m/Y', strtotime($data['tanggal_faktur_pembelian'])) : '&nbsp;' ?></td>
                                <th>Tanggal Penerimaan</th>
                                <td>: <?= (!empty($data['tanggal_penerimaan'])) ? date('d/m/Y', strtotime($data['tanggal_penerimaan'])) : '&nbsp;' ?></td>
                                <th>Penerima</th>
                                <td>: <?= $data['penerima'] ?></td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>: <?= (!empty($customer->nama_mitra_bisnis)) ? $customer->nama_mitra_bisnis : '' ?></td>
                                <th>Materai</th>
                                <td>: <?= $data['materai'] ?></td>
                                <th>Pengantar</th>
                                <td>: <?= $data['pengantar'] ?></td>
                                <th>Status</th>
                                <td>
                                    <?php
                                    if ($data['status'] == 1) {
                                        # code...
                                        echo ": Order Penjualan";
                                    } elseif ($data['status'] == 2) {
                                        # code...
                                        echo ": Penjualan";
                                    } elseif ($data['status'] == 3) {
                                        # code...
                                        echo ": Pengiriman";
                                    } elseif ($data['status'] == 4) {
                                        # code...
                                        echo ": Completed";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Sales</th>
                                <td>: <?= (!empty($sales->nama_sales)) ? $sales->nama_sales : '&nbsp;' ?></td>
                                <th>Jatuh Tempo</th>
                                <td>
                                    <?php
                                    if ($data['jenis_bayar'] == 1) {
                                        # code...
                                        if (!empty($data['tanggal_faktur_penjualan'])) {
                                            # code...
                                            echo ': ' . date('d/m/Y', strtotime($data['tanggal_faktur_penjualan']));
                                        } else {
                                            # code...
                                            echo '&nbsp;';
                                        }
                                    } elseif ($data['jenis_bayar'] == 2) {
                                        # code...
                                        if (!empty($data['tanggal_tempo'])) {
                                            # code...
                                            echo ': ' . date('d/m/Y', strtotime($data['tanggal_tempo']));
                                        } else {
                                            # code...
                                            echo '&nbsp;';
                                        }
                                    }
                                    ?>
                                </td>
                                <th>Alamat Pengantaran</th>
                                <td>: <?= (!empty($alamat_pengantaran->keterangan_alamat)) ? $alamat_pengantaran->keterangan_alamat : '&nbsp;' ?></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Diskon Barang %</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $totalan_sub_total = 0;
                                    $query_pembelian_detail = AktPembelianDetail::findAll(['id_pembelian' => $data['id_pembelian']]);
                                    foreach ($query_pembelian_detail as $key => $dataa) {
                                        # code...
                                        $item_stok = AktItemStok::findOne($dataa['id_item_stok']);
                                        $item = AktItem::findOne($item_stok->id_item);
                                        $totalan_sub_total += $dataa['total'];
                                    ?>
                                        <tr>
                                            <td style="width: 1%;"><?= $no++ . '.' ?></td>
                                            <td><?= (!empty($item->nama_item)) ? $item->nama_item : '&nbsp;' ?></td>
                                            <td><?= $dataa['qty'] ?></td>
                                            <td><?= ribuan($dataa['harga']) ?></td>
                                            <td><?= $dataa['diskon'] ?></td>
                                            <td style="text-align: right;"><?= ribuan($dataa['total']) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Total</th>
                                        <th style="text-align: right;"><?= ribuan($totalan_sub_total) ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Diskon Pembelian</th>
                                        <th style="text-align: right;">
                                            <?php
                                            $diskon = ($data['diskon'] * $totalan_sub_total) / 100;
                                            echo ribuan($diskon);
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Pajak 10% (<?= ($data['pajak'] == NULL) ? '' : $retVal = ($data['pajak'] == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
                                        <th style="text-align: right;">
                                            <?php
                                            $diskon = ($data['diskon'] * $totalan_sub_total) / 100;
                                            $pajak_ = (($totalan_sub_total - $diskon) * 10) / 100;
                                            $pajak = ($data['pajak'] == 1) ? $pajak_ : 0;
                                            echo ribuan($pajak);
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Ongkir</th>
                                        <th style="text-align: right;"><?= $data['ongkir'] ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Grand Total</th>
                                        <th style="text-align: right;"><?= ribuan($data['total']) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php
    if (!empty($tutup_buku) && $tutup_buku == 2 && !empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p>
            <h3>
                <span class="fa fa-shopping-cart"></span> <?= $this->title ?> Penjualan
                <?= Html::a('Cetak', ['cetak-tutup-buku-penjualan', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tutup_buku' => $tutup_buku], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
                <?= Html::a('Export', ['export-tutup-buku-penjualan', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tutup_buku' => $tutup_buku], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
            </h3>
        </p>
        <?php
        $query_penjualan = AktPenjualan::find()->where(['BETWEEN', 'tanggal_order_penjualan', $tanggal_awal, $tanggal_akhir])->asArray()->all();
        foreach ($query_penjualan as $key => $data) {
            # code...
            $customer = AktMitraBisnis::findOne($data['id_customer']);
            $sales = AktSales::findOne($data['id_sales']);
            $mata_uang = AktMataUang::findOne($data['id_mata_uang']);
            $penagih = AktMitraBisnis::findOne($data['id_penagih']);
            $alamat_pengantaran = AktMitraBisnisAlamat::findOne($data['id_mitra_bisnis_alamat']);
        ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <style>
                        .table_heading th,
                        .table_heading td {
                            padding: 5px;
                        }
                    </style>
                    <table class="table_heading">
                        <thead>
                            <tr>
                                <th>No. Order</th>
                                <td>: <?= $data['no_order_penjualan'] ?></td>
                                <th>No. Faktur</th>
                                <td>: <?= $data['no_faktur_penjualan'] ?></td>
                                <th>No. SPB</th>
                                <td>: <?= $data['no_spb'] ?></td>
                                <th>Tanggal Penerimaan</th>
                                <td>: <?= (!empty($data['tanggal_penerimaan'])) ? date('d/m/Y', strtotime($data['tanggal_penerimaan'])) : '&nbsp;' ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Order</th>
                                <td>: <?= date('d/m/Y', strtotime($data['tanggal_order_penjualan'])) ?></td>
                                <th>Tanggal Faktur</th>
                                <td>: <?= (!empty($data['tanggal_faktur_penjualan'])) ? date('d/m/Y', strtotime($data['tanggal_faktur_penjualan'])) : '&nbsp;' ?></td>
                                <th>Tanggal Pengiriman</th>
                                <td>: <?= (!empty($data['tanggal_pengiriman'])) ? date('d/m/Y', strtotime($data['tanggal_pengiriman'])) : '&nbsp;' ?></td>
                                <th>Penerima</th>
                                <td>: <?= $data['penerima'] ?></td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>: <?= (!empty($customer->nama_mitra_bisnis)) ? $customer->nama_mitra_bisnis : '' ?></td>
                                <th>Materai</th>
                                <td>: <?= $data['materai'] ?></td>
                                <th>Pengantar</th>
                                <td>: <?= $data['pengantar'] ?></td>
                                <th>Status</th>
                                <td>
                                    <?php
                                    if ($data['status'] == 1) {
                                        # code...
                                        echo ": Order Penjualan";
                                    } elseif ($data['status'] == 2) {
                                        # code...
                                        echo ": Penjualan";
                                    } elseif ($data['status'] == 3) {
                                        # code...
                                        echo ": Pengiriman";
                                    } elseif ($data['status'] == 4) {
                                        # code...
                                        echo ": Completed";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Sales</th>
                                <td>: <?= (!empty($sales->nama_sales)) ? $sales->nama_sales : '&nbsp;' ?></td>
                                <th>Jatuh Tempo</th>
                                <td>
                                    <?php
                                    if ($data['jenis_bayar'] == 1) {
                                        # code...
                                        if (!empty($data['tanggal_faktur_penjualan'])) {
                                            # code...
                                            echo ': ' . date('d/m/Y', strtotime($data['tanggal_faktur_penjualan']));
                                        } else {
                                            # code...
                                            echo '&nbsp;';
                                        }
                                    } elseif ($data['jenis_bayar'] == 2) {
                                        # code...
                                        if (!empty($data['tanggal_tempo'])) {
                                            # code...
                                            echo ': ' . date('d/m/Y', strtotime($data['tanggal_tempo']));
                                        } else {
                                            # code...
                                            echo '&nbsp;';
                                        }
                                    }
                                    ?>
                                </td>
                                <th>Alamat Pengantaran</th>
                                <td>: <?= (!empty($alamat_pengantaran->keterangan_alamat)) ? $alamat_pengantaran->keterangan_alamat : '&nbsp;' ?></td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Diskon Barang %</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $totalan_sub_total = 0;
                                    $query_penjualan_detail = AktPenjualanDetail::findAll(['id_penjualan' => $data['id_penjualan']]);
                                    foreach ($query_penjualan_detail as $key => $dataa) {
                                        # code...
                                        $item_stok = AktItemStok::findOne($dataa['id_item_stok']);
                                        $item = AktItem::findOne($item_stok->id_item);
                                        $totalan_sub_total += $dataa['total'];
                                    ?>
                                        <tr>
                                            <td style="width: 1%;"><?= $no++ . '.' ?></td>
                                            <td><?= (!empty($item->nama_item)) ? $item->nama_item : '&nbsp;' ?></td>
                                            <td><?= $dataa['qty'] ?></td>
                                            <td><?= ribuan($dataa['harga']) ?></td>
                                            <td><?= $dataa['diskon'] ?></td>
                                            <td style="text-align: right;"><?= ribuan($dataa['total']) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Total</th>
                                        <th style="text-align: right;"><?= ribuan($totalan_sub_total) ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Diskon Penjualan</th>
                                        <th style="text-align: right;">
                                            <?php
                                            $diskon = ($data['diskon'] * $totalan_sub_total) / 100;
                                            echo ribuan($diskon);
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Pajak 10% (<?= ($data['pajak'] == NULL) ? '' : $retVal = ($data['pajak'] == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
                                        <th style="text-align: right;">
                                            <?php
                                            $diskon = ($data['diskon'] * $totalan_sub_total) / 100;
                                            $pajak_ = (($totalan_sub_total - $diskon) * 10) / 100;
                                            $pajak = ($data['pajak'] == 1) ? $pajak_ : 0;
                                            echo ribuan($pajak);
                                            ?>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Ongkir</th>
                                        <th style="text-align: right;"><?= $data['ongkir'] ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" style="text-align: right;">Grand Total</th>
                                        <th style="text-align: right;"><?= ribuan($data['total']) ?></th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

</div>