<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Aktpembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-copy"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-grop">
                                <?= $form->field($model, 'no_penerimaan')->textInput(['readonly' => true, 'required' => 'on', 'autocomplete' => 'off']) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'tanggal_penerimaan')->widget(DateTimePicker::classname(), [
                                    'readonly' => true,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'todayBtn' => true,
                                        'todayHighlight' => true,
                                        'format' => 'yyyy-mm-dd hh:ii:ss',
                                        'defaultDate' => 'awal',
                                    ]
                                ]);
                                ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'pengantar')->textInput(['required' => 'on', 'autocomplete' => 'off']) ?>
                            </div>



                            <div class="form-grop">
                                <?= $form->field($model, 'no_spb')->textInput(['readonly' => true, 'required' => 'on', 'autocomplete' => 'off'])->label('No. Surat Penerimaan Barang') ?>
                            </div>

                        </div>
                        <div class="col-md-6">



                            <div class="form-group">
                                <?= $form->field($model, 'penerima')->textInput(['required' => true,]) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'keterangan_penerimaan')->textArea(['rows' => 7, 'height' => '10px']) ?>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['view', 'id' => $model->id_pembelian], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>