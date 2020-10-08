<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferStokDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-transfer-stok-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                                <?= $form->field($model, 'id_item')->widget(Select2::classname(), [
                                'data' => $data_item,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Barang', 'required' => 'required'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>

                            <?= $form->field($model, 'qty')->textInput() ?>
                        </div>
                        <div class="col-md-6">
                        <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-transfer-stok/view', 'id' => $model->id_transfer_stok], ['class' => 'btn btn-warning']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>