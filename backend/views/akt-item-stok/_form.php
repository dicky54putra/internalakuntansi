<?php

// use yii\helpers\Html;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemStok */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-stok-form">
    <div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?=
                                    $form->field($model, 'id_gudang')->widget(Select2::classname(), [
                                        'data' =>$data_gudang,
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Pilih Gudang'],
                                        'addon' => [
                                            'prepend' => [
                                                'content' => Html::button(Html::icon('plus'), [
                                                    'style' => 'height:34px',
                                                    'class' => 'btn btn-success', 
                                                    'data-toggle' => 'modal',
                                                    'data-target'=>"#modalCreateGudang"
                                                ]),
                                                'asButton' => true
                                            ],
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label('Pilih Gudang');
                                ?>
                                

                                <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

                                <?= $form->field($model, 'qty')->textInput(['readonly' => true]) ?>
                            </div>
                            <div class="col-md-6">
                                
                                <?= $form->field($model, 'hpp')->widget(\yii\widgets\MaskedInput::className(), [
                                                        'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                                        'options' => ['required' => true]
                                                    ]); ?> 

                                <?= $form->field($model, 'min')->widget(\yii\widgets\MaskedInput::className(), [
                                                        'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                                        'options' => ['required' => true]
                                                    ]); ?> 
                            </div>
                        </div>
                   

                    <div class="form-group">
                        <?= $form->field($model, 'id_item')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-item/view', 'id' => $model->id_item], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

                <!-- gudang -->
<div class="modal fade" id="modalCreateGudang" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Gudang</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-gudang/create'],
                ]); ?>
                
               <?= $form->field($model_gudang, 'kode_gudang')->textInput(['readonly' => true, 'value' => $nomor_gudang]) ?>

                <?= $form->field($model_gudang, 'nama_gudang')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model_gudang, 'status_aktif_gudang')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif')) ?>
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