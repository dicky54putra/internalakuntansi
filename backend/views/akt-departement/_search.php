<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktDepartementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-departement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_departement') ?>

    <?= $form->field($model, 'kode_departement') ?>

    <?= $form->field($model, 'nama_departement') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?= $form->field($model, 'status_aktif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
