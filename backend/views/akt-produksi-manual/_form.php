<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktPegawai;
use backend\models\AktAkun;
use backend\models\AktMitraBisnis;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManual */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-produksi-manual-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-area-chart"></span> Produksi Manual</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'no_produksi_manual')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                            <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                            <?=
                                $form->field($model, 'id_pegawai')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(AktPegawai::find()->all(), 'id_pegawai', 'nama_pegawai'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Semua'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Pegawai');
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'id_customer')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(AktMitraBisnis::find()->where(['tipe_mitra_bisnis' => 1])->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Customer'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],

                                ])->label('Pilih Customer');
                            ?>

                            <?=
                                $form->field($model, 'id_akun')->widget(Select2::classname(), [
                                    'data' =>  $data_akun,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Akun'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Akun');
                            ?>

                            <?= $form->field($model, 'status_produksi')->hiddenInput()->label(false) ?>

                            <div class="form-group" style="margin-top:39px;">
                                <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    </div>



                    <?php ActiveForm::end(); ?>

                </div>