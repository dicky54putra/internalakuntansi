<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengirimanDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-pengiriman-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penjualan_pengiriman_detail') ?>

    <?= $form->field($model, 'id_penjualan_pengiriman') ?>

    <?= $form->field($model, 'id_penjualan_detail') ?>

    <?= $form->field($model, 'qty_dikirim') ?>

    <?= $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
