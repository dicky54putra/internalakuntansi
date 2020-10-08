<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use backend\models\AktKota;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPegawai */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pegawai-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-user-tie"></span> Pegawai</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'kode_pegawai')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                        <?= $form->field($model, 'nama_pegawai')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'alamat')->textarea(['rows' => 5]) ?>
                        <?=
                            $form->field($model, 'id_kota')->widget(Select2::classname(), [
                                'data' => $data_kota,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Kota'],
                                'addon' => [
                                    'prepend' => [
                                        'content' => Html::button(Html::icon('plus'), [
                                            'style' => 'height:34px',
                                            'class' => 'btn btn-success', 
                                            'data-toggle' => 'modal',
                                            'data-target'=>"#modalCreateKota"
                                        ]),
                                        'asButton' => true
                                    ],
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Pilih Kota');
                        ?>
                        </div>
                        <div class="col-lg-6">
                        

                    <?= $form->field($model, 'kode_pos')->textInput() ?>

                    <?= $form->field($model, 'telepon')->textInput() ?>

                    <?= $form->field($model, 'handphone')->textInput() ?>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status_aktif')->dropDownList(array(1 => "Aktif", 0 => "Tidak Aktif")) ?>
                        </div>
                    </div>

                    

                   

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-pegawai/index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>

<!-- kota -->
<div class="modal fade" id="modalCreateKota" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Kota</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-kota/create'],
                ]); ?>
                 <?= $form->field($model_kota, 'kode_kota')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor_kota]) ?>

                <?= $form->field($model_kota, 'nama_kota')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                    
                    <?php if ($model->isNewRecord) { ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-pegawai']) ?>
                        <?php } else { ?>
                            <input type="hidden" name="id-update-pegawai" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-pegawai']) ?>
                        <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>