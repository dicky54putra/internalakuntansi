<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanPembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-permintaan-pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_permintaan_pembelian') ?>

    <?= $form->field($model, 'no_permintaan') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'id_pegawai') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'id_cabang') ?>

    <?php // echo $form->field($model, 'draft') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
