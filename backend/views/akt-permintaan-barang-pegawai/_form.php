<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangPegawai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-permintaan-barang-pegawai-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_permintaan_barang')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                    <?= $form->field($model, 'id_pegawai')->widget(Select2::classname(), [
                	        'data' => $data_pegawai,
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Pegawai'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Pegawai');
                    ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
