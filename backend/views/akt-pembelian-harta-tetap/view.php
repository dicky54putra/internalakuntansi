<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\Foto;
use backend\models\AktMitraBisnis;
use backend\models\AktCabang;
use backend\models\AktMataUang;
use backend\models\AktHartaTetap;
use backend\models\AktKasBank;
use backend\models\AktApprover;
use backend\models\Login;
use backend\models\AktLevelHarga;

use backend\models\AktPembelianHartaTetap;
use backend\models\AktPembelianHartaTetapDetail;
use kartik\select2\Select2;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianHartaTetap */

$cek_detail = AktPembelianHartaTetapDetail::find()
    ->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])
    ->count();

$this->title = "Detail Pembelian Harta Tetap : " . $model->no_pembelian_harta_tetap;
?>
<style>
    #materaiInput::placeholder {
        /* Chrome, Firefox, Opera, Safari 10.1+ */
        color: black;
        opacity: 0.8;
    }
</style>
<div class="akt-pembelian-harta-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Pembelian Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $model->no_pembelian_harta_tetap ?></li>
    </ul>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php

        if ($approve > 0) {
        ?>

            <?php if ($model->status == 1) { ?>
                <?= Html::a('<span class="glyphicon glyphicon-check"></span> Approve', ['approve', 'id' => $model->id_pembelian_harta_tetap], [
                    'class' => 'btn btn-success',
                ]) ?>


                <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_pembelian_harta_tetap], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menolak Pembelian Harta Tetap ini? ',
                        'method' => 'post',
                    ],
                ]) ?>

            <?php } else if ($model->status > 1) { ?>
                <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_pembelian_harta_tetap], [
                    'class' => 'btn btn-info',
                ]) ?>
            <?php } ?>
        <?php } else if ($approve == 0 && $model->status == 1) {  ?>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ubah-data-pembelian">
                <span class="glyphicon glyphicon-edit"></span> Ubah Data Pembelian
            </button>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pembelian_harta_tetap], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah kamu yakin ingin menghapus barang ini?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['print-view', 'id' => $model->id_pembelian_harta_tetap], ['class' => 'btn btn-default button-cetak', 'target' => '_BLANK']) ?>

    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-list-alt"></span> Pembelian Harta Tetap</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'no_pembelian_harta_tetap',
                                [
                                    'attribute' => 'tanggal',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal);
                                    }
                                ],
                                [
                                    'attribute' => 'id_supplier',
                                    'label' => 'Supplier',
                                    'value' => function ($model) {

                                        $supp = AktMitraBisnis::find()->where(['id_mitra_bisnis' => $model->id_supplier])->one();

                                        if ($supp) {
                                            return $supp->nama_mitra_bisnis;
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'id_mata_uang',
                                    'label' => 'Mata Uang',
                                    'value' => function ($model) {

                                        $uang = AktMataUang::find()->where(['id_mata_uang' => $model->id_mata_uang])->one();
                                        if ($uang) {
                                            return $uang->mata_uang;
                                        }
                                    }
                                ],
                                'keterangan:ntext',
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->id_login != null) {
                                            $login = Login::find()->where(['id_login' => $model->id_login])->one();
                                        }
                                        if ($model->status == 2) {
                                            return '<p class="label label-success" style="font-weight:bold;"> Disetujui pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $login->nama . '</p> ';
                                        } else if ($model->status == 1) {
                                            return '<p class="label label-warning" style="font-weight:bold;"> Belum Disetujui </p> ';
                                        } else if ($model->status == 3) {
                                            return '<p class="label label-danger" style="font-weight:bold;"> Ditolak pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $login->nama . '</p> ';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                        <div class="row" style="margin-top:30px;">
                            <div class="col-md-12">
                                <div class="box-header ">
                                    <div class="box-title"> Daftar Harta</div>
                                </div>
                                <div class="box-body">
                                    <?php if ($is_null < 1) { ?>
                                        <?php if ($model->status == 1 && $approve == 0) { ?>
                                            <div class="row">

                                                <?php $form = ActiveForm::begin([
                                                    'action' => ['akt-pembelian-harta-tetap-detail/create'],
                                                    'method' => 'post',
                                                ]); ?>

                                                <?= $form->field($model_akt_pembelian_harta_tetap_detail, 'id_pembelian_harta_tetap')->textInput(['readonly' => true, 'value' => $model->id_pembelian_harta_tetap, 'type' => 'hidden'])->label(FALSE) ?>

                                                <div class="col-md-4">
                                                    <?= $form->field($model_akt_pembelian_harta_tetap_detail, 'nama_barang')->textInput(['placeholder' => 'Nama Barang'])->label('Nama Barang') ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_akt_pembelian_harta_tetap_detail, 'qty')->textInput(['required' => true, 'disabled' => true, 'value' => 1]) ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_akt_pembelian_harta_tetap_detail, 'harga')->widget(\yii\widgets\MaskedInput::className(), [
                                                        'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                                        'options' => ['required' => true]
                                                    ]); ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_akt_pembelian_harta_tetap_detail, 'residu')->widget(\yii\widgets\MaskedInput::className(), [
                                                        'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                                        'options' => ['required' => true]
                                                    ]); ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <?= $form->field($model_akt_pembelian_harta_tetap_detail, 'diskon')->textInput(['placeholder' => 'Diskon %'])->label('Diskon %') ?>
                                                </div>

                                                <div class="col-md-10">
                                                    <?= $form->field($model_akt_pembelian_harta_tetap_detail, 'keterangan')->textInput(['placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="submit" name="tambah-detail" class="btn btn-success" style="width: 100%;"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                </div>

                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div style="margin-top:20px;">
                                        <table id="pembelian" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th style="width: 20%;">Nama Barang</th>
                                                    <th style="width: 3%;">Qty</th>
                                                    <th style="width: 10%;">Harga</th>
                                                    <th style="width: 10%;">Residu</th>
                                                    <th style="width: 8%;">Diskon %</th>
                                                    <th style="width: 20%;">Keterangan</th>
                                                    <th style="width: 10%;">Sub Total</th>
                                                    <?php if ($model->status >= 2 && $approve == 0) { ?>
                                                        <th style="width: 10%;">Aksi</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $total_pembelian = 0;
                                                foreach ($model_detail as $data) {
                                                    $total = $data['harga'] * $data['qty'];
                                                    $diskon = $total * $data['diskon'] / 100;
                                                    $sub_total = $total - $diskon;
                                                    $total_pembelian += $sub_total;
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $data['nama_barang'] ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td><?= ribuan($data['harga']) ?></td>
                                                        <td><?= ribuan($data['residu']) ?></td>
                                                        <td><?= $data['diskon'] ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td align="right"><?= ribuan($sub_total) ?> </td>
                                                        <?php if ($model->status == 1 && $approve == 0) { ?>
                                                            <td>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-pembelian-harta-tetap-detail/delete', 'id' => $data['id_pembelian_harta_tetap_detail']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Apakah Anda yakin akan menghapus ' . $data['nama_barang'] . ' dari Data Pembelian Harta Tetap?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>

                                                    <th colspan="7" style="text-align: right;">Total Harga</th>
                                                    <th style="text-align: right;"><?= ribuan($total_pembelian) ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Diskon <?= $model->diskon ?> %</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $diskon = ($model->diskon * $total_pembelian) / 100;
                                                        echo ribuan($diskon);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Pajak 10 % (<?= ($model->pajak == NULL) ? '' : $retVal = ($model->pajak == 1) ? '<span class="glyphicon glyphicon-ok"></span>' : '<span class="glyphicon glyphicon-remove"></span>' ?>)</th>
                                                    <th style="text-align: right;">
                                                        <?php
                                                        $pajak_ = (($total_pembelian - $diskon) * 10) / 100;
                                                        $pajak = ($model->pajak == 1) ? $pajak_ : 0;
                                                        echo ribuan($pajak);
                                                        ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Materai</th>
                                                    <th style="text-align: right;"><?= ribuan($model->materai) ?></th>
                                                </tr>

                                                <tr>
                                                    <th colspan="7" style="text-align: right;">Ongkir</th>
                                                    <th style="text-align: right;"><?= ribuan($model->ongkir) ?></th>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    $grand_total = $model->materai  + $pajak + $total_pembelian - $diskon  + $model->ongkir;
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
                                                    <th colspan="7" style="text-align: right;">Sisa Dana yang Masih Harus Dibayarkan</th>
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
</div>
<style>
    @media (min-width: 992px) {
        .modal-content {
            margin: 0 -150px;
        }

    }
</style>
</div>
<div class="modal fade" id="ubah-data-pembelian">
    <div class="modal-dialog ">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Data Pembelian Harta Tetap</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['ubah-data-pembelian', 'id' => $model->id_pembelian_harta_tetap],
                    'method' => 'post',
                ]); ?>
                <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Pembelian Harta Tetap</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-grop">
                            <?= $form->field($model, 'no_pembelian_harta_tetap')->textInput(['readonly' => true, 'required' => 'on', 'autocomplete' => 'off']) ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'id_mata_uang')->widget(Select2::classname(), [
                                'data' => $data_mata_uang,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Mata Uang'],
                                'pluginOptions' => [
                                    'allowClear' => true,

                                ],
                            ])->label('Mata Uang')
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'id_supplier')->widget(Select2::classname(), [
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
                </div>

                <?php if ($cek_detail > 0) { ?>
                    <label class="label label-primary col-xs-12" style="font-size: 15px; padding:10px; margin:20px 0;">Data Perhitungan Pembelian Harta Tetap</label>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <?= $form->field($model, 'diskon')->textInput(['value' => $model->diskon == '' ? 0 : $model->diskon, 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'id' => 'diskon-floating', 'class' => 'diskon-pembelian form-control'])->label('Diskon %') ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'ongkir')->textInput(['value' => $model->ongkir == '' ? 0 : $model->ongkir, 'autocomplete' => 'off', 'class' => 'ongkir_pembelian form-control'])->label('Ongkir') ?>
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
                                <?= $form->field($model, 'jatuh_tempo', ['options' => ['id' => 'jatuh_tempo', 'hidden' => 'yes']])->dropDownList(array(
                                    15 => 15,
                                    30 => 30,
                                    45 => 45,
                                    60 => 60,
                                ), ['prompt' => 'Pilih Jatuh Tempo']) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'tanggal_tempo', ['options' => ['id' => 'tanggal_tempo', 'hidden' => 'yes']])->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'id_pembelian_harta_tetap')->textInput(['type' => 'hidden', 'readonly' => true, 'required' => 'on', 'autocomplete' => 'off', 'id' => 'id_pembelian_harta_tetap'])->label(FALSE) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'materai')->textInput(['value' => $model->materai == '' ? 0 : $model->materai, 'autocomplete' => 'off', 'class' => 'materai-pembelian form-control', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+'])->label('Materai') ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'total')->textInput(['type' => 'text', 'value' => ribuan($total_pembelian), 'readonly' => true, 'id' => 'total_pembelian_detail'])->label('Total Pembelian Harta Tetap') ?>
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
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
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
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['tambah-data-supplier', 'id' => $model->id_pembelian_harta_tetap],
                    'method' => 'post',
                ]); ?>

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
                        ],
                    ]);
                    ?>
                </div>
                <div class="form-group">
                    <label for="">Deskripsi Supplier</label>
                    <textarea class="form-control" name="deskripsi_mitra_bisnis" id="deskripsi" cols="10" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
$script = <<< JS
    $(document).ready(function(){ 
        

    if ($("#aktpembelianhartatetap-jenis_bayar").val() == "1")
    {
        $("#aktpembelianhartatetap-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpembelianhartatetap-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpembelianhartatetap-jenis_bayar").val() == "2")
    {
        $("#aktpembelianhartatetap-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpembelianhartatetap-tanggal_tempo").show();
        $('#tanggal_tempo').hide(); 
    }

    $("#aktpembelianhartatetap-jenis_bayar").change(function(){

    if ($("#aktpembelianhartatetap-jenis_bayar").val() == "1")
    {
        $("#aktpembelianhartatetap-jatuh_tempo").hide();
        $('#jatuh_tempo').hide(); 
        $("#aktpembelianhartatetap-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpembelianhartatetap-jenis_bayar").val() == "2")
    {
        $("#aktpembelianhartatetap-jatuh_tempo").show();
        $('#jatuh_tempo').show(); 
        $("#aktpembelianhartatetap-tanggal_tempo").show();
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
    const uangMuka = document.querySelector('#aktpembelianhartatetap-uang_muka');
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