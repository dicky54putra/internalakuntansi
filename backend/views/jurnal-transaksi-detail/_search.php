<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\JurnalTransaksiDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jurnal-transaksi-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_jurnal_transaksi_detail') ?>

    <?= $form->field($model, 'id_jurnal_transaksi') ?>

    <?= $form->field($model, 'tipe') ?>

    <?= $form->field($model, 'id_akun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
