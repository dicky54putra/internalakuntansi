<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penjualan') ?>

    <?= $form->field($model, 'no_order_penjualan') ?>

    <?= $form->field($model, 'tanggal_order_penjualan') ?>

    <?= $form->field($model, 'id_customer') ?>

    <?= $form->field($model, 'id_sales') ?>

    <?php // echo $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'no_penjualan') ?>

    <?php // echo $form->field($model, 'tanggal_penjualan') ?>

    <?php // echo $form->field($model, 'no_faktur_penjualan') ?>

    <?php // echo $form->field($model, 'tanggal_faktur_penjualan') ?>

    <?php // echo $form->field($model, 'ongkir') ?>

    <?php // echo $form->field($model, 'pajak') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'bayar') ?>

    <?php // echo $form->field($model, 'kekurangan') ?>

    <?php // echo $form->field($model, 'jenis_bayar') ?>

    <?php // echo $form->field($model, 'jumlah_tempo') ?>

    <?php // echo $form->field($model, 'tanggal_tempo') ?>

    <?php // echo $form->field($model, 'id_kas_bank') ?>

    <?php // echo $form->field($model, 'materai') ?>

    <?php // echo $form->field($model, 'id_penagih') ?>

    <?php // echo $form->field($model, 'id_pengirim') ?>

    <?php // echo $form->field($model, 'tanggal_antar') ?>

    <?php // echo $form->field($model, 'pengantar') ?>

    <?php // echo $form->field($model, 'penerima') ?>

    <?php // echo $form->field($model, 'keterangan_antar') ?>

    <?php // echo $form->field($model, 'tanggal_terima') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
