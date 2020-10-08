<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaanDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-penerimaan-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pembelian_penerimaan')->textInput() ?>

    <?= $form->field($model, 'id_pembelian_detail')->textInput() ?>

    <?= $form->field($model, 'qty_diterima')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
