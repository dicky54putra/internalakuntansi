<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokKeluarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-stok-keluar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_stok_keluar') ?>

    <?= $form->field($model, 'nomor_transaksi') ?>

    <?= $form->field($model, 'tanggal_keluar') ?>

    <?= $form->field($model, 'tipe') ?>

    <?= $form->field($model, 'metode') ?>

    <?php // echo $form->field($model, 'id_akun_persediaan') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
