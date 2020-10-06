<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-retur-pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_retur_pembelian') ?>

    <?= $form->field($model, 'no_retur_pembelian') ?>

    <?= $form->field($model, 'tanggal_retur_pembelian') ?>

    <?= $form->field($model, 'id_pembelian') ?>

    <?= $form->field($model, 'status_retur') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
