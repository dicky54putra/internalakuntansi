<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProyekSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-proyek-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_proyek') ?>

    <?= $form->field($model, 'kode_proyek') ?>

    <?= $form->field($model, 'nama_proyek') ?>

    <?= $form->field($model, 'id_pegawai') ?>

    <?= $form->field($model, 'id_mitra_bisnis') ?>

    <?php // echo $form->field($model, 'status_aktif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
