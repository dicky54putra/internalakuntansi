<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKelompokHartaTetapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-kelompok-harta-tetap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_kelompok_harta_tetap') ?>

    <?= $form->field($model, 'kode') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'umur_ekonomis') ?>

    <?= $form->field($model, 'metode_depresiasi') ?>

    <?php // echo $form->field($model, 'id_akun_harta') ?>

    <?php // echo $form->field($model, 'id_akun_akumulasi') ?>

    <?php // echo $form->field($model, 'id_akun_depresiasi') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
