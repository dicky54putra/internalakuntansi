<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Pengaturan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pengaturan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_pengaturan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
