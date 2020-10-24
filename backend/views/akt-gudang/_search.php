<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktGudangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-gudang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_gudang') ?>

    <?= $form->field($model, 'kode_gudang') ?>

    <?= $form->field($model, 'nama_gudang') ?>

    <?= $form->field($model, 'status_aktif_gudang') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
