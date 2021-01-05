<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemOrderPembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-order-pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item_order_pembelian') ?>

    <?= $form->field($model, 'id_order_pembelian') ?>

    <?= $form->field($model, 'id_item_stok') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'id_satuan') ?>

    <?php // echo $form->field($model, 'harga') ?>

    <?php // echo $form->field($model, 'diskon') ?>

    <?php // echo $form->field($model, 'qty_terkirim') ?>

    <?php // echo $form->field($model, 'qty_back_order') ?>

    <?php // echo $form->field($model, 'id_departement') ?>

    <?php // echo $form->field($model, 'id_proyek') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'req_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
