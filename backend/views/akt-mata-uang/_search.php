<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMataUangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mata-uang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_mata_uang') ?>

    <?= $form->field($model, 'mata_uang') ?>

    <?= $form->field($model, 'simbol') ?>

    <?= $form->field($model, 'kurs') ?>

    <?= $form->field($model, 'fiskal') ?>

    <?php // echo $form->field($model, 'rate_type') ?>

    <?php // echo $form->field($model, 'status_default') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
