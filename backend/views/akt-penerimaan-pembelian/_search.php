<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penerimaan-pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penerimaan_pembelian') ?>

    <?= $form->field($model, 'no_penerimaan') ?>

    <?= $form->field($model, 'no_ref') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'id_supplier') ?>

    <?php // echo $form->field($model, 'id_penerima') ?>

    <?php // echo $form->field($model, 'status_invoiced') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'id_cabang') ?>

    <?php // echo $form->field($model, 'draft') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
