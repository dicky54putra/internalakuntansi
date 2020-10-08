<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktDepartement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-departement-form">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-clipboard-list"></span> Data Departemen</div>
    <div class="panel-body">
        <div class="col-md-12" style="padding: 0;">
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_departement')->textInput(['value' => $nomor, 'readonly' =>true]) ?>

    <?= $form->field($model, 'nama_departement')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status_aktif')->dropDownList(array(1 => 'Aktif', 2 => 'Nonaktif'))->label('Status') ?>

    <div class="form-group">
	    	<?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-departement/index'], ['class' => 'btn btn-warning']) ?>
	        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>
