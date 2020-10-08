<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktAkun;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKelompokHartaTetap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-kelompok-harta-tetap-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-list-alt"></span> Kelompok Harta Tetap</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'kode')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'umur_ekonomis')->textInput() ?>

                            <?= $form->field($model, 'metode_depresiasi')->widget(Select2::classname(), [
                                'data' =>  array(
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

                            <?= $form->field($model, 'id_akun_harta')->widget(Select2::classname(), [
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

                            <?= $form->field($model, 'id_akun_akumulasi')->widget(Select2::classname(), [
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

                            <?= $form->field($model, 'id_akun_depresiasi')->widget(Select2::classname(), [
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

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>


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