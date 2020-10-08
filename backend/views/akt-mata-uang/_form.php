<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMataUang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mata-uang-form">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-usd"></span> Daftar Mata Uang</div>
    <div class="panel-body">
        <div class="col-md-12" style="padding: 0;">
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-lg-6">
    <?= $form->field($model, 'kode_mata_uang')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'mata_uang')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'simbol')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'kurs')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-6">
    <?= $form->field($model, 'fiskal')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'rate_type')->dropDownList(array(1 => 'Normal', 2 => 'Reverse'))->label('Rate Type') ?>

<?= $form->field($model, 'status_default')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif'))->label('Default') ?>
    </div>
</div>
    

    

    <div class="form-group">
	    	<?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
	        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
	    </div>


    <?php ActiveForm::end(); ?>

</div>
</div>
