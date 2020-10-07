<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiayaDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pengajuan-biaya-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-book"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_pengajuan_biaya')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                    <?= $form->field($model, 'id_akun')->widget(Select2::classname(), [
                        'data' => $data_akun,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Akun'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>

                    <?= $form->field($model, 'kode_rekening')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'nama_pengajuan')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'debit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>

                    <?= $form->field($model, 'kredit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-pengajuan-biaya/view', 'id' => $model->id_pengajuan_biaya], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>