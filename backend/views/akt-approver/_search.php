<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktApproverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-approver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_approver') ?>

    <?= $form->field($model, 'id_login') ?>

    <?= $form->field($model, 'jenis_approver') ?>

    <?= $form->field($model, 'tingkat_approver') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
