<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKasBankSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-kas-bank-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_kas_bank') ?>

    <?= $form->field($model, 'kode_kas_bank') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?= $form->field($model, 'jenis') ?>

    <?= $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'saldo') ?>

    <?php // echo $form->field($model, 'total_giro_keluar') ?>

    <?php // echo $form->field($model, 'id_akun') ?>

    <?php // echo $form->field($model, 'status_aktif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
