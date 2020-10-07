<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiayaDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pengajuan-biaya-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pengajuan_biaya_detail') ?>

    <?= $form->field($model, 'id_pengajuan') ?>

    <?= $form->field($model, 'id_akun') ?>

    <?= $form->field($model, 'kode_rekening') ?>

    <?= $form->field($model, 'nama_pengajuan') ?>

    <?php // echo $form->field($model, 'debit') ?>

    <?php // echo $form->field($model, 'kredit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
