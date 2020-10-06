<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferStok */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-transfer-stok-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-truck"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'no_transfer')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_transfer')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                            <?= $form->field($model, 'id_gudang_asal')->widget(Select2::classname(), [
                                'data' => $data_gudang,
                                'language' => 'en',
                                'disabled' => $disabled,
                                'options' => ['placeholder' => 'Pilih Gudang Asal'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'id_gudang_tujuan')->widget(Select2::classname(), [
                                'data' => $data_gudang,
                                'language' => 'en',
                                'disabled' => $disabled,
                                'options' => ['placeholder' => 'Pilih Gudang Tujuan'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 5]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_transfer_stok];
                        }

                        ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>