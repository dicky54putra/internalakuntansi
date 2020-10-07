<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisAlamatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-alamat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_mitra_bisnis_alamat') ?>

    <?= $form->field($model, 'id_mitra_bisnis') ?>

    <?= $form->field($model, 'keterangan_alamat') ?>

    <?= $form->field($model, 'alamat_lengkap') ?>

    <?= $form->field($model, 'id_kota') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'kode_pos') ?>

    <?php // echo $form->field($model, 'alamat_pengiriman_penagihan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
