<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pembelian') ?>

    <?= $form->field($model, 'no_order_pembelian') ?>

    <?= $form->field($model, 'id_customer') ?>

    <?= $form->field($model, 'id_sales') ?>

    <?= $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'no_pembelian') ?>

    <?php // echo $form->field($model, 'tanggal_pembelian') ?>

    <?php // echo $form->field($model, 'no_faktur_pembelian') ?>

    <?php // echo $form->field($model, 'tanggal_faktur_pembelian') ?>

    <?php // echo $form->field($model, 'ongkir') ?>

    <?php // echo $form->field($model, 'diskon') ?>

    <?php // echo $form->field($model, 'pajak') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'jenis_bayar') ?>

    <?php // echo $form->field($model, 'jatuh_tempo') ?>

    <?php // echo $form->field($model, 'tanggal_tempo') ?>

    <?php // echo $form->field($model, 'materai') ?>

    <?php // echo $form->field($model, 'id_penagih') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
