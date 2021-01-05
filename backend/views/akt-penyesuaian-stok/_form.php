<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStok */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penyesuaian-stok-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'no_transaksi')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_penyesuaian')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                            <?= $form->field($model, 'tipe_penyesuaian')->dropDownList(array(1 => "Penambahan Stok", 0 => "Pengurangan Stok")) ?>

                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'keterangan_penyesuaian')->textarea(['rows' => 6]) ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_penyesuaian_stok];
                        }

                        ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>