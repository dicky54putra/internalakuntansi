<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktTransferStok;
use backend\models\AktTransferStokDetail;
use backend\models\AktGudang;
use backend\models\AktItem;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Transfer Stok';
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

                    <?= Html::beginForm(['laporan-transfer-stok', array('class' => 'form-inline')]) ?>

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
                                <div class="form-group">Gudang Asal</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <?php
                                    echo Select2::widget([
                                        'name' => 'id_gudang_asal',
                                        'data' => $data_gudang,
                                        'options' => ['placeholder' => 'Pilih Gudang Awal'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
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
                                <div class="form-group">Gudang Tujuan</div>
                            </td>
                            <td align="center" width="5%">
                                <div class="form-group">:</div>
                            </td>
                            <td width="30%">
                                <div class="form-group">
                                    <?php
                                    echo Select2::widget([
                                        'name' => 'id_gudang_tujuan',
                                        'data' => $data_gudang,
                                        'options' => ['placeholder' => 'Pilih Gudang Tujuan'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
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
            if ($count_transfer_stok != 0) {
                # code...
            ?>
                <?= Html::a('Cetak ' . $this->title, ['laporan-transfer-stok-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'id_gudang_asal' => $id_gudang_asal, 'id_gudang_tujuan' => $id_gudang_tujuan], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
                <?= Html::a('Export ' . $this->title, ['laporan-transfer-stok-export-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'id_gudang_asal' => $id_gudang_asal, 'id_gudang_tujuan' => $id_gudang_tujuan], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
            <?php
            }
            ?>
        </p>
        <?php
        $where_gudang_asal = "";
        if ($id_gudang_asal != "") {
            # code...
            $where_gudang_asal = " AND id_gudang_asal = " . $id_gudang_asal . " ";
        }
        $where_gudang_tujuan = "";
        if ($id_gudang_tujuan != "") {
            # code...
            $where_gudang_tujuan = " AND id_gudang_tujuan = " . $id_gudang_tujuan . " ";
        }
        $query_transfer_stok = AktTransferStok::find()->where("tanggal_transfer BETWEEN '$tanggal_awal' AND '$tanggal_akhir' $where_gudang_asal $where_gudang_tujuan")->asArray()->all();
        foreach ($query_transfer_stok as $key => $data) {
            # code...
            $gudang_asal_header = AktGudang::findOne($data['id_gudang_asal']);
            $gudang_tujuan_header = AktGudang::findOne($data['id_gudang_tujuan']);
        ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <table class="tabel">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Tanggal Transfer</th>
                                <th style="width: 10%;">No Transfer</th>
                                <th style="width: 10%;">Gudang Asal</th>
                                <th>Gudang Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= tanggal_indo($data['tanggal_transfer'], true) ?></td>
                                <td><?= $data['no_transfer'] ?></td>
                                <td><?= $gudang_asal_header->nama_gudang ?></td>
                                <td><?= $gudang_tujuan_header->nama_gudang ?></td>
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
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query_transfer_stok_detail = AktTransferStokDetail::find()->where(['id_transfer_stok' => $data['id_transfer_stok']])->all();
                                    foreach ($query_transfer_stok_detail as $key => $dataa) {
                                        # code...
                                        $item = AktItem::findOne($dataa['id_item']);
                                    ?>
                                        <tr>
                                            <td><?= $no++ . '.' ?></td>
                                            <td><?= $item->nama_item ?></td>
                                            <td><?= $dataa['qty'] ?></td>
                                            <td><?= $item->satuan->nama_satuan ?></td>
                                            <td><?= $dataa['keterangan'] ?></td>
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