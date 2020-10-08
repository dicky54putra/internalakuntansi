<?php

// use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\models\AktItemTipe;
use backend\models\AktMerk;
use backend\models\AktSatuan;
use backend\models\AktMitraBisnis;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use backend\models\AktLevelHarga;
use backend\models\AktSales;
/* @var $this yii\web\View */
/* @var $model backend\models\AktItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> Barang</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                        <?= $form->field($model, 'kode_item')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                        <?= $form->field($model, 'barcode_item')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'nama_item')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'nama_alias_item')->textInput(['maxlength' => true]) ?>

                        <?=
                            $form->field($model, 'id_tipe_item')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(AktItemTipe::find()->all(), 'id_tipe_item', function($model) {
                                        return  $model->nama_tipe_item;
                                }),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Tipe Barang'],
                                'addon' => [
                                    'prepend' => [
                                        'content' => Html::button(Html::icon('plus'), [
                                            'style' => 'height:34px',
                                            'class' => 'btn btn-success', 
                                            'data-toggle' => 'modal',
                                            'data-target'=>"#modalCreateTipe"
                                        ]),
                                        'asButton' => true
                                    ],
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Pilih Tipe Barang');
                        ?>
                        <?=
                        $form->field($model, 'id_merk')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktMerk::find()->all(), 'id_merk', 'nama_merk'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Merk'],
                            'addon' => [
                                'prepend' => [
                                    'content' => Html::button(Html::icon('plus'), [
                                        'style' => 'height:34px',
                                        'class' => 'btn btn-success', 
                                        'data-toggle' => 'modal',
                                        'data-target'=>"#modalCreateMerk"
                                    ]),
                                    'asButton' => true
                                ],
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Merk');
                    ?>
                        </div>
                        <div class="col-lg-6">
                        

                    <?=
                        $form->field($model, 'id_satuan')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktSatuan::find()->all(), 'id_satuan', 'nama_satuan'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Satuan'],
                            'addon' => [
                                'prepend' => [
                                    'content' => Html::button(Html::icon('plus'), [
                                        'style' => 'height:34px',
                                        'class' => 'btn btn-success', 
                                        'data-toggle' => 'modal',
                                        'data-target'=>"#modalCreateSatuan"
                                    ]),
                                    'asButton' => true
                                ],
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Satuan');
                    ?>

                    <?=
                        $form->field($model, 'id_mitra_bisnis')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktMitraBisnis::find()->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Mitra Bisnis'],
                            'addon' => [
                                'prepend' => [
                                    'content' => Html::button(Html::icon('plus'), [
                                        'style' => 'height:34px',
                                        'class' => 'btn btn-success', 
                                        'data-toggle' => 'modal',
                                        'data-target'=>"#modalCreateMitraBisnis"
                                    ]),
                                    'asButton' => true
                                ],
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Mitra Bisnis');
                    ?>



                    <?= $form->field($model, 'keterangan_item')->textarea(['rows' => 5]) ?>

                    <?= $form->field($model, 'status_aktif_item')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

<!-- Modal Create Tipe -->
<div class="modal fade" id="modalCreateTipe" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Tipe Barang</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-item-tipe/create'],
                ]); ?>
                <?= $form->field($model_tipe, 'nama_tipe_item')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                <?php if ($model->isNewRecord) { ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-item']) ?>
                        <?php } else { ?>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-item']) ?>
                        <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>

<!-- END Modal Create Tipe -->

<!-- Merk -->
<div class="modal fade" id="modalCreateMerk" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Merk Barang</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-merk/create'],
                ]); ?>
                <?= $form->field($model_merk, 'kode_merk')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor_merk]) ?>
                <?= $form->field($model_merk, 'nama_merk')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                <?php if ($model->isNewRecord) { ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-item']) ?>
                        <?php } else { ?>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-item']) ?>
                        <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>

<!-- Satuan -->
<div class="modal fade" id="modalCreateSatuan" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Satuan</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-satuan/create'],
                ]); ?>
                <?= $form->field($model_satuan, 'nama_satuan')->textInput(['maxlength' => true]) ?>
                <div class="form-group">
                        <?php if ($model->isNewRecord) { ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-item']) ?>
                        <?php } else { ?>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-item']) ?>
                        <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>

<!-- Mitra Bisnis -->
<div class="modal fade" id="modalCreateMitraBisnis" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Mitra Bisnis</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-mitra-bisnis/create'],
                ]); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model_mitra_bisnis, 'kode_mitra_bisnis')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor_mitra_bisnis]) ?>

                        <?= $form->field($model_mitra_bisnis, 'nama_mitra_bisnis')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model_mitra_bisnis, 'deskripsi_mitra_bisnis')->textarea(['rows' => 5]) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= $form->field($model_mitra_bisnis, 'tipe_mitra_bisnis')->dropDownList(array(1 => "Customer", 2 => "Supplier", 3 => "Customer & Supplier")) ?>

                        <?= $form->field($model_mitra_bisnis, 'status_mitra_bisnis')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>
                    </div>
                </div>   
                    <div class="form-group">

                        <?php if ($model->isNewRecord) { ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-item']) ?>
                        <?php } else { ?>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-item']) ?>
                        <?php } ?>

                        
                    </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>