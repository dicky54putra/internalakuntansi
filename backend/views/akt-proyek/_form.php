<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AktPegawai;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProyek */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-proyek-form">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-gavel"></span> Data Proyek</div>
    <div class="panel-body">
        <div class="col-md-12" style="padding: 0;">
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_proyek')->textInput(['value' => $nomor, 'readonly' =>true]) ?>

    <?= $form->field($model, 'nama_proyek')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_pegawai')->dropDownList(
        ArrayHelper::map(
            AktPegawai::find()->all(),
            'id_pegawai',
            function ($model) {
                return $model['nama_pegawai'];
            }
        ),
        [
            'prompt' => 'Pilih Pegawai ',
        ]
    )->label('Pegawai'); ?>

    <?= $form->field($model, 'id_mitra_bisnis')->textInput() ?>

    <?= $form->field($model, 'status_aktif')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif'))?>
    <div class="form-group">
	    	<?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-proyek/index'], ['class' => 'btn btn-warning']) ?>
	        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>
