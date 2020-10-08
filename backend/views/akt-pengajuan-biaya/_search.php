<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiayaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pengajuan-biaya-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pengajuan') ?>

    <?= $form->field($model, 'nomor_pengajuan_biaya') ?>

    <?= $form->field($model, 'tanggal_pengajuan') ?>

    <?= $form->field($model, 'nomor_purchasing_order') ?>

    <?= $form->field($model, 'nomor_kendaraan') ?>

    <?php // echo $form->field($model, 'volume') ?>

    <?php // echo $form->field($model, 'keterangan_pengajuan') ?>

    <?php // echo $form->field($model, 'dibuat_oleh') ?>

    <?php // echo $form->field($model, 'jenis_bayar') ?>

    <?php // echo $form->field($model, 'dibayar_oleh') ?>

    <?php // echo $form->field($model, 'dibayar_kepada') ?>

    <?php // echo $form->field($model, 'alamat_dibayar_kepada') ?>

    <?php // echo $form->field($model, 'approver1') ?>

    <?php // echo $form->field($model, 'approver2') ?>

    <?php // echo $form->field($model, 'approver3') ?>

    <?php // echo $form->field($model, 'approver1_date') ?>

    <?php // echo $form->field($model, 'approver2_date') ?>

    <?php // echo $form->field($model, 'approver3_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'alasan_reject') ?>

    <?php // echo $form->field($model, 'tanggal_jatuh_tempo') ?>

    <?php // echo $form->field($model, 'sumber_dana') ?>

    <?php // echo $form->field($model, 'status_pembayaran') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
