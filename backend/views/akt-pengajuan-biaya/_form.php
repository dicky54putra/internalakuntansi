<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiaya */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pengajuan-biaya-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-book"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'nomor_pengajuan_biaya')->textInput(['readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_pengajuan')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                            <?= $form->field($model, 'nomor_purchasing_order')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'nomor_kendaraan')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'volume')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'keterangan_pengajuan')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'dibuat_oleh')->textInput(['type' => 'hidden'])->label(FALSE) ?>

                            <?= $form->field($model, 'jenis_bayar')->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'dibayar_oleh')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'dibayar_kepada')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'alamat_dibayar_kepada')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'approver1')->textInput(['type' => 'hidden'])->label(FALSE) ?>

                            <?= $form->field($model, 'approver2')->textInput(['type' => 'hidden'])->label(FALSE) ?>

                            <?= $form->field($model, 'approver3')->textInput(['type' => 'hidden'])->label(FALSE) ?>

                            <?php
                            if ($model->isNewRecord) {
                                # code...
                            ?>
                                <?= $form->field($model, 'approver1_date')->textInput(['type' => 'hidden'])->label(FALSE) ?>

                                <?= $form->field($model, 'approver2_date')->textInput(['type' => 'hidden'])->label(FALSE) ?>

                                <?= $form->field($model, 'approver3_date')->textInput(['type' => 'hidden'])->label(FALSE) ?>

                                <?= $form->field($model, 'status')->dropDownList(array(0 => "Belum Disetujui")) ?>
                            <?php
                            } else {
                                # code...
                            }

                            ?>

                            <?= $form->field($model, 'tanggal_jatuh_tempo')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                            <?= $form->field($model, 'sumber_dana')->dropDownList(array(1 => "Kas Kecil Tanjung", 2 => "Bank")) ?>

                            <?php
                            if ($model->isNewRecord) {
                                # code...
                            ?>
                                <?= $form->field($model, 'status_pembayaran')->dropDownList(array(1 => "Belum Dibayar")) ?>
                            <?php
                            } else {
                                # code...
                            }

                            ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_pengajuan_biaya];
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