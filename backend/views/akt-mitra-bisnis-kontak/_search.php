<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisKontakSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-kontak-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_mitra_bisnis_kontak') ?>

    <?= $form->field($model, 'id_mitra_bisnis') ?>

    <?= $form->field($model, 'nama_kontak') ?>

    <?= $form->field($model, 'jabatan') ?>

    <?= $form->field($model, 'handphone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
