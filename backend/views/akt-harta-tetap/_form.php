<?php

use backend\models\AktKelompokHartaTetap;
use backend\models\AktAkun;
// use yii\helpers\Html;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktHartaTetap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-harta-tetap-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-car"></span> Harta Tetap</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'kode')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'id_kelompok_harta_tetap')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktKelompokHartaTetap::find()->all(),
                                    'id_kelompok_harta_tetap',
                                    function ($model) {
                                        return $model['kode'] . ' - ' . $model['nama'];
                                    }
                                ),
                                // 'prompt' => 'Pilih Mata Uang ',
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Kelompok Harga Tetap'],
                                'addon' => [
                                    'prepend' => [
                                        'content' => Html::button(Html::icon('plus'), [
                                            'style' => 'height:34px',
                                            'class' => 'btn btn-success', 
                                            'data-toggle' => 'modal',
                                            'data-target'=>"#modalCreateKelompokHartaTetap"
                                        ]),
                                        'asButton' => true
                                    ],
                                ],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ])->label('Kelompok Harta Tetap') ?>
                        </div>
                        <div class="col-md-6">

                                <?= $form->field($model, 'tipe')->widget(Select2::classname(), [
                                'data' =>  array(
                                    1 => 'Berwujud',
                                    2 => 'Tidak Berwujud',
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Tipe'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ]) ?>

                            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                                'data' =>  array(
                                    1 => 'Aktif',
                                    2 => 'Tidak Aktif',
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Status'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ]) ?>
                        
                        </div>
                    </div>
                    

                                

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreateKelompokHartaTetap" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Tambah Kelompok Harta Tetap</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([
                    'method' => 'post',
                    'action' => ['akt-kelompok-harta-tetap/create'],
                ]); ?>
                

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model_kelompok_harta_tetap, 'kode')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model_kelompok_harta_tetap, 'nama')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model_kelompok_harta_tetap, 'umur_ekonomis')->textInput() ?>

                            <?= $form->field($model_kelompok_harta_tetap, 'metode_depresiasi')->widget(Select2::classname(), [
                                'data' =>  array(
                                    1 => 'Metode Saldo Menurun',
                                    2 => 'Metode Garis Lurus',
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Metode Depresiasi'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ]) ?>
                            <?= $form->field($model_kelompok_harta_tetap, 'id_akun_harta')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktAkun::find()->all(),
                                    'id_akun',
                                    'nama_akun'
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Akun Harta'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ])->label('Akun Harta') ?>

                            
                        </div>
                        <div class="col-md-6">
                        <?= $form->field($model_kelompok_harta_tetap, 'id_akun_akumulasi')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktAkun::find()->all(),
                                    'id_akun',
                                    'nama_akun'
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Akun Akumulasi'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ])->label('Akun Akumulasi') ?>
                            
                            <?= $form->field($model_kelompok_harta_tetap, 'id_akun_depresiasi')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktAkun::find()->all(),
                                    'id_akun',
                                    'nama_akun'
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Akun Depresiasi'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ])->label('Akun Depresiasi') ?>

                            <?= $form->field($model_kelompok_harta_tetap, 'keterangan')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>

                

               



                <div class="form-group">
                    <?php if ($model->isNewRecord) { ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'create-in-harta-tetap']) ?>
                        <?php } else { ?>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success', 'name' => 'update-in-harta-tetap']) ?>
                        <?php } ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>