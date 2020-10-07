<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_mitra_bisnis') ?>

    <?= $form->field($model, 'kode_mitra_bisnis') ?>

    <?= $form->field($model, 'deskripsi_mitra_bisnis') ?>

    <?= $form->field($model, 'tipe_mitra_bisnis') ?>

    <?= $form->field($model, 'id_gmb_satu') ?>

    <?php // echo $form->field($model, 'id_gmb_dua') ?>

    <?php // echo $form->field($model, 'id_gmb_tiga') ?>

    <?php // echo $form->field($model, 'id_level_harga') ?>

    <?php // echo $form->field($model, 'id_sales') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
