<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktLabaRugi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-laba-rugi-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-file-text"></span> Laporan Laba Rugi</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'tanggal')->textInput(['value' => date("Y-m-d"), 'readonly' => true]) ?>
   <?= $form->field($model, 'periode')->dropDownList(array(1 => 'Bulanan', 2 => 'Triwulan 1', 3 => 'Triwulan 2', 4 => 'Triwulan 3',  4 => 'Triwulan 5',6 => 'Tahunan')) ?>

    <div class="form-group">
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
