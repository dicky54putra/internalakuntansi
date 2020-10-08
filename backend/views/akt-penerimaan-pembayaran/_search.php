<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaranSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penerimaan-pembayaran-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penerimaan_pembayaran_penjualan') ?>

    <?= $form->field($model, 'tanggal_penerimaan_pembayaran') ?>

    <?= $form->field($model, 'jenis_penerimaan') ?>

    <?= $form->field($model, 'id_penjualan') ?>

    <?= $form->field($model, 'cara_bayar') ?>

    <?php // echo $form->field($model, 'id_kas_bank') ?>

    <?php // echo $form->field($model, 'nominal') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
