<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetapDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-harta-tetap-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penjualan_harta_tetap_detail') ?>

    <?= $form->field($model, 'id_penjualan_harta_tetap') ?>

    <?= $form->field($model, 'id_item_stok') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'harga') ?>

    <?php // echo $form->field($model, 'diskon') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
