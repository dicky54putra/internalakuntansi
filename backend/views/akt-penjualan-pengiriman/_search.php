<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengirimanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-pengiriman-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penjualan_pengiriman') ?>

    <?= $form->field($model, 'no_pengiriman') ?>

    <?= $form->field($model, 'tanggal_pengiriman') ?>

    <?= $form->field($model, 'pengantar') ?>

    <?= $form->field($model, 'keterangan_pengantar') ?>

    <?php // echo $form->field($model, 'foto_resi') ?>

    <?php // echo $form->field($model, 'id_penjualan') ?>

    <?php // echo $form->field($model, 'id_mitra_bisnis_alamat') ?>

    <?php // echo $form->field($model, 'penerima') ?>

    <?php // echo $form->field($model, 'keterangan_penerima') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
