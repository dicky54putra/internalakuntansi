<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisBankPajak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-bank-pajak-form">
<div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nama_bank')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'no_rekening')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'atas_nama')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
                <?= $form->field($model, 'pkp')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'tanggal_pkp')->widget(\yii\jui\DatePicker::classname(), [
                                    'clientOptions' => [
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    ],
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => ['class' => 'form-control']
                                ]) ?>

                <?= $form->field($model, 'no_nik')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'atas_nama_nik')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= $form->field($model, 'id_mitra_bisnis')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>