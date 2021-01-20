<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-permintaan-barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_permintaan_barang') ?>

    <?= $form->field($model, 'nomor_permintaan') ?>

    <?= $form->field($model, 'tanggal_permintaan') ?>

    <?= $form->field($model, 'status_aktif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
