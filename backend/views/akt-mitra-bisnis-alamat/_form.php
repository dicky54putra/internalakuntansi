<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use backend\models\AktKota;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisAlamat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-mitra-bisnis-alamat-form">
<div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'keterangan_alamat')->textInput() ?>

        <?= $form->field($model, 'alamat_lengkap')->textarea(['rows' => 5]) ?>

        <?=
        $form->field($model, 'id_kota')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AktKota::find()->all(), 'id_kota','nama_kota'
            ),
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Kota'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
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
            ])->label('Pilih Kota');
        ?>
    </div>
    <div class="col-md-6">
         <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'kode_pos')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alamat_pengiriman_penagihan')->dropDownList(array(1 => "Pengiriman", 2 => "Penagihan", 3 => "Pengiriman & Penagihan")) ?>
    </div>
</div>
   


    

    <div class="form-group">
    <?= $form->field($model, 'id_mitra_bisnis')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<!-- Satuan -->
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
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-item']) ?>
                        <?php } else { ?>
                            <input type="hidden" name="id-update-alamat" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-item']) ?>
                        <?php } ?>
                    
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>