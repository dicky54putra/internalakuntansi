<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemHargaJualSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-harga-jual-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item_harga_jual') ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'id_mata_uang') ?>

    <?= $form->field($model, 'id_level_harga') ?>

    <?= $form->field($model, 'harga_satuan') ?>

    <?php // echo $form->field($model, 'diskon_satuan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
