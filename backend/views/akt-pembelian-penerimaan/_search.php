<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-penerimaan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pembelian_penerimaan') ?>

    <?= $form->field($model, 'no_penerimaan') ?>

    <?= $form->field($model, 'tanggal_penerimaan') ?>

    <?= $form->field($model, 'penerima') ?>

    <?= $form->field($model, 'foto_resi') ?>

    <?php // echo $form->field($model, 'id_pembelian') ?>

    <?php // echo $form->field($model, 'pengantar') ?>

    <?php // echo $form->field($model, 'keterangan_pengantar') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
