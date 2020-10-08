<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktMataUang;
use backend\models\AktMitraBisnis;
use backend\models\AktKasBank;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\AktCekGiro */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-cek-giro-form">
<div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-list-alt"></span> Daftar Cek/Giro</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_transaksi')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

    <?= $form->field($model, 'no_cek_giro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_terbit')->widget(\yii\jui\DatePicker::classname(), [
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>

<?= $form->field($model, 'tanggal_effektif')->widget(\yii\jui\DatePicker::classname(), [
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>

<?= $form->field($model, 'tipe')->dropDownList(array(1 => "Cheque", 2 => "Giro")) ?>


<?= $form->field($model, 'in_out')->dropDownList(array(1 => "In", 2 => "Out")) ?>


<?=
        $form->field($model, 'id_bank_asal')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AktKasBank::find()->all(), 'id_kas_bank', 'keterangan'),
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih Bank Asal'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Pilih Bank Asal');
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

    <?= $form->field($model, 'cabang_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_kliring')->widget(\yii\jui\DatePicker::classname(), [
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>

    <?= $form->field($model, 'bank_kliring')->textInput(['maxlength' => true]) ?>

    <?=
        $form->field($model, 'id_penerbit')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AktMitraBisnis::find()->where(['tipe_mitra_bisnis' => 1 ])->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis'),
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih Penerbit'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Pilih Penerbit');
    ?>

<?=
        $form->field($model, 'id_penerima')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AktMitraBisnis::find()->where(['tipe_mitra_bisnis' => 2 ])->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis'),
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih Penerima'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Pilih Penerima');
    ?>

    <div class="form-group" style="margin-top:50px;">
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
