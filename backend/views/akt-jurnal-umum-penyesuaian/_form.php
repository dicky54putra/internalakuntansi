<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-jurnal-umum-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-book"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'no_jurnal_umum')->textInput(['readonly' => true]) ?>

                    <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]) ?>

                    <?= $form->field($model, 'tipe')->dropDownList(
                        array(
                            2 => 'Jurnal Penyesuaian',
                        )
                    ) ?>

                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_jurnal_umum];
                        }

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