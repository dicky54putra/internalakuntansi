<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemPajakPenjualanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-pajak-penjualan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item_pajak_penjualan') ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'id_pajak') ?>

    <?= $form->field($model, 'perhitungan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
