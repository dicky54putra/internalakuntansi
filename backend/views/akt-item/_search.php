<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'kode_item') ?>

    <?= $form->field($model, 'barcode_item') ?>

    <?= $form->field($model, 'nama_item') ?>

    <?= $form->field($model, 'nama_alias_item') ?>

    <?php // echo $form->field($model, 'id_tipe_item') ?>

    <?php // echo $form->field($model, 'id_merk') ?>

    <?php // echo $form->field($model, 'keterangan_item') ?>

    <?php // echo $form->field($model, 'status_aktif_item') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
