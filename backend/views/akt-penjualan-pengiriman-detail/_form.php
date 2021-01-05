<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengirimanDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-pengiriman-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_penjualan_pengiriman')->textInput() ?>

    <?= $form->field($model, 'id_penjualan_detail')->textInput() ?>

    <?= $form->field($model, 'qty_dikirim')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
