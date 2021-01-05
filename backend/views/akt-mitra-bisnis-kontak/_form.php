<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisKontak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-kontak-form">
<div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'nama_kontak')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'handphone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
</div>
    <div class="form-group">
    <?= $form->field($model, 'id_mitra_bisnis')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>