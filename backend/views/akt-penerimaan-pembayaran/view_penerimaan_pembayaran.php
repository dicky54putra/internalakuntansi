<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPenerimaanPembayaran;
use backend\models\AktKasBank;
use backend\models\AktPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */

$this->title = 'Detail Data Penerimaan : ' . $model->no_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penjualan-penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penerimaan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
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
                                    [
                                        'label' => 'Total Biaya Penjualan',
                                        'value' => function ($model) {
                                            return ribuan($model->total + $model->uang_muka);
                                        }
                                    ],
                                    [
                                        'label' => 'Total Yang Telah di Bayar',
                                        'value' => function ($model) {
                                            $query = (new \yii\db\Query())->from('akt_penerimaan_pembayaran')->where(['id_penjualan' => $model->id_penjualan]);
                                            $sum_nominal = $query->sum('nominal');
                                            return ribuan($sum_nominal == 0 ? $model->uang_muka : $sum_nominal);
                                        }
                                    ],
                                    [
                                        'label' => 'Total Yang Belum di Bayar',
                                        'value' => function ($model) {
                                            $query = (new \yii\db\Query())->from('akt_penerimaan_pembayaran')->where(['id_penjualan' => $model->id_penjualan]);
                                            $sum_nominal = $query->sum('nominal');

                                            $kekurangan_pembayaran = 0;
                                            $total =  $model->total;

                                            if ($sum_nominal != 0) {
                                                $total = $model->total + $model->uang_muka;
                                                $total_belum_dibayar = $total - $sum_nominal;

                                                if ($sum_nominal > $total) {
                                                    $kelebihan = $sum_nominal - $total;
                                                    return 'Kelebihan : ' . ribuan($kelebihan);
                                                }
                                                return ribuan($total_belum_dibayar);
                                            } else {

                                                return ribuan($total);
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
                                    'materai',
                                    // [
                                    //     'attribute' => 'status',
                                    //     'format' => 'raw',
                                    //     'value' => function ($model) {
                                    //         if ($model->status == 1) {
                                    //             # code...
                                    //             return "<span class='label label-default'>Order Penjualan</span>";
                                    //         } elseif ($model->status == 2) {
                                    //             # code...
                                    //             return "<span class='label label-warning'>Penjualan</span>";
                                    //         } elseif ($model->status == 3) {
                                    //             # code...
                                    //             return "<span class='label label-primary'>Pengiriman</span>";
                                    //         } elseif ($model->status == 4) {
                                    //             # code...
                                    //             return "<span class='label label-success'>Completed</span>";
                                    //         }
                                    //     }
                                    // ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'filter' => array(
                                            1 => 'Lunas',
                                            2 => 'Belum Lunas',
                                        ),
                                        'value' => function ($model) {
                                            $query = (new \yii\db\Query())->from('akt_penerimaan_pembayaran')->where(['id_penjualan' => $model->id_penjualan]);
                                            $sum_nominal = $query->sum('nominal');
                                            if ($model->total == $sum_nominal) {
                                                return "<span class='label label-success'>Lunas</span>";
                                            } else if ($model->total != $sum_nominal) {
                                                return "<span class='label label-warning'>Belum Lunas</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-box"></span> Data Penerimaan Pembayaran</a></li>
                            <?php
                            if ($model->total > $sum_nominal) {
                                # code...
                            ?>
                                <li><a data-toggle="tab" href="#isi-data-penjualan"> <span class="glyphicon glyphicon-plus"></span> Tambah Data Penerimaan Pembayaran</a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th style="width: 15%;">Tanggal Penerimaan</th>
                                                    <th style="width: 10%;">Cara Bayar</th>
                                                    <th style="width: 15%;">Kas Bank</th>
                                                    <th style="width: 10%;">Nominal</th>
                                                    <th style="width: 40%;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 0;
                                                $totalan_nominal = 0;
                                                $query_penerimaan_pembayaran = AktPenerimaanPembayaran::find()->where(['id_penjualan' => $model->id_penjualan])->all();
                                                foreach ($query_penerimaan_pembayaran as $key => $data) {
                                                    # code...
                                                    $kas_bank = AktKasBank::findOne($data['id_kas_bank']);
                                                    $totalan_nominal += $data['nominal'];
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?= $no . '.' ?></td>
                                                        <td><?= tanggal_indo($data['tanggal_penerimaan_pembayaran'], true) ?></td>
                                                        <td><?= ($data['cara_bayar'] == 1) ? 'Tunai' : $retVal = ($data['cara_bayar'] == 2) ? 'Transfer' : 'Giro'; ?></td>
                                                        <td><?= (!empty($kas_bank->keterangan)) ? $kas_bank->kode_kas_bank . ' - ' . $kas_bank->keterangan : '' ?></td>
                                                        <td style="text-align: right;"><?= ribuan($data['nominal']) ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td>
                                                            <?php
                                                            $query = (new \yii\db\Query())->from('akt_penerimaan_pembayaran')->where(['id_penjualan' => $model->id_penjualan]);
                                                            $sum_nominal = $query->sum('nominal');
                                                            if ($model->total == $sum_nominal) {
                                                            } else if ($model->total != $sum_nominal) {

                                                            ?>
                                                                <?php  //Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-penerimaan-pembayaran/update-from-view', 'id' => $data['id_penerimaan_pembayaran_penjualan']], ['class' => 'btn btn-primary']) 
                                                                ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-penerimaan-pembayaran/delete-from-view', 'id' => $data['id_penerimaan_pembayaran_penjualan']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Apakah anda yakin akan menghapus data nomor ' . $no . ' dari list Data Penerimaan Pembayaran ?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4">Total</th>
                                                    <th style="text-align: right;"><?= ribuan($totalan_nominal) ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div id="isi-data-penjualan" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <?php $form = ActiveForm::begin([
                                            'method' => 'post',
                                            'action' => ['akt-penerimaan-pembayaran/create-from-view'],
                                        ]); ?>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <?= $form->field($model_penerimaan_pembayaran, 'tanggal_penerimaan_pembayaran')->widget(\yii\jui\DatePicker::classname(), [
                                                    'clientOptions' => [
                                                        'changeMonth' => true,
                                                        'changeYear' => true,
                                                    ],
                                                    'dateFormat' => 'yyyy-MM-dd',
                                                    'options' => ['class' => 'form-control', 'autocomplete' => 'off']
                                                ]) ?>

                                                <?= $form->field($model_penerimaan_pembayaran, 'id_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                <?= $form->field($model_penerimaan_pembayaran, 'cara_bayar')->dropDownList(
                                                    array(
                                                        1 => "Tunai",
                                                        2 => "Transfer",
                                                    ),
                                                    ['prompt' => 'Pilih Cara Bayar']
                                                ) ?>
                                                <?= $form->field($model_penerimaan_pembayaran, 'id_kas_bank')->widget(DepDrop::classname(), [
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'options' => ['id' => 'id-kas-bank', 'placeholder' => 'Pilih Kas Bank...'],
                                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                    'pluginOptions' => [
                                                        'depends' => ['aktpenerimaanpembayaran-cara_bayar'],
                                                        'url' => Url::to(['/akt-pembayaran-biaya/kas-bank'])
                                                    ]
                                                ])->label('Kas Bank');
                                                ?>

                                            </div>
                                            <div class="col-md-6">

                                                <?php
                                                if ($model->jenis_bayar == 1) {
                                                    echo $form->field($model_penerimaan_pembayaran, 'nominal')->widget(
                                                        \yii\widgets\MaskedInput::className(),
                                                        [
                                                            'options' => ['autocomplete' => 'off', 'value' => $model->total, 'readonly' => true],
                                                            'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]
                                                        ]
                                                    );
                                                } else {
                                                    echo $form->field($model_penerimaan_pembayaran, 'nominal')->widget(
                                                        \yii\widgets\MaskedInput::className(),
                                                        [
                                                            'options' => ['autocomplete' => 'off'],
                                                            'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]
                                                        ]
                                                    );
                                                }

                                                ?>

                                                <?= $form->field($model_penerimaan_pembayaran, 'keterangan')->textarea(['rows' => 4]) ?>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                                        </div>

                                        <?php ActiveForm::end(); ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>