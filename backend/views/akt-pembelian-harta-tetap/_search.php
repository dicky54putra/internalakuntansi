<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianHartaTetapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-harta-tetap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pembelian_harta_tetap') ?>

    <?= $form->field($model, 'no_pembelian_harta_tetap') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'termin') ?>

    <?= $form->field($model, 'id_kas_bank') ?>

    <?php // echo $form->field($model, 'jumlah_hari') ?>

    <?php // echo $form->field($model, 'tanggal_selesai') ?>

    <?php // echo $form->field($model, 'id_supplier') ?>

    <?php // echo $form->field($model, 'id_mata_uang') ?>

    <?php // echo $form->field($model, 'status_pajak') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'id_cabang') ?>

    <?php // echo $form->field($model, 'draft') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
