<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AktMataUang;
use backend\models\AktAkun;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKasBank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-kas-bank-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-building"></span> Kas Bank</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'kode_kas_bank')->textInput(['value' => $nomor, 'readonly' => true]) ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 4]) ?>

                            <?= $form->field($model, 'jenis')->dropDownList(array(1 => 'CASH', 2 => 'BANK'))->label('Jenis') ?>
                            <?= $form->field($model, 'id_mata_uang')->dropDownList(
                                ArrayHelper::map(
                                    AktMataUang::find()->all(),
                                    'id_mata_uang',
                                    function ($model) {
                                        return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
                                    }
                                ),
                                [
                                    'prompt' => 'Pilih Mata Uang ',
                                ]
                            )->label('Mata Uang'); ?>
                        </div>
                        <div class="col-lg-6">


                            <?= $form->field($model, 'saldo')->textInput(['readonly' => true]) ?>

                            <?= $form->field($model, 'total_giro_keluar')->textInput(['readonly' => true, 'value' => 0]) ?>

                            <?= $form->field($model, 'id_akun')->dropDownList(
                                ArrayHelper::map(
                                    AktAkun::find()->where("klasifikasi IN (1,2)")->all(),
                                    'id_akun',
                                    function ($model) {
                                        return $model['kode_akun'] . ' - ' . $model['nama_akun'];
                                    }
                                ),
                                [
                                    'prompt' => 'Pilih Akun',
                                ]
                            )->label('Akun'); ?>

                            <?= $form->field($model, 'status_aktif')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif'))->label('Status') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>