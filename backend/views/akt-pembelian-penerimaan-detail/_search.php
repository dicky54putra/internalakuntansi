<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaanDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-penerimaan-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pembelian_penerimaan_detail') ?>

    <?= $form->field($model, 'id_pembelian_penerimaan') ?>

    <?= $form->field($model, 'id_pembelian_detail') ?>

    <?= $form->field($model, 'qty_diterima') ?>

    <?= $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
