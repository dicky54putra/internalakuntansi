<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-hospital-o"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'nama_usaha')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'id_kota')->widget(Select2::classname(), [
                        'data' => $data_kota,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Kota'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>

                    <?= $form->field($model, 'telepon')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'direktur')->textInput(['maxlength' => true]) ?>

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