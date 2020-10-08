<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktKota;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenagih */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penagih-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-address-book"></span> Penagih</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'kode_penagih')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

<?= $form->field($model, 'nama_penagih')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'alamat')->textarea(['rows' => 5]) ?>

<?= $form->field($model, 'id_kota')->dropDownList(
    ArrayHelper::map(
        AktKota::find()->all(),
        'id_kota',
        function ($model) {
            return $model['kode_kota'] . ' - ' . $model['nama_kota'];
        }
    ),
    [
        'prompt' => 'Pilih Kota ',
    ]
)->label('Kota'); ?>
                        </div>
                        <div class="col-lg-6">
                        <?= $form->field($model, 'kode_pos')->textInput() ?>

<?= $form->field($model, 'telepon')->textInput() ?>

<?= $form->field($model, 'handphone')->textInput() ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'status_aktif')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>
                        </div>
                    </div>
                    

                  

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-penagih/index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>