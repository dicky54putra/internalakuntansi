<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penawaran-penjualan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penawaran_penjualan') ?>

    <?= $form->field($model, 'no_penawaran_penjualan') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'id_customer') ?>

    <?= $form->field($model, 'id_sales') ?>

    <?php // echo $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'pajak') ?>

    <?php // echo $form->field($model, 'id_penagih') ?>

    <?php // echo $form->field($model, 'id_pengirim') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
