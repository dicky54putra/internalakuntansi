<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokOpnameDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-stok-opname-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_stok_opname_detail') ?>

    <?= $form->field($model, 'id_stok_opname') ?>

    <?= $form->field($model, 'id_item_stok') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'qty_program') ?>

    <?php // echo $form->field($model, 'qty_selisih') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
