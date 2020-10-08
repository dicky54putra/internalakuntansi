<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Login */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
    <div class="box-header">
        <div class="col-md-4" style="padding: 0;">
            <div class="box-body">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                <?php

                $model->password = "";
                echo $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                <?php
                if ($model->isNewRecord) {
                    # code...
                ?>
                    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
                <?php
                } else {
                    # code...
                ?>
                    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'readonly' => false]) ?>
                <?php
                }

                ?>

                <?= $form->field($model, 'foto')->fileInput() ?>

                <?php
                if ($model->foto != "") {
                    echo "<img src='upload/$model->foto' width='150'>";
                }
                ?>

                <div class="form-group"><br>
                    <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                    <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-floppy-disk"></span> Simpan' : '<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>