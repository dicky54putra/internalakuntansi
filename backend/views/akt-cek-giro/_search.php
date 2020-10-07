<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCekGiroSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-cek-giro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_cek_giro') ?>

    <?= $form->field($model, 'no_transaksi') ?>

    <?= $form->field($model, 'no_cek_giro') ?>

    <?= $form->field($model, 'tanggal_terbit') ?>

    <?= $form->field($model, 'tanggal_effektif') ?>

    <?php // echo $form->field($model, 'tipe') ?>

    <?php // echo $form->field($model, 'in_out') ?>

    <?php // echo $form->field($model, 'id_bank_asal') ?>

    <?php // echo $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'jumlah') ?>

    <?php // echo $form->field($model, 'cabang_bank') ?>

    <?php // echo $form->field($model, 'tanggal_kliring') ?>

    <?php // echo $form->field($model, 'bank_kliring') ?>

    <?php // echo $form->field($model, 'id_penerbit') ?>

    <?php // echo $form->field($model, 'id_penerima') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
