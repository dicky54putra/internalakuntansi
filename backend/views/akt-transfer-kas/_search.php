<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferKasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-transfer-kas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_transfer_kas') ?>

    <?= $form->field($model, 'no_transfer_kas') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'id_asal_kas') ?>

    <?= $form->field($model, 'id_tujuan_kas') ?>

    <?php // echo $form->field($model, 'jumlah1') ?>

    <?php // echo $form->field($model, 'jumlah2') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
