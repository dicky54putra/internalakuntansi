<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiBomDetailBbSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-produksi-bom-detail-bb-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_produksi_bom_detail_bb') ?>

    <?= $form->field($model, 'id_produksi_bom') ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
