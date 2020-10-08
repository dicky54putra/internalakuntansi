<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-retur-penjualan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_retur_penjualan') ?>

    <?= $form->field($model, 'no_retur_penjualan') ?>

    <?= $form->field($model, 'tanggal_retur_penjualan') ?>

    <?= $form->field($model, 'id_penjualan') ?>

    <?= $form->field($model, 'status_retur') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
