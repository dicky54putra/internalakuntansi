<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktGudang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-gudang-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-home"></span> Gudang</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'kode_gudang')->textInput(['readonly' => true, 'value' => $nomor]) ?>

                    <?= $form->field($model, 'nama_gudang')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status_aktif_gudang')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif')) ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>