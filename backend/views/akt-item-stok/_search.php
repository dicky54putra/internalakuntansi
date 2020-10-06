<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemStokSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-stok-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item_stok') ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'id_gudang') ?>

    <?= $form->field($model, 'location') ?>

    <?= $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'hpp') ?>

    <?php // echo $form->field($model, 'min') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
