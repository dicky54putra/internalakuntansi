<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penerimaan-pembayaran-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-money-check-alt"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'tanggal_penerimaan_pembayaran')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control', 'autocomplete' => 'off']
                            ]) ?>

                            <?= $form->field($model, 'id_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                            <?= $form->field($model, 'cara_bayar')->dropDownList(
                                array(
                                    1 => "Tunai",
                                    2 => "Transfer",
                                    3 => "Giro"
                                ),
                                ['prompt' => 'Pilih Cara Bayar']
                            ) ?>

                            <?= $form->field($model, 'id_kas_bank')->widget(Select2::classname(), [
                                'data' => $data_kas_bank,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Kas Bank'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>

                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'nominal')->widget(
                                \yii\widgets\MaskedInput::className(),
                                [
                                    'options' => ['autocomplete' => 'off'],
                                    'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]
                                ]
                            ); ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 4]) ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['view-penerimaan-pembayaran', 'id' => $model->id_penjualan], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>