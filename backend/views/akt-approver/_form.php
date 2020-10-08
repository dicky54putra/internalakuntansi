<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\AktJenisApprover;
/* @var $this yii\web\View */
/* @var $model backend\models\AktApprover */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-approver-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-users"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_login')->widget(Select2::classname(), [
                        'data' => $data_login,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Akun Login'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>
                    <?php if ($model->isNewRecord) { ?>
                        <?= $form->field($model, 'id_jenis_approver')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktJenisApprover::find()->all(), 'id_jenis_approver', 'nama_jenis_approver'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Jenis Approver'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])
                        ?>
                    <?php } else { ?>
                        <?= $form->field($model, 'id_jenis_approver')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktJenisApprover::find()->all(), 'id_jenis_approver', 'nama_jenis_approver'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Jenis Approver',],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'disabled' => true
                        ])
                        ?>
                    <?php } ?>

                    <?= $form->field($model, 'tingkat_approver')->dropDownList(array(1 => "Approver 1", 2 => "Approver 2", 3 => "Approver 3"), ['prompt' => 'Pilih Approver']) ?>

                    <div class="form-group">
                        <?php
                        // if ($model->isNewRecord) {
                        //     # code...
                        $url = ['index'];
                        // } else {
                        //     # code...
                        //     $url = ['view', 'id' => $model->id_approver];
                        // }

                        ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>