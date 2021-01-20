<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktProduksiManualDetailBb;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktProduksiManualDetailHp;
/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManual */

$this->title = 'Detail Daftar Produksi Manual : ' . $model->no_produksi_manual;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-produksi-manual-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Produksi Manual', ['index']) ?></li>
        <li class="active">Detail Daftar Produksi Manual : <?= $model->no_produksi_manual ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_produksi_manual], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_produksi_manual], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<i class="fa fa-tasks" aria-hidden="true"></i> Tutup Produksi', ['tutup', 'id' => $model->id_produksi_manual], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['print', 'id' => $model->id_produksi_manual], ['class' => 'btn btn-default', 'target' => 'blank']) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-area-chart"></span> Produksi Manual</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_produksi_manual',
                                'no_produksi_manual',
                                [
                                    'attribute' => 'tanggal',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal, true);
                                    }
                                ],
                                [
                                    'attribute' => 'id_pegawai',
                                    'label' => 'Pegawai',
                                    'value' => function ($model) {
                                        if ($model->id_pegawai == NULL) {
                                            return 'Semua';
                                        } else {
                                            return $model->pegawai->nama_pegawai;
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'id_customer',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->id_customer == NULL) {
                                            return '<p style="color:red;"> Not Set </p>';
                                        } else {
                                            return $model->mitra_bisnis->nama_mitra_bisnis;
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'id_akun',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->id_akun == NULL) {
                                            return '<p style="color:red;"> Not Set </p>';
                                        } else {
                                            return $model->akun->nama_akun;
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'status_produksi',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_produksi == 0) {
                                            return '<span class="label label-default">Proses Produksi</span>';
                                        } else if ($model->status_produksi == 1) {
                                            return '<span class="label label-warning">Selesai Produksi</span>';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                    </div>


                </div>
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <div class="" style="margin-top:20px;">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#bahan_baku">Bahan Baku</a></li>
                                <li><a data-toggle="tab" href="#hasil_produksi">Hasil Produksi</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="bahan_baku" class="tab-pane fade in active" style="margin-top:20px;">
                                    <p>
                                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Bahan Baku', ['akt-produksi-manual-detail-bb/create', 'id' => $model->id_produksi_manual], ['class' => 'btn btn-success']) ?>
                                    </p>
                                    <table class="table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query_bb = AktProduksiManualDetailBb::find()->where(['id_produksi_manual' => $model->id_produksi_manual])->asArray()->all();
                                            foreach ($query_bb as $key => $data) {
                                                # code...
                                                $id_item = AktItemStok::findOne($data['id_item_stok']);
                                                $item = AktItem::findOne($id_item->id_item);
                                            ?>
                                                <tr>
                                                    <td><?= $no++ . '.' ?></td>
                                                    <td>
                                                        <?= $item->nama_item ?>

                                                    </td>
                                                    <td><?= $data['qty'] ?></td>
                                                    <td><?= $data['keterangan'] ?></td>
                                                    <td>
                                                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-produksi-manual-detail-bb/update', 'id' => $data['id_produksi_manual_detail_bb']], ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-produksi-manual-detail-bb/delete', 'id' => $data['id_produksi_manual_detail_bb']], [
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
                                <div id="hasil_produksi" class="tab-pane fade" style="margin-top:20px;">
                                    <p>
                                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Hasil Produksi', ['akt-produksi-manual-detail-hp/create', 'id' => $model->id_produksi_manual], ['class' => 'btn btn-success']) ?>
                                    </p>
                                    <table class="table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query_bb = AktProduksiManualDetailHp::find()->where(['id_produksi_manual' => $model->id_produksi_manual])->asArray()->all();
                                            foreach ($query_bb as $key => $data) {
                                                # code...
                                                $id_item = AktItemStok::findOne($data['id_item_stok']);
                                                $item = AktItem::findOne($id_item->id_item);
                                            ?>
                                                <tr>
                                                    <td><?= $no++ . '.' ?></td>
                                                    <td><?= $item->nama_item ?></td>
                                                    <td><?= $data['qty'] ?></td>
                                                    <td><?= $data['keterangan'] ?></td>
                                                    <td>
                                                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-produksi-manual-detail-hp/update', 'id' => $data['id_produksi_manual_detail_hp']], ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-produksi-manual-detail-hp/delete', 'id' => $data['id_produksi_manual_detail_hp']], [
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