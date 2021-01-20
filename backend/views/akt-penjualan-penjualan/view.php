<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\AktPenjualan;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
use backend\models\AktApprover;
use backend\models\AktKasBank;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */

$this->title = 'Detail Data Penjualan : ' . $model->no_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$id_login =  Yii::$app->user->identity->id_login;
$cek_login = AktApprover::find()
    ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
    ->where(['=', 'nama_jenis_approver', 'Penjualan'])
    ->andWhere(['id_login' => $id_login])
    ->asArray()
    ->one();
$count_query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->count();
?>
<div class="akt-penjualan-penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        if ($model->status == 2) {
            # code...
        ?>
            <?php if ($model->jenis_bayar == null && $is_penjualan->status == 1 && $cek_login == null) { ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penjualan], [
                    'class' => 'btn btn-danger btn-hapus-hidden',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menghapus Data Penjualan : ' . $model->no_penjualan . ' ?',
                        'method' => 'post',
                    ],
                ]) ?>

            <?php } ?>

            <?php if ($count_query_detail != 0 && $is_penjualan->status == 1) { ?>
                <?php if ($model->jenis_bayar == null) {
                ?>
                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah Data Penjualan', ['#', 'id' => $model->id_penjualan], [
                        'class' => 'btn btn-info',
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-default'
                    ]) ?>

                <?php  } else if ($model->jenis_bayar != null) {
                ?>
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus Data Penjualan', ['hapus-data-penjualan', 'id' => $model->id_penjualan], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Anda yakin ingin menghapus data?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php  }
                ?>
            <?php } ?>

            <?php
            $show_hide = 0;
            $query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();

            foreach ($query_detail as $key => $data) {
                # code...
                $item_stok = AktItemStok::findOne($data['id_item_stok']);

                $a = ($data['qty'] > $item_stok->qty) ? 1 : 0;

                $show_hide += $a;
            }
            ?>
            <?php
            if ($show_hide == 0 && $count_query_detail != 0) {
                # code...
            ?>
                <?php
                if ($count_data_penjualan_count == 0) {
                    # code...
                ?>
                    <?= Html::a('<span class="fa fa-truck"></span> Pengiriman', ['pengiriman', 'id' => $model->id_penjualan], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Apakah anda yakin akan menyetujui pengiriman Data Penjualan : ' . $model->no_penjualan . ' ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                <?php
                }
                ?>
        <?php
            }
        }
        ?>
        <?php
        if ($model->status >= 2 && $model->status != 5) {
            # code...
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak Invoice Non PPN', ['cetak-invoice-ppn', 'id' => $model->id_penjualan], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak Invoice PPN', ['cetak-invoice', 'id' => $model->id_penjualan], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak Standard', ['cetak-standard', 'id' => $model->id_penjualan], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak Surat Pesanan', ['cetak-surat-pesanan', 'id' => $model->id_penjualan], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
        <?php } ?>

        <?php if ($id_login == 11) { ?>
            <?= Html::a(' Post To Jurnal Umum', ['post-to-jurnal-umum', 'id' => $model->id_penjualan], [
                'class' => 'btn btn-info',
                'data' => [
                    'method' => 'post',
                ],
            ]) ?>

        <?php } ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-copy"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_penjualan',
                                    'no_penjualan',
                                    [
                                        'attribute' => 'tanggal_penjualan',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_penjualan)) {
                                                return tanggal_indo($model->tanggal_penjualan, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    'no_faktur_penjualan',
                                    [
                                        'attribute' => 'tanggal_faktur_penjualan',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_faktur_penjualan)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_faktur_penjualan, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_penjualan',
                                    [
                                        'attribute' => 'jenis_bayar',
                                        'value' => function ($model) {
                                            if ($model->jenis_bayar == 1) {
                                                # code...
                                                return 'CASH';
                                            } elseif ($model->jenis_bayar == 2) {
                                                # code...
                                                return 'CREDIT';
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'jumlah_tempo',
                                        'visible' => ($model->jenis_bayar == 2) ? true : false,
                                    ],
                                    [
                                        'attribute' => 'tanggal_tempo',
                                        'visible' => ($model->jenis_bayar == 2) ? true : false,
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_tempo)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_tempo, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    // 'materai',
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $the_approver_name = "";
                                            if (!empty($model->approver->nama)) {
                                                # code...
                                                $the_approver_name = $model->approver->nama;
                                            }

                                            $the_approver_date = "";
                                            if (!empty($model->the_approver_date)) {
                                                # code...
                                                $the_approver_date = tanggal_indo2(date('D, d F Y H:i', strtotime($model->the_approver_date)));
                                            }

                                            if ($model->status == 1) {
                                                # code...
                                                return "<span class='label label-default'>Order Penjualan</span>";
                                            } elseif ($model->status == 2) {
                                                # code...
                                                if (AktPenjualan::cekButtonPenjualan()->status == 0 && $model->no_order_penjualan != null) {
                                                    return "<span class='label label-warning'>Penjualan disetujui pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                                } else if (AktPenjualan::cekButtonPenjualan()->status == 1 || $model->no_order_penjualan == null) {
                                                    if ($model->jenis_bayar == null) {
                                                        return "<span class='label label-danger'>Penjualan | Belum disetting </span>";
                                                    } else {
                                                        return "<span class='label label-warning'>Penjualan | Sudah disetting </span>";
                                                    }
                                                }
                                            } elseif ($model->status == 3) {
                                                # code...
                                                return "<span class='label label-primary'>Pengiriman</span>";
                                            } elseif ($model->status == 4) {
                                                # code...
                                                return "<span class='label label-success'>Selesai</span>";
                                            } elseif ($model->status == 5) {
                                                # code...
                                                return "<span class='label label-danger'>Ditolak pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-box"></span> Data Barang Penjualan</a></li>
                            <li><a data-toggle="tab" href="#isi-data-penjualan"> <span class="glyphicon glyphicon-shopping-cart"></span> Data Order Penjualan</a></li>
                            <li><a data-toggle="tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                            <li><a data-toggle="tab" href="#faktur"><span class="glyphicon glyphicon-list-alt"></span> Faktur</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang" class="tab-pane fade in active" style="margin-top:10px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <div class="row form-user">
                                                <?php
                                                if ($model->status <= 2 && $cek_login == null && $is_penjualan->status == 1 && $model->jenis_bayar == null) {
                                                    # code...
                                                ?>
                                                    <?php $form = ActiveForm::begin([
                                                        'method' => 'post',
                                                        'action' => ['akt-penjualan-detail/create-from-data-penjualan'],
                                                    ]); ?>

                                                    <?= $form->field($model_penjualan_detail_baru, 'id_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                    <div class="col-md-4">
                                                        <?= $form->field($model_penjualan_detail_baru, 'id_item_stok')->widget(Select2::classname(), [
                                                            'data' => $data_item_stok,
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok'],
                                                            'pluginOptions' => [
                                                                'allowClear' => true
                                                            ],
                                                        ])
                                                        ?>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <?= $form->field($model_penjualan_detail_baru, 'id_item_harga_jual')->widget(DepDrop::classname(), [
                                                            'type' => DepDrop::TYPE_SELECT2,
                                                            'options' => ['id' => 'id-harga-jual', 'placeholder' => 'Pilih Level Harga...'],
                                                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                            'pluginOptions' => [
                                                                'depends' => ['id_item_stok'],
                                                                'url' => Url::to(['/akt-penjualan/level-harga'])
                                                            ]
                                                        ])->label('Level Harga');
                                                        ?>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <?= $form->field($model_penjualan_detail_baru, 'harga')->textInput(['maxlength' => true, 'readonly' => false, 'autocomplete' => 'off', 'id' => 'harga']) ?>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <?= $form->field($model_penjualan_detail_baru, 'qty')->textInput(['autocomplete' => 'off']) ?>
                                                    </div>
                                                    <div class="col-md-7" style="margin-bottom: 10px;">
                                                        <?= $form->field($model_penjualan_detail_baru, 'jenis_diskon')->dropDownList(
                                                            array(
                                                                1 => 'Diskon (%)',
                                                                2 => 'Diskon Bertingkat',
                                                                3 => 'Diskon Nominal'
                                                            ),
                                                            ['prompt' => 'Pilih Jenis Diskon']
                                                        )->label(false) ?>
                                                    </div>

                                                    <div class="col-md-5 diskon-persen">
                                                        <?= $form->field($model_penjualan_detail_baru, 'diskon')->textInput(['type' => 'text', 'placeholder' => 'Diskon %', 'name' => 'diskon-persen', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'autocomplete' => 'off', 'id' => 'diskon-persen'])->label(false) ?>
                                                    </div>

                                                    <div class="col-md-5 diskon-nominal">
                                                        <?= $form->field($model_penjualan_detail_baru, 'diskon')->textInput(['type' => 'text', 'placeholder' => 'Diskon', 'name' => 'diskon-nominal', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-nominal', 'autocomplete' => 'off'])->label(false) ?>
                                                    </div>

                                                    <div class="col-md-1 bertingkat1">
                                                        <?= $form->field($model_penjualan_detail_baru, 'diskon')->textInput(['type' => 'text', 'autocomplete' => 'off', 'name' => 'diskon1', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-1'])->label(false) ?>
                                                    </div>
                                                    <input type="hidden" id="harga_tetap" name="harga_tetap" />
                                                    <div class="col-md-1 bertingkat2">
                                                        <?= $form->field($model_penjualan_detail_baru, 'diskon2')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-2'])->label(false) ?>
                                                    </div>
                                                    <div class="col-md-1 bertingkat3">
                                                        <?= $form->field($model_penjualan_detail_baru, 'diskon3')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-3'])->label(false) ?>
                                                    </div>
                                                    <div class="col-md-1 bertingkat4">
                                                        <?= $form->field($model_penjualan_detail_baru, 'diskon4')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-4'])->label(false) ?>
                                                    </div>
                                                    <div class="col-md-1 bertingkat5">
                                                        <?= $form->field($model_penjualan_detail_baru, 'diskon5')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-5'])->label(false) ?>
                                                    </div>



                                                    <div class="col-md-10">
                                                        <?= $form->field($model_penjualan_detail_baru, 'keterangan')->textarea(['rows' => 1, 'placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Tambahkan', ['class' => 'btn btn-success', 'name' => 'create-from-penjualan', 'style' => 'width:100%;']) ?>
                                                    </div>

                                                    <?php ActiveForm::end(); ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">No.</th>
                                                    <th style="width: 20%;">Nama Barang</th>
                                                    <th style="width: 5%;">Jenis</th>
                                                    <th style="width: 5%;">Gudang</th>
                                                    <th style="width: 5%;">Qty</th>
                                                    <th style="width: 5%;">Harga</th>
                                                    <th style="width: 10%;">Diskon</th>
                                                    <th style="width: 20%;">Keterangan</th>
                                                    <th style="width: 10%;">Sub Total</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $totalan_total = 0;
                                                $query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
                                                foreach ($query_detail as $key => $data) {
                                                    # code...
                                                    $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                                    $item = AktItem::findOne($item_stok->id_item);
                                                    $gudang = AktGudang::findOne($item_stok->id_gudang);
                                                    $harga_jual = AktItemHargaJual::findOne($data['id_item_harga_jual']);
                                                    $level_harga = AktLevelHarga::findOne($harga_jual->id_level_harga);
                                                    $totalan_total += $data['total'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td>
                                                            <?php
                                                            echo $item->nama_item;
                                                            if ($model->status == 2) {
                                                                # code...
                                                                echo "<br>";
                                                                if ($data['qty'] > $item_stok->qty) {
                                                                    # code...
                                                                    echo "<span class='label label-danger'>Melebihi Stok</span>";
                                                                } else {
                                                                    # code...
                                                                    echo "<span class='label label-success'>Stok Tersedia</span>";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?= $level_harga->keterangan ?></td>
                                                        <td><?= (!empty($gudang->nama_gudang)) ? $gudang->nama_gudang : '' ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td style="white-space: nowrap;"><?= ribuan($data['harga']) ?></td>
                                                        <td style="white-space: nowrap;">
                                                            <?php if ($data['jenis_diskon'] == 1) { ?>
                                                                <?= $data['diskon'] ?>%

                                                            <?php } else if ($data['jenis_diskon'] == 2) { ?>

                                                                <?= $data['diskon'] == null ? 0 :  $data['diskon'] ?>% | <?= $data['diskon2'] == null ? 0 :  $data['diskon2'] ?>% | <?= $data['diskon3'] == null ? 0 :  $data['diskon3'] ?>% | <?= $data['diskon4'] == null ? 0 :  $data['diskon4'] ?>% | <?= $data['diskon5'] == null ? 0 :  $data['diskon5'] ?>%

                                                            <?php } else { ?>

                                                                Rp. <?= ribuan($data['diskon']) ?>

                                                            <?php } ?>


                                                        </td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td style="text-align: right;white-space: nowrap;"><?= ribuan($data['total']) ?></td>
                                                        <?php
                                                        if ($model->status <= 2 && $cek_login == null && $is_penjualan->status == 1 && $model->jenis_bayar == null) {
                                                            # code...
                                                        ?>
                                                            <td style="white-space: nowrap;">
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-penjualan-detail/update-from-penjualan', 'id' => $data['id_penjualan_detail']], ['class' => 'btn btn-primary']) ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-penjualan-detail/delete-from-order-penjualan', 'id' => $data['id_penjualan_detail'], 'type' => 'penjualan_langsung'], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Apakah Anda yakin akan menghapus ' . $item->nama_item . ' dari Data Barang Penjualan?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Total Harga</th>
                                                    <th style="text-align: right;"><?= ribuan($totalan_total) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Diskon <?= $model->diskon ?> %</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $diskon = ($model->diskon * $totalan_total) / 100;
                                                        echo ribuan($diskon);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Pajak 10 % (<?= ($model->pajak == NULL) ? '' : $retVal = ($model->pajak == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $pajak_ = (($totalan_total - $diskon) * 10) / 100;
                                                        $pajak = ($model->pajak == 1) ? $pajak_ : 0;
                                                        echo ribuan($pajak);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Ongkir</th>
                                                    <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Materai</th>
                                                    <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
                                                </tr>
                                                <tr>
                                                    <?php $grandtotal = $totalan_total + $model->ongkir + $pajak - $diskon ?>
                                                    <th colspan="8" style="text-align: right;">Grand Total</th>
                                                    <th style="text-align: right;"><?= ribuan($grandtotal) ?></th>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);
                                                    ?>
                                                    <th colspan="8" style="text-align: right;">Uang Muka <?= $akt_kas_bank == false ? '' :  ' | ' . $akt_kas_bank['keterangan'] ?> </th>
                                                    <th style="text-align: right;"><?= ribuan($model->uang_muka) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="8" style="text-align: right;">Sisa Dana yang Masih Harus Diterima</th>
                                                    <th style="text-align: right;"><?= ribuan($grandtotal - $model->uang_muka) ?></th>
                                                </tr>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="isi-data-penjualan" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <?= DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                                    'attributes' => [
                                                        // 'id_penjualan',
                                                        'no_order_penjualan',
                                                        [
                                                            'attribute' => 'tanggal_order_penjualan',
                                                            'value' => function ($model) {
                                                                if ($model->tanggal_order_penjualan != null) {
                                                                    return tanggal_indo($model->tanggal_order_penjualan, true);
                                                                }
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'id_customer',
                                                            'value' => function ($model) {
                                                                if (!empty($model->customer->nama_mitra_bisnis)) {
                                                                    # code...
                                                                    return $model->customer->nama_mitra_bisnis;
                                                                } else {
                                                                    # code...
                                                                }
                                                            }
                                                        ],
                                                    ],
                                                ]) ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?= DetailView::widget([
                                                    'model' => $model,
                                                    'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                                    'attributes' => [
                                                        // 'id_penjualan',
                                                        [
                                                            'attribute' => 'id_sales',
                                                            'value' => function ($model) {
                                                                if (!empty($model->sales->nama_sales)) {
                                                                    # code...
                                                                    return $model->sales->nama_sales;
                                                                } else {
                                                                    # code...
                                                                }
                                                            }
                                                        ],
                                                        [
                                                            'attribute' => 'id_mata_uang',
                                                            'value' => function ($model) {
                                                                if (!empty($model->mata_uang->mata_uang)) {
                                                                    # code...
                                                                    return $model->mata_uang->mata_uang;
                                                                } else {
                                                                    # code...
                                                                }
                                                            }
                                                        ],
                                                    ],
                                                ]) ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div id="unggah-dokumen" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">
                                        <?= Html::beginForm(['akt-penjualan-penjualan/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                        <?= Html::hiddenInput("id_tabel", $model->id_penjualan) ?>
                                        <?= Html::hiddenInput("nama_tabel", "penjualan") ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">UPLOAD FOTO ATAU DOKUMEN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input class='btn btn-warning' type="file" name="foto" id="exampleInputFile" required><br>
                                                        <b style="color: red;">Catatan:<br>- File harus bertype jpg, png, jpeg, excel, work, pdf<br>- Ukuran maksimal 2 MB.</b>
                                                    </td>
                                                    <td>
                                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?= Html::endForm() ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>DOKUMEN :</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <?php foreach ($foto as $data) { ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th width="80%">
                                                            <a target="_BLANK" href="/accounting/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                        </th>
                                                        <th width="20%">
                                                            <a href="index.php?r=akt-penjualan-penjualan/view&id=<?php echo $model->id_penjualan; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')"><img src='images/hapus.png' width='20'></a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div id="faktur" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <?= Html::beginForm(['faktur', 'id' => $model->id_penjualan], 'post') ?>

                                        <div class="form-group">
                                            <label for="no_faktur_penjualan">No. Faktur Pajak</label>
                                            <input type="text" id="no_faktur_penjualan" name="no_faktur_penjualan" placeholder="No. Faktur" value="<?= $model->no_faktur_penjualan ?>" class="form-control" autocomplete="off" required <?= ($model->status == 2) ? '' : 'readonly' ?>>
                                        </div>

                                        <div class="form-group">
                                            <label for="tanggal_faktur_penjualan">Tanggal Faktur Pajak</label>
                                            <input type="date" id="tanggal_faktur_penjualan" name="tanggal_faktur_penjualan" value="<?= $model->tanggal_faktur_penjualan ?>" class="form-control" required <?= ($model->status == 2) ? '' : 'readonly' ?>>
                                        </div>

                                        <div class="form-group">
                                            <?php
                                            if ($model->status == 2) {
                                                # code...
                                            ?>
                                                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                        <?= Html::endForm() ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .style-kas-bank {
            display: none;
        }

        @media (min-width: 992px) {
            .modal-content {
                margin: 0 -150px;
            }

        }
    </style>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ubah Data Penjualan</h4>
                </div>
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['update-from-modal', 'id' => $_GET['id']],
                ]); ?>
                <div class="modal-body">

                    <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Penjualan</label>

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'no_penjualan')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_penjualan')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                            <?= $form->field($model, 'id_customer')->widget(Select2::classname(), [
                                'data' => $data_customer,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Customer'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'addon' => [
                                    'prepend' => [
                                        'content' => '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-customer"><span class="glyphicon glyphicon-plus"></span></button>',
                                        'asButton' => true,
                                    ],
                                ],
                            ]) ?>

                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'id_sales')->widget(Select2::classname(), [
                                'data' => $data_sales,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Sales'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                                'addon' => [
                                    'prepend' => [
                                        'content' => '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-sales"><span class="glyphicon glyphicon-plus"></span></button>',
                                        'asButton' => true,
                                    ],
                                ],
                            ])
                            ?>

                            <?= $form->field($model, 'id_mata_uang')->widget(Select2::classname(), [
                                'data' => $data_mata_uang,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Mata Uang'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>

                        </div>
                    </div>
                    <?php if ($count_query_detail > 0) {  ?>
                        <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Perhitungan Penjualan</label>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'ongkir')->widget(\yii\widgets\MaskedInput::className(), [
                                    'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                    'options' => ['value' => $model->ongkir == '' ? 0 : $model->ongkir, 'autocomplete' => 'off', 'required' => true]
                                ]); ?>
                                <?= $form->field($model, 'diskon')->textInput(['value' => $model->diskon == '' ? 0 : $model->diskon, 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'id' => 'diskon-floating', 'class' => 'form-control diskon-penjualan'])->label('Diskon %') ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'uang_muka')->widget(\yii\widgets\MaskedInput::className(), [
                                            'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                            'options' => ['value' => $model->uang_muka == '' ? 0 : $model->uang_muka, 'required' => true]
                                        ]); ?>

                                    </div>
                                    <div id="kas-bank" class="col-md-12 kas-bank style-kas-bank">
                                        <?= $form->field($model, 'id_kas_bank')->widget(Select2::classname(), [
                                            'data' => $data_kas_bank,
                                            'language' => 'en',
                                            'options' => ['placeholder' => 'Pilih Kas Bank Uang Muka', 'id' => 'id_kas_bank'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                        ])
                                        ?>
                                    </div>
                                </div>

                                <table>
                                    <tr>
                                        <td style="height: 14px;"></td>
                                    </tr>
                                </table>
                                <?= $form->field($model, 'pajak')->checkbox(['class' => 'pajak_penjualan']) ?>
                                <table>
                                    <tr>
                                        <td style="height: 14px;"></td>
                                    </tr>
                                </table>

                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'jenis_bayar')->dropDownList(
                                    array(1 => "CASH", 2 => "CREDIT"),
                                    [
                                        'prompt' => 'Pilih Jenis Pembayaran',
                                        'required' => $count_query_detail > 0 ? 'on' : 'off',
                                    ]
                                ) ?>

                                <?= $form->field($model, 'jumlah_tempo', ['options' => ['id' => 'jumlah_tempo', 'hidden' => 'yes']])->dropDownList(array(
                                    15 => 15,
                                    30 => 30,
                                    45 => 45,
                                    60 => 60,
                                ), ['prompt' => 'Pilih Jumlah Tempo']) ?>

                                <?= $form->field($model, 'materai')->widget(\yii\widgets\MaskedInput::className(), [
                                    'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                    'options' => ['required' => true]
                                ]); ?>

                                <label for="total_penjualan_detail">Total Penjualan Barang</label>
                                <?= Html::input("text", "total_penjualan_detail", ribuan($total_penjualan_detail), ['class' => 'form-control', 'readonly' => false, 'id' => 'total_penjualan_detail']) ?>


                                <!-- <div class="form-group" style="margin-top:20px;">
                                    <label for="total_perhitungan">Kekurangan Pembayaran</label>
                                    <input id="total_perhitungan" readonly class="form-control">
                                </div> -->
                            </div>
                        </div>

                    <?php } ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-saved"></span> Simpan</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <!-- add new customer -->
    <div class="modal fade" id="modal-customer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Data Customer</h4>
                </div>
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-penjualan/add-new-customer', 'id' => $_GET['id'], 'type' => 'penjualan_langsung'],
                ]); ?>
                <div class="modal-body">

                    <?= $form->field($model_new_customer, 'nama_mitra_bisnis')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model_new_customer, 'deskripsi_mitra_bisnis')->textarea(['rows' => 3]) ?>

                    <?= $form->field($model_new_customer, 'tipe_mitra_bisnis')->dropDownList(array(1 => "Customer", 3 => "Customer & Supplier")) ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

    <!-- add new sales -->
    <div class="modal fade" id="modal-sales">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Data Sales</h4>
                </div>
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-penjualan/add-new-sales', 'id' => $_GET['id'], 'type' => 'penjualan_langsung'],
                ]); ?>
                <div class="modal-body">

                    <?= $form->field($model_new_sales, 'nama_sales')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model_new_sales, 'telepon')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model_new_sales, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model_new_sales, 'alamat')->textarea(['rows' => 3]) ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


    <?php
    $script = <<< JS


    $(document).ready(function(){ 

        
        $('.diskon-persen').hide(); 
        $('.diskon-nominal').hide(); 
        hide_bertingkat();

    if ($("#aktpenjualan-jenis_bayar").val() == "1")
    {
        $("#aktpenjualan-jumlah_tempo").hide();
        $('#jumlah_tempo').hide(); 
        $("#aktpenjualan-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualan-jenis_bayar").val() == "2")
    {
        $("#aktpenjualan-jumlah_tempo").show();
        $('#jumlah_tempo').show(); 
        $("#aktpenjualan-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }

    $("#aktpenjualan-jenis_bayar").change(function(){

    if ($("#aktpenjualan-jenis_bayar").val() == "1")
    {
        $("#aktpenjualan-jumlah_tempo").hide();
        $('#jumlah_tempo').hide(); 
        $("#aktpenjualan-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualan-jenis_bayar").val() == "2")
    {
        $("#aktpenjualan-jumlah_tempo").show();
        $('#jumlah_tempo').show(); 
        $("#aktpenjualan-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }
    
    });
    });

    function hilang_titik(string) {
        return string.split('.').join('');
    }

    function is_null_diskon(value, jenis) {
        if(value == null || value == 0 || value == '' ) {
            $(jenis).hide();
        } else {
            $(jenis).show();
        }
    }

    function hide_bertingkat() {
        $('.bertingkat1').hide(); 
        $('.bertingkat2').hide();
        $('.bertingkat3').hide(); 
        $('.bertingkat4').hide(); 
        $('.bertingkat5').hide(); 
    }

    // function hitung_harga_tetap(type, harga_tetap, value1, value2 = 0, value3 = 0, value4 = 0, value5 = 0){

    //     var diskon_in_nominal1 = harga_tetap * value1 / 100;
    //     var last_value1 = harga_tetap - diskon_in_nominal1;

    //     var diskon_in_nominal2 = last_value1 * value2 / 100;
    //     var last_value2 = last_value1 - diskon_in_nominal2;

    //     var diskon_in_nominal3 = last_value2 * value3 / 100;
    //     var last_value3 = last_value2 - diskon_in_nominal3;

    //     var diskon_in_nominal4 = last_value3 * value4 / 100;
    //     var last_value4 = last_value3 - diskon_in_nominal4;

    //     var diskon_in_nominal5 = last_value4 * value5 / 100;
    //     var last_value5 = last_value4 - diskon_in_nominal5;

    //     if(type == 'diskon1') {
    //         $("#harga").val(formatNumber(last_value1));
    //     } else if (type == 'diskon2') {
    //         $("#harga").val(formatNumber(last_value2));
    //     } else if (type == 'diskon3') {
    //         $("#harga").val(formatNumber(last_value3));
    //     } else if (type == 'diskon4') {
    //         $("#harga").val(formatNumber(last_value4));
    //     } else if (type == 'diskon5') {
    //         $("#harga").val(formatNumber(last_value5));
    //     }


    // }


    $("#aktpenjualandetail-jenis_diskon").change(function(){

        var value_harga = $("#harga").val();
        var harga_tetap = $("#harga_tetap").val();

        if ($("#aktpenjualandetail-jenis_diskon").val() == "1")
        {
            $(".diskon-persen").show();
            hide_bertingkat();
            $('.diskon-nominal').hide();  

            // $("#harga").val(formatNumber(harga_tetap));
            $("#diskon-nominal").val(0)
            $("#diskon-1").val(0)
            $("#diskon-2").val(0)
            $("#diskon-3").val(0)
            $("#diskon-4").val(0)
            $("#diskon-5").val(0)


            // $("#diskon-persen").change(function() {
            //    var value = $(this).val();
            //    var value_not_titik = hilang_titik(harga_tetap);
            //    var diskon_in_nominal = value_not_titik * value / 100;
            //    var last_value = value_not_titik - diskon_in_nominal;
            //    $("#harga").val(formatNumber(last_value));
            // })

        }
        
        if ($("#aktpenjualandetail-jenis_diskon").val() == "2")
        { 

            // $("#harga").val(formatNumber(harga_tetap));

            $(".diskon-persen").hide();
            $(".diskon-nominal").hide();
            $('.bertingkat1').show(); 

            $("#diskon-nominal").val(0);
            $("#diskon-persen").val(0)

            
            $("#diskon-1").change(function() {
               var value1 = $(this).val();
               is_null_diskon(value1, '.bertingkat2');
            //    hitung_harga_tetap('diskon1', harga_tetap, value1)

               $("#diskon-2").change(function() {
                    var value2 = $(this).val();
                    is_null_diskon(value2, '.bertingkat3');
                    // hitung_harga_tetap('diskon2', harga_tetap, value1, value2);

                    $("#diskon-3").change(function() {
                        var value3 = $(this).val();
                        is_null_diskon(value3, '.bertingkat4');
                        // hitung_harga_tetap('diskon3', harga_tetap, value1, value2,value3);
                        
                        $("#diskon-4").change(function() {
                            var value4 = $(this).val();
                            is_null_diskon(value4, '.bertingkat5');
                            // hitung_harga_tetap('diskon4', harga_tetap, value1, value2, value3, value4);

                            $("#diskon-5").change(function() {
                                var value5 = $(this).val();
                                // hitung_harga_tetap('diskon5', harga_tetap, value1, value2, value3, value4, value5);

                            })

                        })

                    })
                })

            })



        }

        if ($("#aktpenjualandetail-jenis_diskon").val() == "3")
        {

            $('.diskon-nominal').show();
            hide_bertingkat();
            $(".diskon-persen").hide();

            // $("#harga").val(formatNumber(harga_tetap));
            $("#diskon-persen").val(0)
            $("#diskon-1").val(0)
            $("#diskon-2").val(0)
            $("#diskon-3").val(0)
            $("#diskon-4").val(0)
            $("#diskon-5").val(0)


            // $("#diskon-nominal").change(function() {
            //    var value = $(this).val();
            //    var value_not_titik = hilang_titik(harga_tetap);
            //    var last_value = value_not_titik - value;
            //    $("#harga").val(formatNumber(last_value));
            // })

        }
    
    });

    let harga = document.querySelector('#harga');
    let harga_tetap = document.querySelector('#harga_tetap');
    harga.addEventListener('keyup', function(e){
        harga.value = formatRupiah(this.value);
        harga_tetap.value = this.value;
    });
    
    function formatNumber (number) {
        const formatNumbering = new Intl.NumberFormat("id-ID");
        return formatNumbering.format(number);
    };
    
    function formatRupiah(angka){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
    
    $('#id-harga-jual').on('change', function(){
        var id = $(this).val();
        $.ajax({
            url:'index.php?r=akt-penjualan-detail/get-harga-item',
            type : 'GET',
            data : 'id='+id,
            success : function(data){
                let dataJson = $.parseJSON(data);
                let hargaSatuan = formatNumber(dataJson.harga_satuan);
                harga.value = hargaSatuan;
                harga_tetap.value = dataJson.harga_satuan;
            }
        })
    })

JS;
    $this->registerJs($script);
    ?>

    <script>
        const elements = document.querySelectorAll('#diskon-floating');
        for (var i = 0; i < elements.length; i++) {
            elements[i].oninvalid = function(e) {
                e.target.setCustomValidity("");
                if (!e.target.validity.valid) {
                    e.target.setCustomValidity("Diskon hanya menerima inputan angka dan titik");
                }
            };
            elements[i].oninput = function(e) {
                e.target.setCustomValidity("");
            };
        }
        const kasBank = document.querySelector('#kas-bank');
        const uangMuka = document.querySelector('#aktpenjualan-uang_muka');
        const idKasBank = document.querySelector('#id_kas_bank');

        if (uangMuka.value != 0) {
            kasBank.classList.remove('style-kas-bank')
        }


        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        const total_pembelian_detail = document.querySelector('#total_penjualan_detail');

        function setValueDataPerhitungan(
            ongkir = 0,
            diskon = 0,
            uang_muka = 0,
            pajak = false,
            materai = 0
        ) {

            let total = total_pembelian_detail.value.split('.').join("");
            let hilang_titik = uang_muka.split('.').join("")


            if (ongkir == '' || ongkir == " " || ongkir == null ||
                diskon == '' || diskon == " " || diskon == null ||
                materai == '' || materai == " " || materai == null ||
                uang_muka == '' || uang_muka == " " || uang_muka == null
            ) {

                ongkir = 0;
                diskon = 0;
                materai = 0;
                uang_muka = 0;
            }

            let diskonRupiah;
            if (pajak == true) {
                diskonRupiah = diskon / 100 * total;
                let totalPajak = total - diskonRupiah;
                pajak = 10 / 100 * totalPajak;
            } else {
                pajak = 0;
                diskonRupiah = diskon / 100 * total;
            }

            let perhitungan = document.querySelector("#total_perhitungan");

            hitung = parseInt(total) + parseInt(ongkir) + pajak - parseInt(diskonRupiah) - parseInt(hilang_titik);
            let hitung2 = Math.floor(hitung);
            perhitungan.value = formatRupiah(String(hitung2));
        }

        const materai = document.querySelector('.materai-penjualan');
        const diskon = document.querySelector('.diskon-penjualan');
        const ongkir = document.querySelector('.ongkir_penjualan');
        const pajak = document.querySelector('.pajak_penjualan');

        diskon.addEventListener("input", (e) => {
            setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
        })

        uangMuka.addEventListener("input", (e) => {
            let val = e.target.value;
            uangMuka.value = formatRupiah(val);
            if (val == '' || val == 0) {
                kasBank.classList.add('style-kas-bank')
            } else(
                kasBank.classList.remove('style-kas-bank')
            )
            setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
        })

        materai.addEventListener("input", (e) => {
            materai.value = formatRupiah(e.target.value);
            // setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
        })

        ongkir.addEventListener("input", (e) => {
            ongkir.value = formatRupiah(e.target.value);
            setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
        })

        pajak.addEventListener("change", (e) => {
            setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
        })
    </script>