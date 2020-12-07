<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktItemStok;
use backend\models\AktGudang;
use backend\models\AktItemPajakPembelian;
use backend\models\AktItemPajakPenjualan;
use backend\models\AktPajak;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
use backend\models\AktMataUang;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItem */

$this->title = 'Detail Daftar Barang : ' . $model->kode_item;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-item-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Barang', ['index']) ?></li>
        <li class="active">Detail Daftar Barang : <?= $model->kode_item ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_item], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_item], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-box"></span> Daftar Barang</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        // 'id_item',
                                        [
                                            'attribute' => 'kode_item',
                                            'label' => 'Kode',

                                        ],
                                        [
                                            'attribute' => 'barcode_item',
                                            'label' => 'Barcode',
                                        ],
                                        [
                                            'attribute' => 'nama_item',
                                            'label' => 'Nama',
                                        ],
                                        [
                                            'attribute' => 'nama_alias_item',
                                            'label' => 'Nama Alias',
                                        ],
                                        [
                                            'attribute' => 'id_tipe_item',
                                            'value' => function ($model) {
                                                return $model->tipe_item->nama_tipe_item;
                                            }
                                        ],
                                    ],
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        // 'id_item',
                                        [
                                            'attribute' => 'id_merk',
                                            'value' => function ($model) {
                                                if (!empty($model->merk->nama_merk)) {
                                                    # code...
                                                    return $model->merk->nama_merk;
                                                } else {
                                                    # code...
                                                }
                                            }
                                        ],
                                        [
                                            'attribute' => 'id_satuan',
                                            'value' => function ($model) {
                                                if (!empty($model->satuan->nama_satuan)) {
                                                    # code...
                                                    return $model->satuan->nama_satuan;
                                                } else {
                                                    # code...
                                                }
                                            }
                                        ],
                                        [
                                            'attribute' => 'id_mitra_bisnis',
                                            'label' => 'Mitra Bisnis (Supplier)',
                                            'value' => function ($model) {
                                                if (!empty($model->mitra_bisnis->nama_mitra_bisnis)) {
                                                    # code...
                                                    return $model->mitra_bisnis->nama_mitra_bisnis;
                                                } else {
                                                    # code...
                                                }
                                            }
                                        ],
                                        [
                                            'attribute' => 'keterangan_item',
                                            'label' => 'Keterangan',
                                            'value' => function ($model) {
                                                return $model->keterangan_item;
                                            }
                                        ],
                                        [
                                            'attribute' => 'status_aktif_item',
                                            'format' => 'html',
                                            'value' => function ($model) {
                                                if ($model->status_aktif_item == 2) {
                                                    return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                                                } else if ($model->status_aktif_item == 1) {
                                                    return '<p class="label label-success" style="font-weight:bold;"> Aktif </p> ';
                                                }
                                            }
                                        ],
                                    ],
                                ]) ?>
                            </div>
                        </div>

                        <div class="" style="margin-top:20px;">
                            <ul class="nav nav-tabs" id="tabForRefreshPage">
                                <li class="active"><a data-toggle="tab" href="#stok">Stok Gudang</a></li>
                                <!-- <li><a data-toggle="tab" href="#pajak-pembelian">Pajak Pembelian</a></li>
                                <li><a data-toggle="tab" href="#pajak-penjualan">Pajak Penjualan</a></li> -->
                                <li><a data-toggle="tab" href="#harga-jual">Level Harga</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="stok" class="tab-pane fade in active" style="margin-top:20px;">
                                    <p>
                                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Stok Gudang', ['akt-item-stok/create', 'id' => $model->id_item], ['class' => 'btn btn-success']) ?>
                                    </p>
                                    <table class="table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Gudang</th>
                                                <th>Location</th>
                                                <th>Qty</th>
                                                <th>HPP</th>
                                                <th>Min</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query_stok = AktItemStok::find()->where(['id_item' => $model->id_item])->asArray()->all();
                                            foreach ($query_stok as $key => $data) {
                                                # code...
                                                $gudang = AktGudang::findOne($data['id_gudang']);
                                            ?>
                                                <tr>
                                                    <td><?= $no++ . '.' ?></td>
                                                    <td><?= $gudang->nama_gudang ?></td>
                                                    <td><?= $data['location'] ?></td>
                                                    <td><?= $data['qty'] ?></td>
                                                    <td>Rp. <?= ribuan($data['hpp']) ?></td>
                                                    <td><?= ribuan($data['min']) ?></td>
                                                    <td>
                                                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-item-stok/update', 'id' => $data['id_item_stok']], ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['akt-item-stok/delete', 'id' => $data['id_item_stok']], [
                                                            'class' => 'btn btn-danger',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                                'method' => 'post',
                                                            ],
                                                        ]) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="harga-jual" class="tab-pane fade" style="margin-top:20px;">
                                    <p>
                                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Level Harga', ['akt-item-harga-jual/create', 'id' => $model->id_item], ['class' => 'btn btn-success']) ?>
                                    </p>
                                    <table class="table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Level Harga</th>
                                                <th>Mata Uang</th>
                                                <th>Harga Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query_harga_jual = AktItemHargaJual::find()->where(['id_item' => $model->id_item])->asArray()->all();
                                            foreach ($query_harga_jual as $key => $data) {
                                                # code...
                                                $mata_uang = AktMataUang::findOne($data['id_mata_uang']);
                                                $level_harga = AktLevelHarga::findOne($data['id_level_harga']);
                                            ?>
                                                <tr>
                                                    <td><?= $no++ . '.' ?></td>
                                                    <td><?= $level_harga->keterangan ?></td>
                                                    <td><?= $mata_uang->mata_uang ?></td>
                                                    <td>Rp. <?= ribuan($data['harga_satuan']) ?></td>
                                                    <td>
                                                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-item-harga-jual/update', 'id' => $data['id_item_harga_jual']], ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['akt-item-harga-jual/delete', 'id' => $data['id_item_harga_jual']], [
                                                            'class' => 'btn btn-danger',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                                'method' => 'post',
                                                            ],
                                                        ]) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>