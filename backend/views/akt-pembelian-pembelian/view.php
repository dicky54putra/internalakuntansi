<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktLevelHarga;
use backend\models\AktGudang;
use backend\models\AktPembelian;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\Login;
use backend\models\AktApprover;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Aktpembelian */

$this->title = 'Detail Data Pembelian : ' . $model->no_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$id_login =  Yii::$app->user->identity->id_login;
$cek_login = AktApprover::find()
    ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
    ->where(['=', 'nama_jenis_approver', 'Pembelian'])
    ->andWhere(['id_login' => $id_login])
    ->asArray()
    ->one();
$count_query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->count();
?>
<div class="akt-pembelian-pembelian-view">
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
    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <php>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        if ($model->status == 2) {
            # code...
        ?>
            <?php if ($is_pembelian->status == 1 && $model->jenis_bayar == null) { ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pembelian], [
                    'class' => 'btn btn-danger btn-hapus-hidden',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php } ?>
            <?php if ($count_query_detail != 0 && $is_pembelian->status == 1) { ?>
                <?php if ($model->jenis_bayar == null) {
                ?>
                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah Data Pembelian', ['#', 'id' => $model->id_pembelian], [
                        'class' => 'btn btn-primary btn-ubah-hidden',
                        'data-toggle' => 'modal',
                        'data-target' => '#modal-default'
                    ]) ?>

                <?php  } else if ($model->jenis_bayar != null) {
                ?>
                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus Data Pembelian', ['hapus-data-pembelian', 'id' => $model->id_pembelian], [
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
            $query_detail = AktPembelianDetail::find()->where(['id_pembelian' => $model->id_pembelian])->all();

            foreach ($query_detail as $key => $data) {
                # code...
                $item_stok = AktItemStok::findOne($data['id_item_stok']);
                $a = ($data['qty'] > $item_stok->qty) ? 1 : 0;
                $show_hide += $a;
            }
            ?>
            <?php
            if ($count_query_detail != 0 && $model->jenis_bayar != null) {

            ?>
                <?= Html::a('<span class="fa fa-truck"></span> Penerimaan', ['penerimaan', 'id' => $model->id_pembelian], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menyetujui penerimaan Data Pembelian : ' . $model->no_pembelian . ' ?',
                        'method' => 'post',
                    ],
                ]) ?>
        <?php
            }
        }
        ?>
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
                                        // 'id_pembelian',
                                        'no_pembelian',
                                        [
                                            'attribute' => 'tanggal_pembelian',
                                            'value' => function ($model) {
                                                if (!empty($model->tanggal_pembelian)) {
                                                    # code...
                                                    return tanggal_indo($model->tanggal_pembelian, true);
                                                } else {
                                                    # code...
                                                }
                                            }
                                        ],
                                        [
                                            'atribute' => 'no_faktur_pembelian',
                                            'label' => 'No Faktur Pajak',
                                            'value' =>  function ($model) {
                                                if (!empty($model->no_faktur_pembelian)) {
                                                    # code...
                                                    return $model->no_faktur_pembelian;
                                                }
                                            }
                                        ],
                                        [
                                            'attribute' => 'tanggal_faktur_pembelian',
                                            'label' => 'Tanggal Faktur Pajak',
                                            'value' => function ($model) {
                                                if (!empty($model->tanggal_faktur_pembelian)) {
                                                    # code...
                                                    return tanggal_indo($model->tanggal_faktur_pembelian, true);
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
                                        // 'id_pembelian',
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
                                            'attribute' => 'jatuh_tempo',
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
                                            'attribute' => 'status',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                if ($model->status == 1) {
                                                    # code...
                                                    return "<span class='label label-default'>Order Pembelian</span>";
                                                } elseif ($model->status == 2) {
                                                    # code...
                                                    if (AktPembelian::cekButtonPembelian()->status == 0 && $model->no_order_pembelian != null) {
                                                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                        return "<span class='label label-warning'>Pembelian PO, Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                                    } else if (AktPembelian::cekButtonPembelian()->status == 1 || $model->no_order_pembelian == null) {
                                                        return "<span class='label label-warning'>Pembelian </span>";
                                                    }
                                                } elseif ($model->status == 3) {
                                                    # code...
                                                    return "<span class='label label-primary'>Penerimaan</span>";
                                                } elseif ($model->status == 4) {
                                                    # code...
                                                    return "<span class='label label-success'>Selesai</span>";
                                                } elseif ($model->status == 5) {
                                                    # code...
                                                    return "<span class='label label-info'>Proses Penerimaan</span>";
                                                }
                                            }
                                        ],
                                    ],
                                ]) ?>
                            </div>
                        </div>

                        <div class="" style="margin-top:20px;">
                            <ul class="nav nav-tabs" id="tabForRefreshPage">
                                <li class="active"><a data-toggle="tab" class="link-tab" href="#data-barang"><span class="fa fa-box"></span> Data Barang Pembelian</a></li>
                                <li><a data-toggle="tab" class="link-tab" href="#isi-data-pembelian"> <span class="glyphicon glyphicon-shopping-cart"></span> Data Order Pembelian</a></li>
                                <li><a data-toggle="tab" class="link-tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                                <li><a data-toggle="tab" class="link-tab" href="#faktur"><span class="glyphicon glyphicon-list-alt"></span> Faktur Pajak</a></li>
                            </ul>
                            <div class="tab-content">

                                <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-md-12" style="margin-bottom:20px;">
                                            <div class="row form-user">
                                                <?php
                                                if ($model->status <= 2 && $cek_login == null && $is_pembelian->status == 1 && $model->jenis_bayar == null) {
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
                                                    </div>

                                                    <div class="col-md-2">
                                                        <?= $form->field($model_pembelian_detail_baru, 'diskon')->textInput(['placeholder' => 'Diskon %'])->label('Diskon %') ?>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <?= $form->field($model_pembelian_detail_baru, 'keterangan')->textInput(['placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Tambahkan', ['class' => 'btn btn-success', 'name' => 'create-from-pembelian', 'style' => 'width:100%;']) ?>
                                                    </div>
                                                    <?php ActiveForm::end(); ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="overflow: auto;">
                                            <table id="barang" class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th style="width: 30%;">Nama Barang</th>
                                                        <th style="width: 10%;">Gudang</th>
                                                        <th style="width: 5%;">Qty</th>
                                                        <th style="width: 8%;">Harga</th>
                                                        <th style="width: 7%;">Diskon %</th>
                                                        <th style="width: 20%;">Keterangan</th>
                                                        <th style="width: 10%;">Sub Total</th>
                                                        <?php
                                                        if ($model->status == 1 && $cek_login == null && $is_pembelian->status == 1 && $model->jenis_bayar == null) {
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
                                                                ?>
                                                            </td>
                                                            <td><?= (!empty($gudang->nama_gudang)) ? $gudang->nama_gudang : '' ?></td>
                                                            <td><?= $data['qty'] ?></td>
                                                            <td><?= ribuan($data['harga']) ?></td>
                                                            <td><?= $data['diskon'] ?></td>
                                                            <td><?= $data['keterangan'] ?></td>
                                                            <td style="text-align: right;"><?= ribuan($data['total']) ?></td>
                                                            <?php
                                                            if ($model->status <= 2 && $cek_login == null && $is_pembelian->status == 1 && $model->jenis_bayar == null) {
                                                                # code...
                                                            ?>
                                                                <td>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-pembelian-detail/update-from-pembelian', 'id' => $data['id_pembelian_detail']], ['class' => 'btn btn-primary btn-ubah-detail']) ?>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-pembelian-detail/delete-from-order-pembelian', 'id' => $data['id_pembelian_detail'], 'type' => 'pembelian_langsung'], [
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
                                                        <th colspan="7" style="text-align: right;">Total</th>
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
                                                        <th colspan="7" style="text-align: right;">Pajak 10 % (<?= ($model->pajak == NULL) ? '' : $retVal = ($model->pajak == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
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
                                                        <th colspan="7" style="text-align: right;">Ongkir</th>
                                                        <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="7" style="text-align: right;">Materai</th>
                                                        <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="7" style="text-align: right;">Uang Muka</th>
                                                        <th style="text-align: right;"><?= ribuan($model->uang_muka) ?></th>
                                                    </tr>
                                                    <?php
                                                    $grand_total = $model->materai + $model->ongkir + $pajak + $totalan_total - $diskon - $model->uang_muka;
                                                    ?>
                                                    <tr>
                                                        <th colspan="7" style="text-align: right;">Grand Total</th>
                                                        <th style="text-align: right;"><?= ribuan($grand_total) ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div id="isi-data-pembelian" class="tab-pane fade" style="margin-top:20px;">
                                    <div class="row" style="margin-top:30px;">
                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?= DetailView::widget([
                                                        'model' => $model,
                                                        'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                                        'attributes' => [
                                                            // 'id_pembelian',
                                                            'no_order_pembelian',
                                                            [
                                                                'attribute' => 'tanggal_order_pembelian',
                                                                'value' => function ($model) {
                                                                    if ($model->tanggal_order_pembelian != null) {
                                                                        return tanggal_indo($model->tanggal_order_pembelian, true);
                                                                    }
                                                                }
                                                            ],
                                                            [
                                                                'attribute' => 'id_customer',

                                                                'label' => 'Nama Customer',
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
                                                            [
                                                                'attribute' => 'id_mata_uang',

                                                                'label' => 'Jenis Mata Uang',
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
                                                                'attribute' => 'status',
                                                                'format' => 'raw',
                                                                'value' => function ($model) {
                                                                    if ($model->status == 1) {
                                                                        # code...
                                                                        return "<span class='label label-default'>Order Pembelian</span>";
                                                                    } elseif ($model->status == 2) {
                                                                        # code...
                                                                        return "<span class='label label-warning'>Pembelian</span>";
                                                                    } elseif ($model->status == 3) {
                                                                        # code...
                                                                        return "<span class='label label-primary'>penerimaan</span>";
                                                                    } elseif ($model->status == 4) {
                                                                        # code...
                                                                        return "<span class='label label-success'>Completed</span>";
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
                                            <?= Html::beginForm(['akt-pembelian-pembelian/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
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
                                                        <th>DOKUMEN :</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <?php foreach ($foto as $data) { ?>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th width="80%">
                                                                <figure class="figure">
                                                                    <img src="/accounting/backend/web/upload/<?php echo $data->foto; ?>" alt="image" class="img-thumbnail figure-img img-fluid" width="200px">
                                                                    <figcaption class="figure-caption" style="margin-top: 2rem;">
                                                                        <a target="_BLANK" href="/accounting/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                                    </figcaption>
                                                                </figure>
                                                            </th>
                                                            <th width="20%">
                                                                <div class="" style="display: flex; align-items:center; margin-bottom:50px;">
                                                                    <a href="index.php?r=akt-pembelian-pembelian/view&id=<?php echo $model->id_pembelian; ?>&id_hapus=<?php echo $data->id_foto; ?>"><img src='images/hapus.png' width="40px"></a>
                                                                </div>
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

                                            <?= Html::beginForm(['akt-pembelian-pembelian/view', 'aksi' => 'faktur', 'id' => $model->id_pembelian], 'post') ?>

                                            <div class="form-group">
                                                <label for="no_faktur_pembelian">No. Faktur</label>
                                                <input type="text" id="no_faktur_pembelian" name="no_faktur_pembelian" placeholder="No. Faktur" value="<?= $model->no_faktur_pembelian ?>" class="form-control" autocomplete="off" required <?= ($model->status == 3) ? 'readonly' : '' ?>>
                                            </div>

                                            <div class="form-group">
                                                <label for="tanggal_faktur_pembelian">Tanggal Faktur</label>
                                                <input type="date" id="tanggal_faktur_pembelian" name="tanggal_faktur_pembelian" value="<?= $model->tanggal_faktur_pembelian ?>" class="form-control" required <?= ($model->status == 3) ? 'readonly' : '' ?>>
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
                            'action' => ['update-data-pembelian', 'id' => $model->id_pembelian],
                        ]); ?>
                        <div class="modal-body">
                            <label class="label label-primary col-xs-12" style="font-size: 15px;">Data Order Pembelian</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-grop">
                                        <?= $form->field($model, 'no_pembelian')->textInput(['readonly' => true, 'required' => 'on', 'autocomplete' => 'off']) ?>
                                    </div>
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
                                </div>
                                <div class="col-md-6">

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
                            <label class="label label-primary col-xs-12" style="font-size: 15px;">Data Perhitungan Pembelian</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'ongkir')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0], 'options' => ['value' => $model->ongkir == '' ? 0 : $model->ongkir]]); ?>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($model, 'diskon')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0], 'options' => ['value' => $model->diskon == '' ? 0 : $model->diskon]])->label('Diskon %'); ?>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($model, 'uang_muka')->textInput(['value' => $model->uang_muka == '' ? 0 : $model->uang_muka, 'autocomplete' => 'off'])->label('Uang Muka') ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
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
                                        <?= $form->field($model, 'pajak')->checkbox() ?>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $form->field($model, 'jenis_bayar')->dropDownList(
                                            array(1 => "CASH", 2 => "CREDIT"),
                                            [
                                                'prompt' => 'Pilih Jenis Pembayaran',
                                                'required' => 'on',
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
                                        <?= $form->field($model, 'tanggal_tempo', ['options' => ['id' => 'tanggal_tempo', 'hidden' => 'yes']])->textInput(['readonly' => true]) ?>
                                        <?= $form->field($model, 'id_pembelian')->textInput(['type' => 'hidden', 'readonly' => true, 'required' => 'on', 'autocomplete' => 'off', 'id' => 'id_pembelian'])->label(FALSE) ?>
                                    </div>

                                    <div class="form-group">
                                        <?= $form->field($model, 'materai')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0], 'options' => ['value' => $model->materai == '' ? 0 : $model->materai]]); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_pembelian_detail">Total pembelian Barang</label>
                                        <?= Html::input("text", "total_pembelian_detail", ribuan($model_pembelian_detail), ['class' => 'form-control', 'readonly' => true, 'id' => 'total_pembelian_detail']) ?>
                                    </div>

                                </div>
                            </div>

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
                        'action' => ['akt-pembelian/view', 'aksi' => 'supplier', 'id' => $model->id_pembelian, 'tipe' => 'pembelian_langsung'],
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
            const kasBank = document.querySelector('.kas-bank');
            const uangMuka = document.querySelector('#aktpembelian-uang_muka');

            if (uangMuka.value != 0) {
                kasBank.classList.remove('style-kas-bank')
            }

            uangMuka.addEventListener("input", function(e) {
                uangMuka.value = formatRupiah(this.value);
                let val = e.target.value;
                if (val == '' || val == 0) {
                    kasBank.classList.add('style-kas-bank')
                } else(
                    kasBank.classList.remove('style-kas-bank')
                )
            });

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
        </script>