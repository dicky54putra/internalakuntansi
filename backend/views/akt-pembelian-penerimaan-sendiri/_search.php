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

    <?= $form->field($model, 'id_penjualan') ?>

    <?= $form->field($model, 'no_pengiriman') ?>

    <?= $form->field($model, 'tanggal_pengiriman') ?>

    <?= $form->field($model, 'pengantar') ?>

    <?php // echo $form->field($model, 'penerima') ?>

    <?php // echo $form->field($model, 'keterangan_pengiriman') ?>

    <?php // echo $form->field($model, 'tanggal_penerimaan') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
