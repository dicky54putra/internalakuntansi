<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSalesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-sales-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_sales') ?>

    <?= $form->field($model, 'kode_sales') ?>

    <?= $form->field($model, 'nama_sales') ?>

    <?= $form->field($model, 'alamat') ?>

    <?= $form->field($model, 'id_kota') ?>

    <?php // echo $form->field($model, 'kode_pos') ?>

    <?php // echo $form->field($model, 'telepon') ?>

    <?php // echo $form->field($model, 'handphone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status_aktif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
