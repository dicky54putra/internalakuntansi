<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MenuNavigasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-navigasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_menu') ?>

    <?= $form->field($model, 'nama_menu') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'id_parent') ?>

    <?= $form->field($model, 'no_urut') ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
