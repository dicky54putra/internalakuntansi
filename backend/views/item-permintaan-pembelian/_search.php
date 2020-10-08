<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPermintaanPembelianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-permintaan-pembelian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_item_permintaan_pembelian') ?>

    <?= $form->field($model, 'id_permintaan_pembelian') ?>

    <?= $form->field($model, 'id_item') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'satuan') ?>

    <?php // echo $form->field($model, 'id_departement') ?>

    <?php // echo $form->field($model, 'id_proyek') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'req_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
