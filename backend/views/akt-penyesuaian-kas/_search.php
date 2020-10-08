<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianKasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penyesuaian-kas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penyesuaian_kas') ?>

    <?= $form->field($model, 'no_transaksi') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'id_akun') ?>

    <?= $form->field($model, 'id_mitra_bisnis') ?>

    <?php // echo $form->field($model, 'no_referensi') ?>

    <?php // echo $form->field($model, 'id_kas_bank') ?>

    <?php // echo $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
