<?php

use yii\helpers\Html;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktAkun;
use backend\models\AktStokMasuk;
use backend\models\AktStokMasukDetail;
use backend\models\AktPembelianPenerimaan;
use backend\models\AktPembelianPenerimaanDetail;
use backend\models\AktPembelianDetail;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Stok Masuk';
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

    <?php
    if ($tanggal_awal != "" && $tanggal_akhir != "") {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= date('d/m/Y', strtotime($tanggal_awal)) ?> s/d <?= date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?= Html::a('Cetak', ['laporan-stok-masuk-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-stok-masuk-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>

        </p>
        <?php
        $query_stok_masuk = AktStokMasuk::find()->where(["BETWEEN", "tanggal_masuk", $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_masuk ASC")->asArray()->all();
        foreach ($query_stok_masuk as $key => $data) {
            # code...
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
                                <td><?= $data['nomor_transaksi'] ?></td>
                                <td><?= date('d/m/Y', strtotime($data['tanggal_masuk'])) ?></td>
                                <td style="white-space: nowrap;"><?= ($data['tipe'] == 1) ? 'Barang Masuk' : '' ?></td>
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
                                        <th style="width: 10%;">Satuan</th>
                                        <th style="width: 15%;">Gudang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query_stok_masuk_detail = AktStokMasukDetail::find()->where(['id_stok_masuk' => $data['id_stok_masuk']])->all();
                                    foreach ($query_stok_masuk_detail as $key => $dataa) {
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
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php
        $query_pembelian_penerimaan = AktPembelianPenerimaan::find()->where(["BETWEEN", "tanggal_penerimaan", $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_penerimaan ASC")->all();
        foreach ($query_pembelian_penerimaan as $key => $data) {
            # code...
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
                                <td><?= $data->no_penerimaan ?></td>
                                <td><?= date('d/m/Y', strtotime($data->tanggal_penerimaan)) ?></td>
                                <td style="white-space: nowrap;"><?= 'Penerimaan Pembelian' ?></td>
                                <td><?= $data->keterangan_pengantar ?></td>
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
                                        <th style="width: 10%;">Satuan</th>
                                        <th style="width: 15%;">Gudang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    $query_pembelian_penerimaan_detail = AktPembelianPenerimaanDetail::find()->where(['id_pembelian_penerimaan' => $data['id_pembelian_penerimaan']])->all();
                                    foreach ($query_pembelian_penerimaan_detail as $key => $dataa) {
                                        # code...
                                        $no++;
                                        $retVal_id_pembelian_detail = (!empty($dataa->id_pembelian_detail)) ? $dataa->id_pembelian_detail : 0;
                                        $pembelian_detail = AktPembelianDetail::findOne($retVal_id_pembelian_detail);
                                        $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
                                        $item = AktItem::findOne($item_stok->id_item);
                                        $gudang = AktGudang::findOne($item_stok->id_gudang);
                                    ?>
                                        <tr>
                                            <td><?= $no . '.' ?></td>
                                            <td><?= $item->nama_item ?></td>
                                            <td><?= $dataa['qty_diterima'] ?></td>
                                            <td><?= $item->satuan->nama_satuan ?></td>
                                            <td><?= $gudang->nama_gudang ?></td>
                                        </tr>
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