<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalStokiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-saldo-awal-stok-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_saldo_awal_stok') ?>

    <?= $form->field($model, 'no_transaksi') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'tipe') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
