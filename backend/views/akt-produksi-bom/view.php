<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktProduksiBomDetailBb;
use backend\models\AktBomDetailBb;
use backend\models\AktItem;
use backend\models\AktApprover;
use backend\models\AktItemStok;
use backend\models\AktProduksiBomDetailHp;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiBom */

$this->title = 'Detail Daftar Produksi B.o.M : ' . $model->no_produksi_bom;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-produksi-bom-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Produksi B.o.M', ['index']) ?></li>
        <li class="active">Detail Daftar Produksi B.o.M : <?= $model->no_produksi_bom ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        // $approve = AktApprover::find()->where(['id_jenis_approver' => 10])->one();
        $approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Produksi Bill Of Material'])
            ->asArray()
            ->all();
        $id_login =  Yii::$app->user->identity->id_login;
        if ($model->status_produksi == 0) {
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_produksi_bom], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_produksi_bom], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?php
            foreach ($approve as $key => $value) {
                if ($id_login == $value['id_login']) { ?>
                    <?= Html::a('<span class="glyphicon glyphicon-check"></span> Approved', ['approved', 'id' => $model->id_produksi_bom], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Are you sure you want to approve this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_produksi_bom], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to reject this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
        <?php }
            }
        } ?>
        <?php
        foreach ($approve as $key => $value) {
            if (($model->status_produksi == 1 || $model->status_produksi == 3) && $id_login == $value['id_login']) { ?>
                <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_produksi_bom], [
                    'class' => 'btn btn-info',
                    'data' => [
                        'confirm' => 'Are you sure you want to pending this item?',
                        'method' => 'post',
                    ],
                ]) ?>
        <?php }
        } ?>
        <?php if ($model->status_produksi == 1 || $model->status_produksi == 3) { ?>
            <?= Html::a('<i class="fa fa-tasks" aria-hidden="true"></i> Tutup Produksi', ['tutup', 'id' => $model->id_produksi_bom], ['class' => 'btn btn-info']) ?>
        <?php } ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['print', 'id' => $model->id_produksi_bom], ['class' => 'btn btn-default', 'target' => 'blank']) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-area-chart"></span> Produksi B.o.M</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_produksi_bom',
                                'no_produksi_bom',
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
                                    'attribute' => 'id_bom',
                                    'value' => function ($model) {
                                        return $model->bom->no_bom;
                                    }
                                ],
                                [
                                    'attribute' => 'tipe',
                                    'value' => function ($model) {
                                        if ($model->tipe == 1) {
                                            return 'De-Produksi';
                                        } else {
                                            return 'Produksi';
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
                                            return '<span class="label label-default">Persiapan Produksi</span>';
                                        } else if ($model->status_produksi == 1) {
                                            return '<span class="label label-success">Proses Produksi</span>';
                                        } else if ($model->status_produksi == 2) {
                                            return '<span class="label label-warning">Selesai Produksi</span>';
                                        } else if ($model->status_produksi == 3) {
                                            return '<span class="label label-danger">Ditolak</span>';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                        <div class="" style="margin-top:20px;">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#bahan_baku">Bahan Baku</a></li>
                                <li><a data-toggle="tab" href="#hasil_produksi">Hasil Produksi</a></li>
                            </ul>

                            <div class="tab-content">
                                <?php if ($model->status_produksi != 0) {
                                    $hide = 'hidden';
                                } else {
                                    $hide = '';
                                } ?>
                                <div id="bahan_baku" class="tab-pane fade in active" style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-md-12 <?= $hide; ?>">
                                            <?= Html::beginForm(['akt-produksi-bom/view', 'aksi' => 'save', 'id' => Yii::$app->request->get('id')], 'post') ?>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <?php $data = ArrayHelper::map(AktItemStok::find()->all(), 'id_item_stok', function ($model_item) {
                                                            $nama_item = Yii::$app->db->createCommand("SELECT nama_item FROM akt_item WHERE id_item = '$model_item->id_item'")->queryScalar();
                                                            $gudang = Yii::$app->db->createCommand("SELECT nama_gudang FROM akt_gudang WHERE id_gudang = '$model_item->id_gudang'")->queryScalar();
                                                            return $nama_item . ' - ' . $gudang . ' - ' . $model_item->qty;
                                                        }) ?>
                                                        <?= Select2::widget([
                                                            // 'model' => $model,
                                                            'name' => 'id_item_stok',
                                                            'data' => $data,
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok', 'required' => true],
                                                            'pluginOptions' => [
                                                                'allowClear' => true
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <?= Html::input("number", "qty", "", ["class" => "form-control", "placeholder" => "Qty", "id" => "qty", 'required' => true]) ?>
                                                        <input type="text" name="id_bom" value="<?= $model->id_bom ?>" id="id_bom" class="hidden">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <?= Html::input("number", "harga", "", ["class" => "form-control", "placeholder" => "Harga", "id" => "harga", 'required' => true]) ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <?= Html::input("text", "keterangan", "", ["class" => "form-control", "placeholder" => "Keterangan", "id" => "keterangan",]) ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                </div>
                                            </div>
                                            <?= Html::endForm() ?>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Keterangan</th>
                                                        <th class="<?= $hide; ?>">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    // $query_bb = AktProduksiBomDetailBb::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->asArray()->all();
                                                    $query_bb = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->asArray()->all();
                                                    foreach ($query_bb as $key => $data) {
                                                        # code...
                                                        $id_item = AktItemStok::findOne($data['id_item_stok']);
                                                        $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $data['id_item_stok'] . "'")->queryScalar();
                                                        if (!empty($id_item->id_item_stok)) {
                                                            $item = AktItem::findOne($id_item->id_item);
                                                    ?>
                                                            <tr>
                                                                <td><?= $no++ . '.' ?></td>
                                                                <td>
                                                                    <?= $item->nama_item
                                                                    ?>
                                                                    <br>
                                                                    <?php
                                                                    if ($cek_qty >= $data['qty']) {
                                                                    ?>
                                                                        <p class="label label-primary">Stok Tersedia</p>
                                                                    <?php } else {
                                                                    ?>
                                                                        <p class="label label-danger">Stok Tidak Tersedia</p>
                                                                    <?php }
                                                                    ?>
                                                                </td>
                                                                <td><?= $data['qty'] ?></td>
                                                                <td><?= $data['harga'] ?></td>
                                                                <td><?= $data['keterangan'] ?></td>
                                                                <td class="<?= $hide; ?>">
                                                                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-bom-detail-bb/update-produksi', 'id' => $data['id_bom_detail_bb']], ['class' => 'btn btn-primary']) ?>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-bom-detail-bb/delete2', 'id' => $data['id_bom_detail_bb']], [
                                                                        'class' => 'btn btn-danger',
                                                                        'data' => [
                                                                            'confirm' => 'Are you sure you want to delete this item?',
                                                                            'method' => 'post',
                                                                        ],
                                                                    ]) ?>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div id="hasil_produksi" class="tab-pane fade" style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-md-12 <?= $hide; ?>">
                                            <?= Html::beginForm(['akt-produksi-bom/view', 'aksi' => 'hasil', 'id' => Yii::$app->request->get('id')], 'post') ?>

                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <?php $data2 = ArrayHelper::map(AktItemStok::find()->all(), 'id_item_stok', function ($model_item) {
                                                            $nama_item = Yii::$app->db->createCommand("SELECT nama_item FROM akt_item WHERE id_item = '$model_item->id_item'")->queryScalar();
                                                            $gudang = Yii::$app->db->createCommand("SELECT nama_gudang FROM akt_gudang WHERE id_gudang = '$model_item->id_gudang'")->queryScalar();
                                                            return $nama_item . ' - ' . $gudang . ' - ' . $model_item->qty;
                                                        }) ?>
                                                        <?= Select2::widget([
                                                            // 'model' => $model,
                                                            'name' => 'id_item_stok',
                                                            'data' => $data2,
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok2', 'required' => true],
                                                            'pluginOptions' => [
                                                                'allowClear' => true
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <?= Html::input("number", "qty", "", ["class" => "form-control", "placeholder" => "Qty", "id" => "qty", 'required' => true]) ?>
                                                        <input type="text" name="id_bom" value="<?= $model->id_bom ?>" id="id_bom" class="hidden">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <?= Html::input("text", "keterangan", "", ["class" => "form-control", "placeholder" => "Keterangan", "id" => "keterangan",]) ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                </div>
                                            </div>
                                            <?= Html::endForm() ?>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Keterangan</th>
                                                        <th class="<?= $hide; ?>">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $query_bb = AktProduksiBomDetailHp::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->asArray()->all();
                                                    foreach ($query_bb as $key => $data) {
                                                        # code...
                                                        $id_item = AktItemStok::findOne($data['id_item_stok']);
                                                        $item = AktItem::find()->where(['id_item' => $id_item->id_item])->one();
                                                        $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $data['id_item_stok'] . "'")->queryScalar();
                                                    ?>
                                                        <tr>
                                                            <td><?= $no++ . '.' ?></td>
                                                            <td>
                                                                <?= $item->nama_item
                                                                ?>
                                                                <br>
                                                                <?php
                                                                if ($cek_qty >= $data['qty']) {
                                                                ?>
                                                                    <p class="label label-primary">Stok Tersedia</p>
                                                                <?php } else {
                                                                ?>
                                                                    <p class="label label-danger">Stok Tidak Tersedia</p>
                                                                <?php }
                                                                ?>
                                                            </td>
                                                            <td><?= $data['qty'] ?></td>
                                                            <td><?= $data['keterangan'] ?></td>
                                                            <td class="<?= $hide; ?>">
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-produksi-bom-detail-hp/update', 'id' => $data['id_produksi_bom_detail_hp']], ['class' => 'btn btn-primary']) ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-produksi-bom-detail-hp/delete', 'id' => $data['id_produksi_bom_detail_hp']], [
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
    </div>
</div>