<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktBomSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-bom-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_bom') ?>

    <?= $form->field($model, 'no_bom') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?= $form->field($model, 'tipe') ?>

    <?= $form->field($model, 'id_item') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'status_bom') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
