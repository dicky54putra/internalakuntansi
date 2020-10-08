<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokOpnameSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-stok-opname-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_stok_opname') ?>

    <?= $form->field($model, 'no_transaksi') ?>

    <?= $form->field($model, 'tanggal_opname') ?>

    <?= $form->field($model, 'id_pegawai') ?>

    <?= $form->field($model, 'id_akun_persediaan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
