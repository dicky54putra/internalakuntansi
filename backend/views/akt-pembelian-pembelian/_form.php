<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\AktLevelHarga;
use backend\models\AktMataUang;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> Data Pembelian</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $form->field($model, 'no_pembelian')->textInput(['readonly' => true]) ?>

                            </div>
                            <div class="form-group">
                                <?php

                                if ($model->tanggal_pembelian == '0000-00-00' || $model->tanggal_pembelian == '') {
                                    $model->tanggal_pembelian = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
                                }

                                ?>

                                <?= $form->field($model, 'tanggal_pembelian')->widget(\yii\jui\DatePicker::classname(), [
                                    'clientOptions' => [
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    ],
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => ['class' => 'form-control']
                                ]) ?>
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
                                                'data-target' => '#modal-default'
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
                                        'allowClear' => true
                                    ],
                                ])->label('Mata Uang')
                                ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model, 'status')->dropDownList(array(2 => "Pembelian")) ?>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Supplier</h4>
            </div>
            <div class="modal-body">
                <?= Html::beginForm(['akt-pembelian-pembelian/create-supplier', 'aksi' => 'supplier'], 'post') ?>

                <div class="form-group">
                    <label for="">Nama Supplier</label>
                    <input type="text" name="nama_mitra_bisnis" class="form-control" id="">
                </div>
                <div class="form-group">
                    <label for="">Tipe Mitra Bisnis</label>
                    <select name="tipe_mitra_bisnis" id="" class="form-control">
                        <option value="2">Supplier</option>
                        <option value="3">Supplier & Customer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Deskripsi Supplier</label>
                    <textarea class="form-control" name="deskripsi_mitra_bisnis" id="" cols="10" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>