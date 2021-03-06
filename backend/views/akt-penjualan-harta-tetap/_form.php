<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-harta-tetap-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'no_penjualan_harta_tetap')->textInput(['readonly' => true]) ?>

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

                            <?= $form->field($model, 'status')->dropDownList(array(1 => 'Belum Disetujui')) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_penjualan_harta_tetap];
                        }

                        ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
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
                'action' => ['add-new-customer'],
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
                'action' => ['add-new-sales'],
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