<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStokSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penyesuaian-stok-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_penyesuaian_stok') ?>

    <?= $form->field($model, 'no_transaksi') ?>

    <?= $form->field($model, 'tanggal_penyesuaian') ?>

    <?= $form->field($model, 'tipe_penyesuaian') ?>

    <?= $form->field($model, 'metode') ?>

    <?php // echo $form->field($model, 'id_akun_persediaan') ?>

    <?php // echo $form->field($model, 'keterangan_penyesuaian') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
