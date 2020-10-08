<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangPegawaiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-permintaan-barang-pegawai-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_permintaan_barang_pegawai') ?>

    <?= $form->field($model, 'id_permintaan_barang') ?>

    <?= $form->field($model, 'id_pegawai') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
