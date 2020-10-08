<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalAkunDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-saldo-awal-akun-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_saldo_awal_akun_detail') ?>

    <?= $form->field($model, 'id_saldo_awal_akun') ?>

    <?= $form->field($model, 'id_akun') ?>

    <?= $form->field($model, 'debet') ?>

    <?= $form->field($model, 'kredit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
