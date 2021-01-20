<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktKasBank;
use backend\models\AktItem;
use backend\models\Login;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktApprover;
use yii\helpers\ArrayHelper;
use backend\models\AktLevelHarga;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelian */

$this->title = 'Detail Data Order Pembelian : ' . $model->no_order_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
$count_query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->count();
?>
<div class="akt-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Order Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        $approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Order Pembelian'])
            ->asArray()
            ->all();
        $id_login =  Yii::$app->user->identity->id_login;
        $cek_login = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Order Pembelian'])
            ->andWhere(['id_login' => $id_login])
            ->asArray()
            ->one();

        $cek_detail = AktPembelianDetail::find()
            ->where(['id_pembelian' => $model->id_pembelian])
            ->count();
        ?>



        <?php if ($model->status == 1 && $cek_login == null) {
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pembelian], [
                'class' => 'btn btn-danger btn-hapus-hidden',
                'data' => [
                    'confirm' => 'Apakah anda yakin akan menghapus Data Order pembelian : ' . $model->no_order_pembelian . ' ?',
                    'method' => 'post',
                ],
            ]) ?>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><span class="glyphicon glyphicon-edit"></span> Ubah Order Pembelian</button>

        <?php } ?>

        <?php if ($cek_detail > 0 && $model->jenis_bayar != null) { ?>
            <?php

            if ($model->status == 1 && $cek_login != null) {
            ?>
                <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Approve', ['approved', 'id' => $model->id_pembelian, 'id_login' => $id_login], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menyetujui Data Order pembelian : ' . $model->no_order_pembelian . ' ?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_pembelian, 'id_login' => $id_login], [
                    'class' => 'btn btn-danger',
                    // $a => true,
                    'data' => [
                        'confirm' => 'Apakah anda yakin untuk menolak data ini ?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php }
            ?>

            <?php if ($model->status == 2 || $model->status == 6) { ?>
                <?php
                foreach ($approve as $key => $value) {
                    if ($id_login == $value['id_login']) {
                ?>
                        <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_pembelian], [
                            'class' => 'btn btn-info btn-pending-hidden',
                            'data' => [
                                'confirm' => 'Apakah anda yakin untuk mempending data ini ?',
                                'method' => 'post',
                            ],
                        ]) ?>
            <?php }
                }
            } ?>
        <?php } ?>


    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'no_order_pembelian',
                                    [
                                        'attribute' => 'tanggal_order_pembelian',
                                        'label' => 'Tanggal Order',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_order_pembelian)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_order_pembelian, true);
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'tanggal_estimasi',
                                        'label' => 'Tanggal Estimasi',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_estimasi)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_estimasi, true);
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'id_customer',
                                        'label' => 'Supplier',
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
                                'attributes' => [
                                    [
                                        'attribute' => 'id_mata_uang',
                                        'label' => 'Mata Uang',
                                        'value' => function ($model) {
                                            if (!empty($model->mata_uang->mata_uang)) {
                                                # code...
                                                return $model->mata_uang->mata_uang;
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
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
                                        'attribute' => 'status',
                                        'format' => 'html',
                                        'value' => function ($model) {
                                            if ($model->status == 1) {
                                                # code...
                                                return "<span class='label label-default'>Order Pembelian</span>";
                                            } elseif ($model->status == 2) {
                                                # code...
                                                $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                return "<span class='label label-warning'>Pembelian, Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver['nama'] . "</span>";
                                            } elseif ($model->status == 3) {
                                                # code...
                                                return "<span class='label label-primary'>Penerimaan</span>";
                                            } elseif ($model->status == 4) {
                                                # code...
                                                return "<span class='label label-success'>Selesai</span>";
                                            } elseif ($model->status == 5) {
                                                # code...
                                                return "<span class='label label-info'>Proses Penerimaan</span>";
                                            } elseif ($model->status == 6) {
                                                # code...
                                                $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                return "<span class='label label-danger'>Ditolak pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver['nama'] . "</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-box"></span> Data Barang</a></li>
                            <li><a data-toggle="tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="row form-user">
                                            <?php
                                            if ($model->status == 1 && $cek_login == null) {
                                                # code...
                                            ?>
                                                <?php $form = ActiveForm::begin([
                                                    'method' => 'post',
                                                    'action' => ['akt-pembelian-detail/create-from-order-pembelian'],
                                                ]); ?>

                                                <?= $form->field($model_pembelian_detail_baru, 'id_pembelian')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                <div class="col-md-6">
                                                    <?= $form->field($model_pembelian_detail_baru, 'id_item_stok')->widget(Select2::classname(), [
                                                        'data' => $data_item_stok,
                                                        'language' => 'en',
                                                        'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok', 'required' => true],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ])->label('Nama Barang')
                                                    ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_pembelian_detail_baru, 'qty')->textInput(['required' => true]) ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_pembelian_detail_baru, 'harga')->widget(\yii\widgets\MaskedInput::className(), [
                                                        'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                                        'options' => ['required' => true]
                                                    ]); ?>
                                                    <!-- ->textInput(['maxlength' => true, 'type' => 'number']) ?> -->
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_pembelian_detail_baru, 'diskon')->textInput(['placeholder' => 'Diskon %', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'id' => 'diskon-floating'])->label('Diskon %') ?>
                                                </div>

                                                <div class="col-md-10">
                                                    <?= $form->field($model_pembelian_detail_baru, 'keterangan')->textInput(['placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success" style="width: 100%;"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                    <!-- <button type="reset" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Reset</button> -->
                                                </div>

                                                <?php ActiveForm::end(); ?>
                                            <?php } ?>
                                        </div>
                                        <div style="overflow: auto;">
                                            <table id="pembelian" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th style="width: 30%;">Nama Barang</th>
                                                        <th style="width: 3%;">Qty</th>
                                                        <th style="width: 10%;">Harga</th>
                                                        <th style="width: 8%;">Diskon %</th>
                                                        <th style="width: 20%;">Keterangan</th>
                                                        <th style="width: 10%;">Sub Total</th>
                                                        <?php
                                                        if ($model->status == 1 && $cek_login == null) {
                                                            # code...
                                                        ?>
                                                            <th>Aksi</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $totalan_total = 0;
                                                    $query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();
                                                    foreach ($query_detail as $key => $data) {
                                                        # code...
                                                        $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                                        $item = AktItem::findOne($item_stok->id_item);
                                                        $gudang = AktGudang::findOne($item_stok->id_gudang);

                                                        $totalan_total += $data['total'];


                                                    ?>
                                                        <tr>
                                                            <td><?= $no++ . '.' ?></td>
                                                            <td>
                                                                <?php
                                                                echo $item->nama_item;
                                                                echo "<br>";
                                                                if ($model->status == 1) {
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= $data['qty'] ?></td>
                                                            <td><?= ribuan($data['harga']) ?></td>
                                                            <td><?= $data['diskon'] ?>%</td>
                                                            <td><?= $data['keterangan'] ?></td>
                                                            <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
                                                            <?php
                                                            if ($model->status == 1 && $cek_login == null) {
                                                                # code...
                                                            ?>
                                                                <td>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-pembelian-detail/update-from-order-pembelian', 'id' => $data['id_pembelian_detail']], ['class' => 'btn btn-primary btn-ubah-detail']) ?>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-pembelian-detail/delete-from-order-pembelian', 'id' => $data['id_pembelian_detail'], 'type' => 'order_pembelian'], [
                                                                        'class' => 'btn btn-danger btn-hapus-detail',
                                                                        'data' => [
                                                                            'confirm' => 'Apakah Anda yakin akan menghapus ' . $item->nama_item . ' dari Data Barang Pembelian?',
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
                                                        <th colspan="6" style="text-align: right;">Total Harga</th>
                                                        <th style="text-align: right;"><?= ribuan($totalan_total) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" style="text-align: right;">Diskon <?= $model->diskon ?> %</th>
                                                        <th style="text-align: right;">
                                                            <?php
                                                            $diskon = ($model->diskon * $totalan_total) / 100;
                                                            echo ribuan($diskon);
                                                            ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" style="text-align: right;">Pajak 10 % (<?= ($model->pajak == NULL) ? '' : $retVal = ($model->pajak == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
                                                        <th style="text-align: right;">
                                                            <?php
                                                            $diskon = ($model->diskon * $totalan_total) / 100;
                                                            $pajak_ = (($totalan_total - $diskon) * 10) / 100;
                                                            $pajak = ($model->pajak == 1) ? $pajak_ : 0;
                                                            echo ribuan($pajak);
                                                            ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" style="text-align: right;">Ongkir</th>
                                                        <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" style="text-align: right;">Materai</th>
                                                        <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <?php
                                                        $grand_total = $model->materai + $model->ongkir + $pajak + $totalan_total - $diskon;
                                                        ?>
                                                        <th colspan="6" style="text-align: right;">Grand Total</th>
                                                        <th style="text-align: right;"><?= ribuan($grand_total) ?></th>
                                                    </tr>

                                                    <tr>
                                                        <?php
                                                        $akt_kas_bank = AktKasBank::findOne($model->id_kas_bank);

                                                        ?>
                                                        <th colspan="6" style="text-align: right;">Uang Muka <?= $akt_kas_bank == false ? '' : ' | ' . $akt_kas_bank['keterangan'] ?> </th>
                                                        <th style="text-align: right;"><?= ribuan($model->uang_muka) ?> </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6" style="text-align: right;">Sisa Dana yang Masih Harus Dibayarkan</th>
                                                        <th style="text-align: right;"><?= ribuan($grand_total - $model->uang_muka) ?></th>
                                                    </tr>


                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="unggah-dokumen" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <?= Html::beginForm(['akt-pembelian/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                        <?= Html::hiddenInput("id_tabel", $model->id_pembelian) ?>
                                        <?= Html::hiddenInput("nama_tabel", "pembelian") ?>
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
                                                    <th colspan="2">DOKUMEN :</th>
                                                </tr>
                                                <?php
                                                $no = 1;
                                                foreach ($foto as $key => $data) {
                                                    # code...
                                                ?>
                                                    <tr>
                                                        <th style="width: 1%;"><?= $no++ . '.' ?></th>
                                                        <th style="width: 80%;">
                                                            <a target="_BLANK" href="/accounting/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                        </th>
                                                        <th style="width: 20%;">
                                                            <a href="index.php?r=akt-pembelian/view&id=<?php echo $model->id_pembelian; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')"><img src='images/hapus.png' width='20'></a>
                                                        </th>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </thead>
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


<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ubah Data Pembelian</h4>
                </div>
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-pembelian/view', 'aksi' => 'ubah_data_pembelian',  'id' => $model->id_pembelian],
                ]); ?>
                <div class="modal-body">
                    <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Order Pembelian</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-grop">
                                <?= $form->field($model, 'no_order_pembelian')->textInput(['readonly' => true, 'required' => 'on', 'autocomplete' => 'off']) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'tanggal_order_pembelian')->widget(
                                    \yii\jui\DatePicker::classname(),
                                    [
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => ['class' => 'form-control', 'required' => 'on', 'autocomplete' => 'off']
                                    ]
                                ) ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model, 'tanggal_estimasi')->widget(
                                    \yii\jui\DatePicker::classname(),
                                    [
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                            'minDate' => $model->tanggal_order_pembelian,
                                        ],
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => ['class' => 'form-control', 'required' => 'on', 'autocomplete' => 'off']
                                    ]
                                ) ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $form->field($model, 'id_customer')->widget(Select2::classname(), [
                                    'data' => $data_customer,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Supplier'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'addon' => [
                                        'prepend' => [
                                            'content' => Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                                                'class' => 'btn btn-success',
                                                'title' => 'Add Supplier',
                                                'data-toggle' => 'modal',
                                                'data-target' => '#modal-supplier'
                                            ]),
                                            'asButton' => true,
                                        ],
                                    ],
                                ])->label('Supplier')
                                ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model, 'id_mata_uang')->widget(Select2::classname(), [
                                    'data' => $data_mata_uang,
                                    'value' => $model->id_mata_uang = 1,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Mata Uang'],
                                    'pluginOptions' => [
                                        'allowClear' => true,

                                    ],
                                ])->label('Mata Uang')
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($count_query_detail > 0) { ?>
                        <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Perhitungan Pembelian</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= $form->field($model, 'ongkir')->textInput(['value' => $model->ongkir == '' ? 0 : $model->ongkir, 'autocomplete' => 'off', 'class' => 'ongkir_pembelian form-control', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+'])->label('Ongkir') ?>
                                </div>

                                <div class="form-group">
                                    <?= $form->field($model, 'diskon')->textInput(['value' => $model->diskon == '' ? 0 : $model->diskon, 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'id' => 'diskon-floating', 'class' => 'diskon-pembelian form-control'])->label('Diskon %') ?>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'uang_muka')->textInput(['value' => $model->uang_muka == '' ? 0 : $model->uang_muka, 'autocomplete' => 'off'])->label('Uang Muka') ?>
                                        </div>
                                        <div class="col-md-12 kas-bank style-kas-bank">
                                            <?= $form->field($model, 'id_kas_bank')->widget(Select2::classname(), [
                                                'data' => $data_kas_bank,
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Pilih Kas Bank'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,

                                                ],
                                            ])->label('Kas Bank')
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
                                            'required' => $count_query_detail > 0 ? 'on' : 'off',
                                        ]
                                    ) ?>
                                </div>

                                <div class="form-group">
                                    <?= $form->field($model, 'jatuh_tempo', ['options' => ['id' => 'jatuh_tempo', 'hidden' => 'yes']])->dropDownList(array(
                                        15 => 15,
                                        30 => 30,
                                        45 => 45,
                                        60 => 60,
                                    ), ['prompt' => 'Pilih Jatuh Tempo']) ?>
                                </div>

                                <div class="form-group">
                                    <?= $form->field($model, 'tanggal_tempo', ['options' => ['id' => 'tanggal_tempo', 'hidden' => 'yes']])->textInput(['readonly' => true]) ?>
                                    <?= $form->field($model, 'id_pembelian')->textInput(['type' => 'hidden', 'readonly' => true, 'required' => 'on', 'autocomplete' => 'off', 'id' => 'id_pembelian'])->label(FALSE) ?>
                                </div>

                                <div class="form-group">
                                    <?= $form->field($model, 'materai')->textInput(['value' => $model->materai == '' ? 0 : $model->materai, 'autocomplete' => 'off', 'class' => 'materai-pembelian form-control', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+'])->label('Materai') ?>
                                </div>

                                <div class="form-group">
                                    <label for="total_pembelian_detail">Total pembelian Barang</label>
                                    <?= Html::input("text", "total_pembelian_detail", ribuan($model_pembelian_detail), ['class' => 'form-control', 'readonly' => true, 'id' => 'total_pembelian_detail']) ?>
                                </div>
                                <div class="form-group">
                                    <label for="total_perhitungan">Kekurangan Pembayaran</label>
                                    <input id="total_perhitungan" readonly class="form-control">
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-supplier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Supplier</h4>
            </div>
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['akt-pembelian/view', 'aksi' => 'supplier', 'id' => $model->id_pembelian, 'tipe' => 'order_pembelian'],
            ]); ?>
            <div class="modal-body">

                <div class="form-group">
                    <label for="">Nama Supplier</label>
                    <input type="text" name="nama_mitra_bisnis" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">Level Harga</label>
                    <?php
                    echo Select2::widget([
                        'name' => 'id_level_harga',
                        'data' => ArrayHelper::map(AktLevelHarga::find()->all(), 'id_level_harga', 'keterangan'),
                        'options' => [
                            'placeholder' => 'Pilih Level Harga ...',
                            // 'multiple' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="form-group">
                    <label for="">Deskripsi Supplier</label>
                    <textarea class="form-control" name="deskripsi_mitra_bisnis" id="" cols="10" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php
$script = <<< JS


    $(document).ready(function(){ 

    if ($("#aktpembelian-jenis_bayar").val() == "1")
    {
        $("#aktpembelian-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpembelian-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpembelian-jenis_bayar").val() == "2")
    {
        $("#aktpembelian-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpembelian-tanggal_tempo").show();
        $('#tanggal_tempo').hide(); 
    }

    $("#aktpembelian-jenis_bayar").change(function(){

    if ($("#aktpembelian-jenis_bayar").val() == "1")
    {
        $("#aktpembelian-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpembelian-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpembelian-jenis_bayar").val() == "2")
    {
        $("#aktpembelian-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpembelian-tanggal_tempo").show();
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

    const kasBank = document.querySelector('.kas-bank');
    const uangMuka = document.querySelector('#aktpembelian-uang_muka');

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



    const total_pembelian_detail = document.querySelector('#total_pembelian_detail');

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

        hitung = parseInt(total) + parseInt(ongkir) + pajak + parseInt(materai) - parseInt(diskonRupiah) - parseInt(hilang_titik);
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
        setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
    })

    ongkir.addEventListener("input", (e) => {
        ongkir.value = formatRupiah(e.target.value);
        setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
    })

    pajak.addEventListener("change", (e) => {
        setValueDataPerhitungan(ongkir.value.split('.').join(""), diskon.value, uangMuka.value, pajak.checked, materai.value.split('.').join(""));
    })
</script>