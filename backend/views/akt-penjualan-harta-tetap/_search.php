<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-harta-tetap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penjualan_harta_tetap') ?>

    <?= $form->field($model, 'no_penjualan_harta_tetap') ?>

    <?= $form->field($model, 'tanggal_penjualan_harta_tetap') ?>

    <?= $form->field($model, 'id_customer') ?>

    <?= $form->field($model, 'id_sales') ?>

    <?php // echo $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'the_approver') ?>

    <?php // echo $form->field($model, 'the_approver_date') ?>

    <?php // echo $form->field($model, 'no_faktur_penjualan_harta_tetap') ?>

    <?php // echo $form->field($model, 'tanggal_faktur_penjualan_harta_tetap') ?>

    <?php // echo $form->field($model, 'ongkir') ?>

    <?php // echo $form->field($model, 'pajak') ?>

    <?php // echo $form->field($model, 'uang_muka') ?>

    <?php // echo $form->field($model, 'id_kas_bank') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'diskon') ?>

    <?php // echo $form->field($model, 'jenis_bayar') ?>

    <?php // echo $form->field($model, 'jumlah_tempo') ?>

    <?php // echo $form->field($model, 'tanggal_tempo') ?>

    <?php // echo $form->field($model, 'materai') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
