<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPembelianDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-retur-pembelian-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_retur_pembelian_detail') ?>

    <?= $form->field($model, 'id_retur_pembelian') ?>

    <?= $form->field($model, 'id_pembelian_detail') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'retur') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
