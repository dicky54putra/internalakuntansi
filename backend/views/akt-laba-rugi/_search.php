<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktLabaRugiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-laba-rugi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_laba_rugi') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'periode') ?>

    <?= $form->field($model, 'id_login') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
