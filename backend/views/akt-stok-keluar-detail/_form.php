<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokKeluarDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-stok-keluar-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                                <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                                    'data' => $data_item_stok,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'qty')->textInput() ?>
                        </div>

                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-stok-keluar/view', 'id' => $model->id_stok_keluar], ['class' => 'btn btn-warning']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>