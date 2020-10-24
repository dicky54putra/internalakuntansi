<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPembelianHartaTetapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-pembelian-harta-tetap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item_pembelian_harta_tetap') ?>

    <?= $form->field($model, 'id_pembelian_harta_tetap') ?>

    <?= $form->field($model, 'id_harta_tetap') ?>

    <?= $form->field($model, 'harga') ?>

    <?= $form->field($model, 'diskon') ?>

    <?php // echo $form->field($model, 'pajak') ?>

    <?php // echo $form->field($model, 'lokasi') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
