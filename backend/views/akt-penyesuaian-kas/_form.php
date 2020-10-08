<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktMitraBisnis;
use backend\models\AktAkun;
use backend\models\AktKasBank;
use backend\models\AktMataUang;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianKas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penyesuaian-kas-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-tasks"></span> Daftar Penyesuaian Kas</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'no_transaksi')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                    <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]) ?>

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

                    <?=
                        $form->field($model, 'id_mitra_bisnis')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktMitraBisnis::find()->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Mitra Bisnis'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Mitra Bisnis');
                    ?>

                    <?= $form->field($model, 'no_referensi')->textInput(['maxlength' => true]) ?>

                    <?=
                        $form->field($model, 'id_kas_bank')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktKasBank::find()->all(), 'id_kas_bank', 'kode_kas_bank'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Kas/Bank'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Kas/Bank');
                    ?>
                    <?=
                        $form->field($model, 'id_mata_uang')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktMataUang::find()->all(), 'id_mata_uang', 'mata_uang'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Mata Uang'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Mata Uang');
                    ?>

                    <?= $form->field($model, 'jumlah')->textInput() ?>

                    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>