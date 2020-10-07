<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPajakSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pajak-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pajak') ?>

    <?= $form->field($model, 'nama_pajak') ?>

    <?= $form->field($model, 'id_akun_pembelian') ?>

    <?= $form->field($model, 'id_akun_penjualan') ?>

    <?= $form->field($model, 'presentasi_npwp') ?>

    <?php // echo $form->field($model, 'presentasi_non_npwp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
