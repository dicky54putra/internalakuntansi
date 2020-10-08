<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Arrayhelper;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktKota;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-pengiriman-form">

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
            <?= $form->field($model, 'penerima')->textInput(['required' => true]) ?>

            <?= $form->field($model, 'tanggal_penerimaan')->widget(\yii\jui\DatePicker::classname(), [
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control', 'required' => true]
            ]) ?>

            <?= $form->field($model, 'status')->dropDownList(array(1 => 'Terkirim')) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'keterangan_penerima')->textarea(['rows' => 9]) ?>
        </div>
    </div>
    <br>

    <div class="form-group">
        <?php
        $nama_button = "Simpan";
        if ($model->isNewRecord) {
            # code...
            $nama_button = "Tambah";
        }
        ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> ' . $nama_button . '', ['class' => 'btn btn-success', 'style' => ['float' => 'right']]) ?>
        &nbsp;
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>