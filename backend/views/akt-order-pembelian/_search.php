<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktOrderPembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-order-pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_order_pembelian') ?>

    <?= $form->field($model, 'no_order') ?>

    <?= $form->field($model, 'tanggal_order') ?>

    <?= $form->field($model, 'status_order') ?>

    <?= $form->field($model, 'id_supplier') ?>

    <?php // echo $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'id_cabang') ?>

    <?php // echo $form->field($model, 'draft') ?>

    <?php // echo $form->field($model, 'alamat_bayar') ?>

    <?php // echo $form->field($model, 'alamat_kirim') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
