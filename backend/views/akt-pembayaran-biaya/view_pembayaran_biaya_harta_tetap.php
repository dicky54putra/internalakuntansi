<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPenerimaanPembayaran;
use backend\models\AktKasBank;
use backend\models\AktPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use backend\models\AktPembayaranBiaya;
use backend\models\AktPembayaranBiayaHartaTetap;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktPembelianHartaTetapDetail;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use backend\models\Login;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */

$this->title = 'Detail Data Pembayaran : ' . $model->no_pembelian_harta_tetap;
// $this->params['breadcrumbs'][] = ['label' => 'Akt pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pembelian-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pembayaran', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index', '#' => 'data-pembelian-harta-tetap'], ['class' => 'btn btn-warning']) ?>
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
                                    'no_pembelian_harta_tetap',
                                    [
                                        'attribute' => 'tanggal',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal)) {
                                                # code...
                                                return tanggal_indo($model->tanggal, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    'no_faktur_pembelian',
                                    [
                                        'attribute' => 'tanggal_faktur_pembelian',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_faktur_pembelian)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_faktur_pembelian, true);
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'label' => 'Total Biaya Pembelian',
                                        'value' => function ($model) {
                                            $total = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->sum('harga');
                                            // $sum_subtotal = 0;
                                            // foreach ($total as $k) {
                                            //     $subtotal = $k->qty * $k->harga;
                                            //     $sum_subtotal += $subtotal;
                                            // }
                                            // return ribuan($total);
                                            return ribuan($total + $model->uang_muka);
                                        }
                                    ],
                                    [
                                        'label' => 'Total Yang Telah di Bayar',
                                        'value' => function ($model) {
                                            $query = (new \yii\db\Query())->from('akt_pembayaran_biaya_harta_tetap')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
                                            $sum_nominal = $query->sum('nominal');
                                            return ribuan($sum_nominal == 0 ? $model->uang_muka : $sum_nominal + $model->uang_muka);
                                        }
                                    ],
                                    [
                                        'label' => 'Total Yang Belum di Bayar',
                                        'value' => function ($model) {
                                            $query = (new \yii\db\Query())->from('akt_pembayaran_biaya_harta_tetap')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
                                            $sum_nominal = $query->sum('nominal');

                                            $kekurangan_pembayaran = 0;

                                            $total_ = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->sum('harga');

                                            $total = 0;
                                            if ($sum_nominal != 0) {
                                                $total = $total_;
                                                $total_belum_dibayar = $total - $sum_nominal;

                                                if ($sum_nominal > $total) {
                                                    $kelebihan = $sum_nominal - $total;
                                                    return 'Kelebihan : ' . ribuan($kelebihan);
                                                }
                                                return ribuan($total_belum_dibayar);
                                            } else {
                                                return ribuan($total_);
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
                                    'materai',
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'filter' => array(
                                            1 => 'Lunas',
                                            2 => 'Belum Lunas',
                                        ),
                                        'value' => function ($model) {
                                            $query = (new \yii\db\Query())->from('akt_pembayaran_biaya_harta_tetap')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
                                            $sum_nominal = $query->sum('nominal');
                                            $total = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->sum('harga');
                                            // return $sum_nominal;
                                            if ($total == $sum_nominal) {
                                                return "<span class='label label-success'>Lunas</span>";
                                            } else if ($total > $sum_nominal) {
                                                return "<span class='label label-warning'>Belum Lunas</span>";
                                            } else if ($total < $sum_nominal) {
                                                return "<span class='label label-info'>Kelebihan</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="" style="margin-top:20px;">
                        <?php
                        $query = (new \yii\db\Query())->from('akt_pembayaran_biaya_harta_tetap')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
                        $sum_nominal = $query->sum('nominal');

                        $total_ = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->sum('harga');
                        if ($sum_nominal == $total_) {
                            $hidden = 'hidden';
                        } else {
                            $hidden = '';
                        }
                        ?>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang"><span class="fa fa-box"></span> Data Pembayaran Biaya</a></li>
                            <?php
                            // if ($model->total > $sum_nominal) {
                            //     # code...
                            ?>
                            <li class="<?= $hidden ?>"><a data-toggle="tab" href="#isi-data-Pembelian"> <span class="glyphicon glyphicon-plus"></span> Tambah Data Pembayaran Biaya</a></li>
                            <?php //} 
                            ?>
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
                                                $query_pembayaran_biaya = AktPembayaranBiayaHartaTetap::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->all();
                                                foreach ($query_pembayaran_biaya as $key => $data) {
                                                    # code...
                                                    $kas_bank = AktKasBank::findOne($data['id_kas_bank']);
                                                    $totalan_nominal += $data['nominal'];
                                                    $no++;
                                                ?>
                                                    <tr>
                                                        <td><?= $no . '.' ?></td>
                                                        <td><?= tanggal_indo($data['tanggal_pembayaran_biaya'], true) ?></td>
                                                        <td><?= ($data['cara_bayar'] == 1) ? 'Tunai' : $retVal = ($data['cara_bayar'] == 2) ? 'Transfer' : 'Giro'; ?></td>
                                                        <td><?= (!empty($kas_bank->keterangan)) ? $kas_bank->kode_kas_bank . ' - ' . $kas_bank->keterangan : '' ?></td>
                                                        <td style="text-align: right;"><?= ribuan($data['nominal']) ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td>
                                                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-pembayaran-biaya/delete-from-view-harta-tetap', 'id' => $data['id_pembayaran_biaya_harta_tetap']], [
                                                                'class' => 'btn btn-danger',
                                                                'data' => [
                                                                    'confirm' => 'Apakah anda yakin akan menghapus data nomor ' . $no . ' dari list Data Penerimaan Pembayaran ?',
                                                                    'method' => 'post',
                                                                ],
                                                            ]) ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4">Total</th>
                                                    <th style="text-align: right;"><?php echo ribuan($totalan_nominal) ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div id="isi-data-Pembelian" class="tab-pane fade <?= $hidden ?>" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">

                                        <?php $form = ActiveForm::begin([
                                            'method' => 'post',
                                            'action' => ['akt-pembayaran-biaya/create-harta-tetap-from-view'],
                                        ]); ?>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <?= $form->field($model_pembayaran_biaya, 'tanggal_pembayaran_biaya')->widget(\yii\jui\DatePicker::classname(), [
                                                    'clientOptions' => [
                                                        'changeMonth' => true,
                                                        'changeYear' => true,
                                                    ],
                                                    'dateFormat' => 'yyyy-MM-dd',
                                                    'options' => ['class' => 'form-control', 'autocomplete' => 'off']
                                                ]) ?>

                                                <?= $form->field($model_pembayaran_biaya, 'id_pembelian_harta_tetap')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                <?= $form->field($model_pembayaran_biaya, 'cara_bayar')->dropDownList(
                                                    array(
                                                        1 => "Tunai",
                                                        2 => "Transfer",
                                                        // 3 => "Giro"
                                                    ),
                                                    ['prompt' => 'Pilih Cara Bayar']
                                                ) ?>
                                                <?= $form->field($model_pembayaran_biaya, 'id_kas_bank')->widget(DepDrop::classname(), [
                                                    'type' => DepDrop::TYPE_SELECT2,
                                                    'options' => ['id' => 'id-kas-bank', 'placeholder' => 'Pilih Kas Bank...'],
                                                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                    'pluginOptions' => [
                                                        'depends' => ['aktpembayaranbiayahartatetap-cara_bayar'],
                                                        'url' => Url::to(['/akt-pembayaran-biaya/kas-bank'])
                                                    ]
                                                ])->label('Kas Bank');
                                                ?>

                                            </div>
                                            <div class="col-md-6">
                                                <?php
                                                $total = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->sum('harga');
                                                if ($model->jenis_bayar == 1) {
                                                    echo $form->field($model_pembayaran_biaya, 'nominal')->widget(
                                                        \yii\widgets\MaskedInput::className(),
                                                        [
                                                            'options' => ['autocomplete' => 'off', 'readonly' => true, 'value' => $total],
                                                            'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]
                                                        ]
                                                    );
                                                } else {
                                                    echo $form->field($model_pembayaran_biaya, 'nominal')->widget(
                                                        \yii\widgets\MaskedInput::className(),
                                                        [
                                                            'options' => ['autocomplete' => 'off'],
                                                            'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]
                                                        ]
                                                    );
                                                }

                                                ?>
                                                <?php
                                                //  $form->field($model_pembayaran_biaya, 'nominal')->widget(
                                                //     \yii\widgets\MaskedInput::className(),
                                                //     [
                                                //         'options' => ['autocomplete' => 'off'],
                                                //         'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]
                                                //     ]
                                                // ); 
                                                ?>

                                                <?= $form->field($model_pembayaran_biaya, 'keterangan')->textarea(['rows' => 4]) ?>

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