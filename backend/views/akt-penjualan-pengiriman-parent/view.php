<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktKota;
use backend\models\AktPenjualanPengiriman;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\AktMitraBisnisAlamat;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */

$this->title = 'Detail Data Pengiriman Penjualan : ' . $model->no_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penjualan-penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pengiriman Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        if ($model->status < 4) {
            # code...
        ?>
            <?= Html::button(
                '<span class="glyphicon glyphicon-plus"></span> Tambah Data Pengiriman',
                [
                    'value' => Url::to(['akt-penjualan-pengiriman/create', 'id' => $model->id_penjualan]),
                    'title' => 'Tambah Data Pengiriman', 'class' => 'showModalButton btn btn-success'
                ]
            ); ?>
            <?php
            $angka_penentu = 0;
            $query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
            foreach ($query_detail as $key => $data) {
                # code...
                $item_stok = AktItemStok::findOne($data['id_item_stok']);
                $item = AktItem::findOne($item_stok->id_item);
                $gudang = AktGudang::findOne($item_stok->id_gudang);
                $sum_qty_dikirim = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_detail' => $data->id_penjualan_detail])->sum("qty_dikirim");
                $qty_dikirim = ($sum_qty_dikirim == NULL) ? 0 : $sum_qty_dikirim;

                $retVal_terkirim = ($data['qty'] == $qty_dikirim) ? 0 : 1;

                $angka_penentu += $retVal_terkirim;
            }

            $count_belum_terkirim = AktPenjualanPengiriman::find()->where(['id_penjualan' => $model->id_penjualan])->andWhere(['status' => 0])->count();
            ?>
            <?php
            if ($count_belum_terkirim == 0 && $angka_penentu == 0) {
                # code...
            ?>
                <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Selesai', ['terkirim', 'id' => $model->id_penjualan], [
                    'class' => 'btn btn-primary',
                    'data' => [
                        'confirm' => 'Apakah anda yakin sudah terkirim semua?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php } ?>
        <?php } ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-truck"></span> <?= $this->title ?></div>
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
                                                # code...
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
                                                return "<span class='label label-warning'>Penjualan disetujui pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
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
                                    [
                                        'attribute' => 'id_customer',
                                        'value' => function ($model) {
                                            return $model->customer->nama_mitra_bisnis;
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs" id="tabForRefreshPage">
                            <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-box"></span> Data Barang Penjualan</a></li>
                            <li><a data-toggle="tab" href="#data-pengiriman"><span class="fa fa-clipboard-list"></span> Data Pengiriman</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th style="width: 5%;white-space: nowrap;">Kode Item</th>
                                                    <th>Nama Barang</th>
                                                    <th>Keterangan</th>
                                                    <th style="width: 5%;white-space: nowrap;">Qty</th>
                                                    <th style="width: 5%;white-space: nowrap;">Qty Dikirim</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_detail = AktPenjualanDetail::find()->where(['id_penjualan' => $model->id_penjualan])->all();
                                                foreach ($query_detail as $key => $data) {
                                                    # code...
                                                    $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                                    $item = AktItem::findOne($item_stok->id_item);
                                                    $gudang = AktGudang::findOne($item_stok->id_gudang);
                                                    $sum_qty_dikirim = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_detail' => $data->id_penjualan_detail])->sum("qty_dikirim");
                                                    $qty_dikirim = ($sum_qty_dikirim == NULL) ? 0 : $sum_qty_dikirim;
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= (!empty($item->kode_item)) ? $item->kode_item : '' ?></td>
                                                        <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td><?= $qty_dikirim ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="data-pengiriman" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="box-group" id="accordion">
                                            <?php
                                            $penjualan_pengiriman = AktPenjualanPengiriman::find()->where(['id_penjualan' => $model->id_penjualan])->all();
                                            $no = 1;
                                            foreach ($penjualan_pengiriman as $key => $data) {
                                                # code...
                                            ?>
                                                <div class="panel">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <a style="font-size: 15px;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no; ?>" aria-expanded="true" aria-controls="collapseOne" class="drop">
                                                            #<?= ($data->status == 1) ? $no . ' : ' . $data->no_pengiriman . ' | ' . tanggal_indo($data->tanggal_pengiriman, false) . ' | ' . 'Sudah Diterima' : $no . ' : ' . $data->no_pengiriman . ' | ' . tanggal_indo($data->tanggal_pengiriman, false) . ' | ' . 'Belum Diterima' ?>
                                                        </a>
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $no; ?>" aria-expanded="true" aria-controls="collapseOne" style="float: right; margin-left: 5px;" class="btn btn-primary">
                                                            <span id="glyphicon" style="transition: 0.5s;" class="glyphicon glyphicon-chevron-down"></span>
                                                        </a>
                                                        <?= Html::button(
                                                            '<span class="glyphicon glyphicon-edit"></span>',
                                                            [
                                                                'value' => Url::to(['akt-penjualan-pengiriman/update', 'id' => $data->id_penjualan_pengiriman]),
                                                                'title' => 'Ubah Data Pengiriman',
                                                                'class' => 'showModalButton btn btn-success',
                                                                'style' => [
                                                                    'float' => 'right',
                                                                    'margin-right' => '5px',
                                                                ],
                                                            ]
                                                        ) ?>
                                                        <?php
                                                        if ($model->status < 4) {
                                                            # code...
                                                            if ($data->status == 0) {
                                                                # code...
                                                        ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-penjualan-pengiriman/delete', 'id' => $data->id_penjualan_pengiriman], [
                                                                    'class' => 'btn btn-danger',
                                                                    'style' => [
                                                                        'float' => 'right',
                                                                        'margin-right' => '5px',
                                                                    ],
                                                                    'data' => [
                                                                        'confirm' => 'Apakah anda yakin akan menghapus pengiriman ' . $data->no_pengiriman . '?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                                <?php
                                                                $cek_detail = AktPenjualanPengirimanDetail::find()->where(['id_penjualan_pengiriman' => $data->id_penjualan_pengiriman])->count();
                                                                if ($cek_detail > 0) {
                                                                    # code...
                                                                ?>
                                                                    <?= Html::button(
                                                                        '<span class="glyphicon glyphicon-ok"></span> Terkirim',
                                                                        [
                                                                            'value' => Url::to(['akt-penjualan-pengiriman/terkirim', 'id' => $data->id_penjualan_pengiriman]),
                                                                            'title' => 'Ubah Data Terkirim',
                                                                            'class' => 'showModalButton btn btn-primary',
                                                                            'style' => [
                                                                                'float' => 'right',
                                                                                'margin-right' => '5px',
                                                                            ],
                                                                        ]
                                                                    ); ?>
                                                                <?php } ?>
                                                        <?php }
                                                        } ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Surat Pengantar', ['akt-penjualan-pengiriman/cetak-surat-pengantar', 'id' => $data->id_penjualan_pengiriman], [
                                                            'class' => 'btn btn-default',
                                                            'style' => [
                                                                'float' => 'right',
                                                                'margin-right' => '5px',
                                                            ],
                                                            'target' => '_blank'
                                                        ]) ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Label Barang', ['akt-penjualan-pengiriman/cetak-label-barang', 'id' => $data->id_penjualan_pengiriman], [
                                                            'class' => 'btn btn-default',
                                                            'style' => [
                                                                'float' => 'right',
                                                                'margin-right' => '5px',
                                                            ],
                                                            'target' => '_blank'
                                                        ]) ?>
                                                    </div>
                                                    <div id="collapse<?php echo $no; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">

                                                            <div class="row">
                                                                <style>
                                                                    .th1 {
                                                                        width: 10%;
                                                                        white-space: nowrap;
                                                                    }
                                                                </style>
                                                                <div class="col-sm-4">
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="th1">No. Pengiriman</th>
                                                                                <th>:</th>
                                                                                <th><?= $data->no_pengiriman ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="th1">Tanggal Pengiriman</th>
                                                                                <th>:</th>
                                                                                <th><?= tanggal_indo($data->tanggal_pengiriman, true) ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="th1">Pengantar</th>
                                                                                <th>:</th>
                                                                                <th><?= $data->pengantar ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="th1">Keterangan Pengantar</th>
                                                                                <th>:</th>
                                                                                <th><?= nl2br(htmlspecialchars($data->keterangan_pengantar)) ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <table class="table table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="th1">Alamat Pengiriman</th>
                                                                                <th>:</th>
                                                                                <?php
                                                                                $retVal_id_mitra_bisnis_alamat = (!empty($data->id_mitra_bisnis_alamat)) ? $data->id_mitra_bisnis_alamat : 0;
                                                                                $mitra_bisnis_alamat = AktMitraBisnisAlamat::findOne($retVal_id_mitra_bisnis_alamat)
                                                                                ?>
                                                                                <th><?= $mitra_bisnis_alamat->keterangan_alamat ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="th1">Penerima</th>
                                                                                <th>:</th>
                                                                                <th><?= $data->penerima ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="th1">Tanggal Penerimaan</th>
                                                                                <th>:</th>
                                                                                <th><?= (!empty($data->tanggal_penerimaan)) ? date('d/m/Y H:i', strtotime($data->tanggal_penerimaan)) : '' ?></th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="th1">Keterangan Penerima</th>
                                                                                <th>:</th>
                                                                                <th><?= $data->keterangan_penerima ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 10px;white-space: nowrap; vertical-align: text-top;">Foto Resi</th>
                                                                                <th style="vertical-align: text-top;">:</th>
                                                                                <th rowspan="4">
                                                                                    <a target="_BLANK" href="/backend/web/upload/<?= $data->foto_resi ?>">
                                                                                        <img src="/backend/web/upload/<?= $data->foto_resi ?>" style="width: 49%;height: auto;">
                                                                                    </a>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if ($data->status == 0) {
                                                                # code...
                                                            ?>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Barang Pengiriman', '#', [
                                                                            'class' => 'btn btn-success',
                                                                            'data-toggle' => 'modal',
                                                                            'data-target' => '#modal-penjualan-pengiriman-detail',
                                                                            'style' => [
                                                                                'float' => 'left',
                                                                                'margin-right' => '5px',
                                                                            ],
                                                                            'data-id' => $data->id_penjualan_pengiriman,
                                                                            'onclick' => "isi_form_barang_pengiriman('$data->id_penjualan_pengiriman')",
                                                                        ]) ?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <hr>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 1%;">No</th>
                                                                        <th style="width: 10%;">Kode Barang</th>
                                                                        <th>Nama Barang</th>
                                                                        <th style="width: 10%;">Qty Dikirim</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $angka = 0;
                                                                    $penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::findAll(['id_penjualan_pengiriman' => $data->id_penjualan_pengiriman]);
                                                                    foreach ($penjualan_pengiriman_detail as $key => $dataa) {
                                                                        # code...
                                                                        $angka++;
                                                                        $retVal_id_penjualan_detail = (!empty($dataa->id_penjualan_detail)) ? $dataa->id_penjualan_detail : 0;
                                                                        $penjualan_detail = AktPenjualanDetail::findOne($retVal_id_penjualan_detail);
                                                                        $retVal_id_item_stok = (!empty($penjualan_detail->id_item_stok)) ? $penjualan_detail->id_item_stok : 0;
                                                                        $item_stok = AktItemStok::findOne($retVal_id_item_stok);
                                                                        $retVal_id_item = (!empty($item_stok->id_item)) ? $item_stok->id_item : 0;
                                                                        $item = AktItem::findOne($retVal_id_item);
                                                                    ?>
                                                                        <tr>
                                                                            <td><?= $angka . '.' ?></td>
                                                                            <td><?= (!empty($item->kode_item)) ? $item->kode_item : '' ?></td>
                                                                            <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                                                                            <td><?= $dataa->qty_dikirim ?></td>
                                                                            <td><?= $dataa->keterangan ?></td>
                                                                            <?php
                                                                            if ($data->status == 0) {
                                                                                # code...
                                                                            ?>
                                                                                <td>
                                                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-penjualan-pengiriman-detail/delete', 'id' => $dataa->id_penjualan_pengiriman_detail], [
                                                                                        'class' => 'btn btn-danger',
                                                                                        'data' => [
                                                                                            'confirm' => (!empty($item->nama_item)) ? 'Apakah anda yakin akan menghapus pengiriman barang ' . $item->nama_item : '' . '?',
                                                                                            'method' => 'post',
                                                                                        ],
                                                                                    ]) ?>
                                                                                </td>
                                                                            <?php } ?>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                $no++;
                                            }
                                            ?>
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

<!-- add new mitra bisnis alamat -->
<div class="modal fade" id="modal-tambah-data-alamat-pengiriman">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data Alamat Pengiriman</h4>
            </div>
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['akt-penjualan-pengiriman/tambah-data-alamat-pengiriman', 'id' => $_GET['id']],
            ]); ?>
            <div class="modal-body">

                <?= $form->field($model_mitra_bisnis_alamat, 'keterangan_alamat')->textInput() ?>

                <?= $form->field($model_mitra_bisnis_alamat, 'alamat_lengkap')->textarea(['rows' => 6]) ?>

                <?= $form->field($model_mitra_bisnis_alamat, 'id_kota')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(AktKota::find()->all(), 'id_kota', 'nama_kota'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Pilih Kota'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Pilih Kota');
                ?>


                <?= $form->field($model_mitra_bisnis_alamat, 'telephone')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- add new mitra bisnis alamat -->
<div class="modal fade" id="modal-penjualan-pengiriman-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Data Barang Pengiriman</h4>
            </div>
            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'action' => ['tambah-data-barang-pengiriman', 'id' => $_GET['id']],
            ]); ?>
            <div class="modal-body">

                <?= $form->field($model_penjualan_pengiriman_detail, 'id_penjualan_pengiriman')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                <?= $form->field($model_penjualan_pengiriman_detail, 'id_penjualan_detail')->widget(Select2::classname(), [
                    'data' => $data_penjualan_detail,
                    'language' => 'en',
                    'options' => ['placeholder' => 'Pilih Barang', 'required' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

                <?= $form->field($model_penjualan_pengiriman_detail, 'qty_dikirim')->textInput(['type' => 'number']) ?>

                <?= $form->field($model_penjualan_pengiriman_detail, 'keterangan')->textarea(['rows' => 6]) ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    // Initialize tooltip component
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // Initialize popover component
    $(function() {
        $('[data-toggle="popover"]').popover()
    })

    function isi_form_barang_pengiriman(id_penjualan_pengiriman) {
        $('#aktpenjualanpengirimandetail-id_penjualan_pengiriman').val(id_penjualan_pengiriman);
    }
</script>