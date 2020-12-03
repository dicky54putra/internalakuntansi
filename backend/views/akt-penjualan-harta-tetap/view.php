<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktKasBank;
use backend\models\AktGudang;
use backend\models\AktPenjualanHartaTetapDetail;
use backend\models\AktPembelianHartaTetapDetail;
use backend\models\AktApprover;
use backend\models\Login;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetap */

$this->title = 'Detail Penjualan Harta Tetap : ' . $model->no_penjualan_harta_tetap;

$cek_detail = AktPenjualanHartaTetapDetail::find()
    ->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap])
    ->count();
?>
<div class="akt-penjualan-harta-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penjualan Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        $id_login =  Yii::$app->user->identity->id_login;
        $approver = AktApprover::find()->leftJoin("akt_jenis_approver", "akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver")->where(['=', 'nama_jenis_approver', 'Penjualan Harta Tetap'])->all();

        # untuk menentukan yang login apakah approver, jika approver maka form tidak muncul
        $string_approver = array();
        foreach ($approver as $key => $value) {
            # code...
            $string_approver[] = $value['id_login'];
        }
        $hasil_string_approver = implode(", ", $string_approver);
        $hasil_array_approver = explode(", ", $hasil_string_approver);
        $angka_array_approver = 0;
        if (in_array(Yii::$app->user->identity->id_login, $hasil_array_approver)) {
            # code...
            $angka_array_approver = 1;
        }
        ?>
        <?php
        if ($model->status == 1) {
            # code...
        ?>
            <?php
            if ($angka_array_approver == 0) {
                # code...
            ?>
                <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah Data Penjualan', ['update', 'id' => $model->id_penjualan_harta_tetap], [
                    'class' => 'btn btn-primary',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal-ubah'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penjualan_harta_tetap], [
                    'class' => 'btn btn-danger btn-hapus-hidden',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menghapus Data Penjualan Harta Tetap : ' . $model->no_penjualan_harta_tetap . ' ?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php } ?>
            <?php
            foreach ($approver as $key => $value) {
                # code...
                if ($id_login == $value->id_login) {
                    # code...
                    if ($total_cek == 0) {
                        # code...
            ?>
                        <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Approved', ['approved', 'id' => $model->id_penjualan_harta_tetap, 'id_login' => $id_login], [
                            'class' => 'btn btn-success btn-approver-hidden',
                            'data' => [
                                'confirm' => 'Apakah anda yakin akan menyetujui Data Penjualan Harta Tetap : ' . $model->no_penjualan_harta_tetap . ' ?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Rejected', ['rejected', 'id' => $model->id_penjualan_harta_tetap, 'id_login' => $id_login], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Apakah anda yakin akan menolak Data Penjualan Harta Tetap : ' . $model->no_penjualan_harta_tetap . ' ?',
                                'method' => 'post',
                            ],
                        ]) ?>
            <?php
                    }
                }
            }
            ?>
        <?php } ?>
        <?php
        if ($model->status == 2 || $model->status == 3) {
            # code...
            foreach ($approver as $key => $value) {
                # code...
                if ($id_login == $value->id_login) {
                    # code...
        ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_penjualan_harta_tetap, 'id_login' => $id_login], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Apakah anda yakin akan mempending Data Penjualan Harta Tetap : ' . $model->no_penjualan_harta_tetap . ' ?',
                            'method' => 'post',
                        ],
                    ]) ?>
        <?php
                }
            }
        }
        ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0px;">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_penjualan_harta_tetap',
                                    'no_penjualan_harta_tetap',
                                    [
                                        'attribute' => 'tanggal_penjualan_harta_tetap',
                                        'value' => function ($model) {
                                            return tanggal_indo($model->tanggal_penjualan_harta_tetap, true);
                                        }
                                    ],
                                    [
                                        'attribute' => 'id_customer',
                                        'value' => function ($model) {
                                            if (!empty($model->customer->nama_mitra_bisnis)) {
                                                # code...
                                                return $model->customer->nama_mitra_bisnis;
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'id_sales',
                                        'value' => function ($model) {
                                            if (!empty($model->sales->nama_sales)) {
                                                # code...
                                                return $model->sales->nama_sales;
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
                                    // 'id_penjualan_harta_tetap',
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
                                    [
                                        'attribute' => 'id_mata_uang',
                                        'value' => function ($model) {
                                            if (!empty($model->mata_uang->mata_uang)) {
                                                # code...
                                                return $model->mata_uang->mata_uang;
                                            }
                                        }
                                    ],
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
                                                return "<span class='label label-default' style='font-size: 12px;'>Belum Disetujui</span>";
                                            } elseif ($model->status == 2) {
                                                # code...
                                                return "<span class='label label-success' style='font-size: 12px;'>Disetujui pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                            } elseif ($model->status == 3) {
                                                # code...
                                                return "<span class='label label-danger' style='font-size: 12px;'>Ditolak pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang-penjualan"><span class="fa fa-box"></span> Data Barang Penjualan</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang-penjualan" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12" style="overflow: scroll;">

                                        <div class="row form-user">
                                            <?php
                                            if ($model->status == 1 && $angka_array_approver == 0) {
                                                # code...
                                            ?>
                                                <?php $form = ActiveForm::begin([
                                                    'method' => 'post',
                                                    'action' => ['akt-penjualan-harta-tetap-detail/create'],
                                                ]); ?>

                                                <?= $form->field($model_penjualan_harta_tetap_detail_baru, 'id_penjualan_harta_tetap')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                <div class="col-md-6">
                                                    <?= $form->field($model_penjualan_harta_tetap_detail_baru, 'id_pembelian_harta_tetap_detail')->widget(Select2::classname(), [
                                                        'data' => $data_pembelian_harta_tetap_detail,
                                                        'language' => 'en',
                                                        'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_pembelian_harta_tetap_detail'],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ])
                                                    ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_penjualan_harta_tetap_detail_baru, 'harga')->textInput(['maxlength' => true, 'readonly' => false, 'autocomplete' => 'off', 'id' => 'harga']) ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?= $form->field($model_penjualan_harta_tetap_detail_baru, 'qty')->textInput(['autocomplete' => 'off', 'type' => 'number', 'readonly' => true]) ?>
                                                </div>
                                                <div class="col-md-2">
                                                    <?= $form->field($model_penjualan_harta_tetap_detail_baru, 'diskon')->textInput(['placeholder' => 'Diskon %', 'autocomplete' => 'off']) ?>
                                                </div>

                                                <div class="col-md-10">
                                                    <?= $form->field($model_penjualan_harta_tetap_detail_baru, 'keterangan')->textarea(['rows' => 1, 'placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success col-md-12"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                </div>

                                                <?php ActiveForm::end(); ?>
                                            <?php } ?>
                                        </div>

                                        <table class="table table-hover table-condensed table-responsive">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">No.</th>
                                                    <th style="width: 10%;">Kode</th>
                                                    <th style="width: 30%;">Nama Barang</th>
                                                    <th style="width: 5%;">Qty</th>
                                                    <th style="width: 10%;">Harga</th>
                                                    <th style="width: 10%;">Diskon %</th>
                                                    <th style="width: 20%;">Keterangan</th>
                                                    <th style="width: 10%;">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $totalan_total = 0;
                                                $query_penjualan_harta_tetap_detail = AktPenjualanHartaTetapDetail::find()->where(['id_penjualan_harta_tetap' => $model->id_penjualan_harta_tetap])->all();
                                                foreach ($query_penjualan_harta_tetap_detail as $key => $data) {
                                                    # code...
                                                    $pembelian_harta_tetap_detail = AktPembelianHartaTetapDetail::findOne($data['id_pembelian_harta_tetap_detail']);

                                                    $totalan_total += $data['total'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= $pembelian_harta_tetap_detail->kode_pembelian ?></td>
                                                        <td><?= $pembelian_harta_tetap_detail->nama_barang ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td><?= ribuan($data['harga']) ?></td>
                                                        <td><?= $data['diskon'] ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
                                                        <?php
                                                        if ($model->status == 1 && $angka_array_approver == 0) {
                                                            # code...
                                                        ?>
                                                            <td style="white-space: nowrap;">
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-penjualan-harta-tetap-detail/delete', 'id' => $data['id_penjualan_harta_tetap_detail']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Apakah Anda yakin akan menghapus ' . $pembelian_harta_tetap_detail->nama_barang . ' dari Data Barang Penjualan?',
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
                                                    <th colspan="7" style="text-align: right;">Total Harga</th>
                                                    <th style="text-align: right;"><?= ribuan($totalan_total) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Diskon <?= $model->diskon ?> %</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $diskon = ($model->diskon * $totalan_total) / 100;
                                                        echo ribuan($diskon);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Pajak 10 %</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $pajak_ = (($totalan_total - $diskon) * 10) / 100;
                                                        $pajak = ($model->pajak == 1) ? $pajak_ : 0;
                                                        echo ribuan($pajak);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Ongkir</th>
                                                    <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Materai</th>
                                                    <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    $grand_total =  $pajak + $totalan_total - $diskon  + $model->ongkir;
                                                    ?>
                                                    <th colspan="7" style="text-align: right;">Grand Total</th>
                                                    <th style="text-align: right;"><?= ribuan($grand_total) ?></th>
                                                </tr>

                                                <tr>
                                                    <?php
                                                    $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);

                                                    ?>
                                                    <th colspan="7" style="text-align: right;">Uang Muka <?= $akt_kas_bank == false ? '' : ' | ' . $akt_kas_bank['keterangan'] ?> </th>
                                                    <th style="text-align: right;"><?= ribuan($model->uang_muka) ?> </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Sisa Dana yang Masih Harus Diterima</th>
                                                    <th style="text-align: right;"><?= ribuan($grand_total - $model->uang_muka) ?></th>
                                                </tr>

                                            </tfoot>
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

<!-- update modal -->
<div class="modal fade bd-example-modal-lg" id="modal-ubah" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Data Penjualan Harta Tetap</h4>
            </div>
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['update', 'id' => $_GET['id']],
            ]); ?>
            <div class="modal-body">

                <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Penjualan Harta Tetap</label>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'no_penjualan_harta_tetap')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                        <?= $form->field($model, 'tanggal_penjualan_harta_tetap')->widget(\yii\jui\DatePicker::classname(), [
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


                <?php if ($cek_detail > 0) { ?>
                    <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Perhitungan Penjualan Harta Tetap</label>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $form->field($model, 'diskon')->textInput(['value' => $model->diskon == '' ? 0 : $model->diskon, 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'id' => 'diskon-floating', 'class' => 'diskon-pembelian form-control'])->label('Diskon %') ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'ongkir')->textInput(['value' => $model->ongkir == '' ? 0 : $model->ongkir, 'autocomplete' => 'off', 'class' => 'ongkir_pembelian form-control', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+'])->label('Ongkir') ?>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'uang_muka')->textInput(['value' => $model->uang_muka == '' ? 0 : $model->uang_muka, 'autocomplete' => 'off']); ?>

                                    </div>
                                    <div id="kas-bank" class="col-md-12 style-kas-bank">
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
                            </div>



                            <div class="form-group">
                                <table>
                                    <tr>
                                        <td style="height: 8px;"></td>
                                    </tr>
                                </table>
                                <?= $form->field($model, 'pajak')->checkbox(['class' => 'pajak_pembelian']) ?>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $form->field($model, 'jenis_bayar')->dropDownList(
                                    array(1 => "CASH", 2 => "CREDIT"),
                                    [
                                        'prompt' => 'Pilih Jenis Pembayaran',
                                        'required' => $cek_detail > 0 ? 'on' : 'off',
                                    ]
                                ) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'jumlah_tempo', ['options' => ['id' => 'jatuh_tempo', 'hidden' => 'yes']])->dropDownList(array(
                                    15 => 15,
                                    30 => 30,
                                    45 => 45,
                                    60 => 60,
                                ), ['prompt' => 'Pilih Jatuh Tempo']) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'tanggal_tempo', ['options' => ['id' => 'tanggal_tempo', 'hidden' => 'yes']])->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'id_penjualan_harta_tetap')->textInput(['type' => 'hidden', 'readonly' => true, 'required' => 'on', 'autocomplete' => 'off', 'id' => 'id_penjualan_harta_tetap'])->label(FALSE) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'materai')->textInput(['value' => $model->materai == '' ? 0 : $model->materai, 'autocomplete' => 'off', 'class' => 'materai-pembelian form-control', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+'])->label('Materai') ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'total')->textInput(['type' => 'text', 'value' => ribuan($total_penjualan_harta_tetap_detail), 'readonly' => true, 'id' => 'total_penjualan_detail'])->label('Total Penjualan Harta Tetap') ?>
                            </div>

                            <div class="form-group" style="margin-top:20px;">
                                <label for="total_perhitungan">Kekurangan Pembayaran</label>
                                <input id="total_perhitungan" readonly class="form-control">
                            </div>
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
                'action' => ['add-new-customer', 'id' => $_GET['id']],
            ]); ?>
            <div class="modal-body">

                <?= $form->field($new_customer, 'nama_mitra_bisnis')->textInput(['maxlength' => true]) ?>

                <?= $form->field($new_customer, 'tipe_mitra_bisnis')->dropDownList(array(1 => "Customer", 2 => "Supplier", 3 => "Customer & Supplier")) ?>

                <?= $form->field($new_customer, 'deskripsi_mitra_bisnis')->textarea(['rows' => 3]) ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

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
                'action' => ['add-new-sales', 'id' => $_GET['id']],
            ]); ?>
            <div class="modal-body">

                <?= $form->field($new_sales, 'nama_sales')->textInput(['maxlength' => true]) ?>

                <?= $form->field($new_sales, 'telepon')->textInput(['maxlength' => true]) ?>

                <?= $form->field($new_sales, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($new_sales, 'alamat')->textarea(['rows' => 3]) ?>

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
        

    if ($("#aktpenjualanhartatetap-jenis_bayar").val() == "1")
    {
        $("#aktpenjualanhartatetap-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpenjualanhartatetap-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualanhartatetap-jenis_bayar").val() == "2")
    {
        $("#aktpenjualanhartatetap-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpenjualanhartatetap-tanggal_tempo").show();
        $('#tanggal_tempo').hide(); 
    }

    $("#aktpenjualanhartatetap-jenis_bayar").change(function(){

    if ($("#aktpenjualanhartatetap-jenis_bayar").val() == "1")
    {
        $("#aktpenjualanhartatetap-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpenjualanhartatetap-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualanhartatetap-jenis_bayar").val() == "2")
    {
        $("#aktpenjualanhartatetap-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpenjualanhartatetap-tanggal_tempo").show();
        $('#tanggal_tempo').hide(); 
    }
    
    });
    });
    
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
    const uangMuka = document.querySelector('#aktpenjualanhartatetap-uang_muka');
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

        hitung = parseInt(total) + parseInt(ongkir) + pajak  - parseInt(diskonRupiah) - parseInt(hilang_titik);
        let hitung2 = Math.floor(hitung);
        perhitungan.value = formatRupiah(String(hitung2));
    }

    const materai = document.querySelector('.materai-pembelian');
    const diskon = document.querySelector('.diskon-pembelian');
    const ongkir = document.querySelector('.ongkir_pembelian');
    const pajak = document.querySelector('.pajak_pembelian');

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