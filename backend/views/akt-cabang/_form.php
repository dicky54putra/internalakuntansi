<?php

use backend\models\AktMitraBisnis;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCabang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-cabang-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-flag-checkered"></span> Daftar Cabang</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'kode_cabang')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

<?= $form->field($model, 'nama_cabang')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'nama_cabang_perusahaan')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'alamat')->textarea(['rows' => 5]) ?>
                        </div>
                        <div class="col-lg-6">
                        <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'pkp')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    

                   

                    <?php //$form->field($model, 'id_customer')->dropDownList(
                    //     ArrayHelper::map(
                    //         AktMitraBisnis::find()->where('tipe_mitra_bisnis IN (1,3)')->all(),
                    //         'id_mitra_bisnis',
                    //         function ($model) {
                    //             return  $model['nama_mitra_bisnis'];
                    //         }
                    //     ),
                    //     [
                    //         'prompt' => 'Pilih Customer ',
                    //     ]
                    // )->label('Default Customer') 
                    ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>