<?php

use yii\helpers\Html;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktItemStok;
use backend\models\AktPenyesuaianStok;
use backend\models\AktPenyesuaianStokDetail;
use backend\models\AktAkun;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Penyesuaian Stok';
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

                    <?= Html::beginForm(['laporan-penyesuaian-stok', array('class' => 'form-inline')]) ?>

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
                            <td width="5%"></td>
                            <td width="10%">
                                <div class="form-group">Tipe Penyesuaian</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <select name="tipe_penyesuaian" class="form-control">
                                        <option value="">Pilih Tipe Penyesuaian</option>
                                        <option value="1">Penambahan Stok</option>
                                        <option value="0">Pengurangan Stok</option>
                                    </select>
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
                            <td width="5%"></td>
                            <td width="10%">
                                <div class="form-group"></div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group"></div>
                            </td>
                            <td width="30%">
                                <div class="form-group">

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
        <style>
            .tabel {
                width: 100%;
            }

            .tabel th,
            .tabel td {
                padding: 2px;
            }
        </style>
        <p style="font-weight: bold; font-size: 20px;">
            <?= tanggal_indo($tanggal_awal, true) ?> s/d <?= tanggal_indo($tanggal_akhir, true) ?>
            <?php
            if ($count_penyesuaian_stok != 0) {
                # code...
            ?>
                <?= Html::a('Cetak ' . $this->title, ['laporan-penyesuaian-stok-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tipe_penyesuaian' => $tipe_penyesuaian], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
                <?= Html::a('Export ' . $this->title, ['laporan-penyesuaian-stok-export-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tipe_penyesuaian' => $tipe_penyesuaian], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
            <?php
            }
            ?>
        </p>
        <?php
        $where_tipe_penyesuaian = "";
        if ($tipe_penyesuaian  != "") {
            # code...
            $where_tipe_penyesuaian = " AND tipe_penyesuaian = " . $tipe_penyesuaian  . " ";
        }

        $query_penyesuaian_stok = AktPenyesuaianStok::find()->where("tanggal_penyesuaian BETWEEN '$tanggal_awal' AND '$tanggal_akhir' $where_tipe_penyesuaian")->asArray()->all();
        foreach ($query_penyesuaian_stok as $key => $data) {
        ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <table class="tabel">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Tanggal</th>
                                <th style="width: 10%;">No Transaksi</th>
                                <th style="width: 12%;">Tipe</th>
                                <td>Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= tanggal_indo($data['tanggal_penyesuaian'], true) ?></td>
                                <td><?= $data['no_transaksi'] ?></td>
                                <td><?= ($data['tipe_penyesuaian'] == 1) ? 'Penambahan Stok' : 'Pengurangan Stok' ?></td>
                                <td><?= $data['keterangan_penyesuaian'] ?></td>
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
                                            <td><?= $item_stok->hpp ?></td>
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