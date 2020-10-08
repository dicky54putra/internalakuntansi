<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-retur-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-repeat"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <div class="row">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="col-md-6 col-6">
                            <?= $form->field($model, 'no_retur_pembelian')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_retur_pembelian')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>
                        </div>
                        <div class="col-md-6 col-6">
                            <?= $form->field($model, 'id_pembelian')->widget(Select2::classname(), [
                                'data' => $data_penerimaan,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Pembelian'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('No. Pembelian')
                            ?>

                            <?php
                            if ($model->isNewRecord) {
                                # code...
                            ?>
                                <?= $form->field($model, 'status_retur')->dropDownList(array(1 => "Pengajuan")) ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group" style="margin-left:16px;">
                                <?php
                                if ($model->isNewRecord) {
                                    # code...
                                    $url = ['index'];
                                } else {
                                    # code...
                                    $url = ['view', 'id' => $model->id_retur_pembelian];
                                }

                                ?>
                                <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>