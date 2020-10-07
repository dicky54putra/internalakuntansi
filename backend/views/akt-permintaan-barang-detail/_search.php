<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-permintaan-barang-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_permintaan_barang_detail') ?>

    <?= $form->field($model, 'id_permintaan_barang') ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'qty') ?>

    <?= $form->field($model, 'qty_ordered') ?>

    <?php // echo $form->field($model, 'qty_rejected') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'request_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
