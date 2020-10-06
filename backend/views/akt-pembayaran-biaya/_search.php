<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembayaranBiayaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembayaran-biaya-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pembayaran_biaya') ?>

    <?= $form->field($model, 'tanggal_pembayaran_biaya') ?>

    <?= $form->field($model, 'id_pembelian') ?>

    <?= $form->field($model, 'cara_bayar') ?>

    <?= $form->field($model, 'id_kas_bank') ?>

    <?php // echo $form->field($model, 'nominal') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
