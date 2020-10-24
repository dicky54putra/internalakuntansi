<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalKas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-saldo-awal-kas-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-bank"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'no_transaksi')->textInput(['readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_transaksi')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                            <?= $form->field($model, 'id_kas_bank')->widget(Select2::classname(), [
                                'data' => $data_kas_bank,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Kas/Bank'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'jumlah')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 5]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_saldo_awal_kas];
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