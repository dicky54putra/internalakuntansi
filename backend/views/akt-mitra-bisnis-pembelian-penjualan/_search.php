<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisPembelianPenjualanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-pembelian-penjualan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_mitra_bisnis_pembelian_penjualan') ?>

    <?= $form->field($model, 'id_mitra_bisnis') ?>

    <?= $form->field($model, 'id_mata_uang') ?>

    <?= $form->field($model, 'termin_pembelian') ?>

    <?= $form->field($model, 'tempo_pembelian') ?>

    <?php // echo $form->field($model, 'termin_penjualan') ?>

    <?php // echo $form->field($model, 'tempo_penjualan') ?>

    <?php // echo $form->field($model, 'batas_hutang') ?>

    <?php // echo $form->field($model, 'batas_frekuensi_hutang') ?>

    <?php // echo $form->field($model, 'id_akun_hutang') ?>

    <?php // echo $form->field($model, 'batas_piutang') ?>

    <?php // echo $form->field($model, 'batas_frekuensi_piutang') ?>

    <?php // echo $form->field($model, 'id_akun_piutang') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
