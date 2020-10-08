<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualanDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-retur-penjualan-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_retur_penjualan_detail') ?>

    <?= $form->field($model, 'id_retur_penjualan') ?>

    <?= $form->field($model, 'id_penjualan_detail') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'retur') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
