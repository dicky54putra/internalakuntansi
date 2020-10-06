<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktAkun;
use backend\models\AktMataUang;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisPembelianPenjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-pembelian-penjualan-form">
<div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_mitra_bisnis')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

    <?=
       $form->field($model, 'id_mata_uang')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(AktMataUang::find()->all(), 'id_mata_uang','mata_uang'
        ),
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih Mata Uang'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Pilih Mata Uang');
    ?>

    <?= $form->field($model, 'termin_pembelian')->dropDownList(array(1 => "Cash", 2 => "Credit")) ?>

    <?= $form->field($model, 'tempo_pembelian')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'termin_penjualan')->dropDownList(array(1 => "Cash", 2 => "Credit")) ?>

    <?= $form->field($model, 'tempo_penjualan')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'batas_hutang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'batas_frekuensi_hutang')->textInput(['maxlength' => true]) ?>

    <?=
       $form->field($model, 'id_akun_hutang')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(AktAkun::find()->all(), 'id_akun','nama_akun'
        ),
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih Akun Hutang'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Pilih Akun Hutang');
    ?>

    <?= $form->field($model, 'batas_piutang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'batas_frekuensi_piutang')->textInput(['maxlength' => true]) ?>

    <?=
       $form->field($model, 'id_akun_piutang')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(AktAkun::find()->all(), 'id_akun','nama_akun'
        ),
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih Akun Piutang'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Pilih Akun Piutang');
    ?>

    <div class="form-group">
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>