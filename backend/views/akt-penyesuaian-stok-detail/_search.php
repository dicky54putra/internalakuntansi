<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStokDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penyesuaian-stok-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penyesuaian_stok_detail') ?>

    <?= $form->field($model, 'id_penyesuaian_stok') ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'hpp') ?>

    <?php // echo $form->field($model, 'id_gudang') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
