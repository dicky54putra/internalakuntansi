<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferStokSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-transfer-stok-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_transfer_stok') ?>

    <?= $form->field($model, 'no_transfer') ?>

    <?= $form->field($model, 'tanggal_transfer') ?>

    <?= $form->field($model, 'id_gudang_asal') ?>

    <?= $form->field($model, 'id_gudang_tujuan') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
