<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManualSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-produksi-manual-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_produksi_manual') ?>

    <?= $form->field($model, 'no_produksi_manual') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'id_pegawai') ?>

    <?= $form->field($model, 'id_customer') ?>

    <?php // echo $form->field($model, 'id_akun') ?>

    <?php // echo $form->field($model, 'status_produksi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
