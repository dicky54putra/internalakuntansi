<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-penerimaan-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-product-form',
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'no_penerimaan')->textInput(['maxlength' => true, 'readonly' => true]) ?>

            <?= $form->field($model, 'tanggal_penerimaan')->textInput(['type' => 'date', 'value' => date('Y-m-d')]) ?>

            <?= $form->field($model, 'penerima')->textInput(['maxlength' => true,]) ?>

            <?= $form->field($model, 'foto_resi')->fileInput(['class' => '']) ?>

            <?php
            if ($model->foto_resi != "") {
                echo "<img src='upload/$model->foto_resi' width='150'><br>";
            }
            ?>
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'pengantar')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'keterangan_pengantar')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'id_pembelian')->textInput(['value' => $model_pembelian->id_pembelian, 'type' => 'hidden'])->label(false) ?>
            <?= $form->field($model, 'id_pembelian_penerimaan')->textInput(['value' => $model->id_pembelian_penerimaan, 'type' => 'hidden'])->label(false) ?>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'style' => ['float' => 'right']]) ?>
        &nbsp;
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
    </div>
    <?php ActiveForm::end(); ?>

</div>