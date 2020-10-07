<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManualDetailBbSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-produksi-manual-detail-bb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_produksi_manual_detail_bb') ?>

    <?= $form->field($model, 'id_produksi_manual') ?>

    <?= $form->field($model, 'id_item_stok') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
