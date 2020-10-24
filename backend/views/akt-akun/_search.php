<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktAkunSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-akun-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_akun') ?>

    <?= $form->field($model, 'kode_akun') ?>

    <?= $form->field($model, 'nama_akun') ?>

    <?= $form->field($model, 'saldo_akun') ?>

    <?= $form->field($model, 'header') ?>

    <?php // echo $form->field($model, 'parent') ?>

    <?php // echo $form->field($model, 'jenis') ?>

    <?php // echo $form->field($model, 'klasifikasi') ?>

    <?php // echo $form->field($model, 'status_aktif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
