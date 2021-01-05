<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisBankPajakSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-bank-pajak-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_mitra_bisnis_bank_pajak') ?>

    <?= $form->field($model, 'id_mitra_bisnis') ?>

    <?= $form->field($model, 'nama_bank') ?>

    <?= $form->field($model, 'no_rekening') ?>

    <?= $form->field($model, 'atas_nama') ?>

    <?php // echo $form->field($model, 'npwp') ?>

    <?php // echo $form->field($model, 'pkp') ?>

    <?php // echo $form->field($model, 'tanggal_pkp') ?>

    <?php // echo $form->field($model, 'no_nik') ?>

    <?php // echo $form->field($model, 'atas_nama_nik') ?>

    <?php // echo $form->field($model, 'pembelian_pajak') ?>

    <?php // echo $form->field($model, 'penjualan_pajak') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
