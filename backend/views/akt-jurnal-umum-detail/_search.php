<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmumDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-jurnal-umum-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_jurnal_umum_detail') ?>

    <?= $form->field($model, 'id_jurnal_umum') ?>

    <?= $form->field($model, 'id_akun') ?>

    <?= $form->field($model, 'debit') ?>

    <?= $form->field($model, 'kredit') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
