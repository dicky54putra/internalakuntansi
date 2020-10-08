<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembayaranBiaya */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembayaran-biaya-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tanggal_pembayaran_biaya')->textInput() ?>

    <?= $form->field($model, 'id_pembelian')->textInput() ?>

    <?= $form->field($model, 'cara_bayar')->textInput() ?>

    <?= $form->field($model, 'id_kas_bank')->textInput() ?>

    <?= $form->field($model, 'nominal')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
