<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktLevelHarga;
use backend\models\AktSales;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnis */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-users"></span> Mitra Bisnis</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'kode_mitra_bisnis')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                            <?= $form->field($model, 'pemilik_bisnis')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'nama_mitra_bisnis')->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'tipe_mitra_bisnis')->dropDownList(array(1 => "Customer", 2 => "Supplier", 3 => "Customer & Supplier")) ?>

                            <?= $form->field($model, 'status_mitra_bisnis')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>

                            <?= $form->field($model, 'deskripsi_mitra_bisnis')->textarea(['rows' => 1]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>