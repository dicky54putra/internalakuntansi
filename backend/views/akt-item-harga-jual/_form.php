<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktItemHargaJual */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-harga-jual-form">
    <div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_item')->textInput(['readonly' => true, 'type' => 'hidden', 'value' => $id_item])->label(FALSE) ?>

                    <?=
                        $form->field($model, 'id_mata_uang')->widget(Select2::classname(), [
                            'data' => $data_mata_uang,
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Mata Uang'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Mata Uang');
                    ?>
                    
                    <?=
                        $form->field($model, 'id_level_harga')->widget(Select2::classname(), [
                            'data' => $data_level_harga,
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Level Harga'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'addon' => [
                                'prepend' => [
                                    'content' => Html::button(Html::icon('plus'), [
                                        'style' => 'height:34px',
                                        'class' => 'btn btn-success', 
                                        'data-toggle' => 'modal',
                                        'data-target'=>"#modalCreateLevelHarga"
                                    ]),
                                    'asButton' => true
                                ],
                            ],
                        ])->label('Pilih Level Harga');
                    ?>

                   
                    <?= $form->field($model, 'harga_satuan')->widget(\yii\widgets\MaskedInput::className(), [
                                                        'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                                        'options' => ['required' => true]
                                                    ]); ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-item/view', 'id' => $id_item], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>



<!-- level harga -->
<div class="modal fade" id="modalCreateLevelHarga" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Level Harga</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-level-harga/create'],
                ]); ?>
                <?= $form->field($model_level_harga, 'kode_level_harga')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor_level_harga]) ?>

                <?= $form->field($model_level_harga, 'keterangan')->textarea(['rows' => 6]) ?>
                <div class="form-group">
                    <?php if ($model->isNewRecord) { ?>
                        <input type="hidden" value="<?= $_GET['id'] ?>" name="id">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-item']) ?>
                    <?php } else { ?>
                        <input type="hidden" name="id_update" value="<?= $_GET['id'] ?>">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-item']) ?>
                    <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
