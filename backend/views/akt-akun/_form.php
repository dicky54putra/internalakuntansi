<?php

use backend\models\AktAkun;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AktKlasifikasi;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktAkun */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-akun-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-check"></span> Akun</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'kode_akun')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                            <?= $form->field($model, 'nama_akun')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'saldo_akun')->textInput(['value' => $model->nama_akun == 'kas' ? $sum_kas_bank : $model->saldo_akun, 'readonly' => true]) ?>

                            <?= $form->field($model, 'header')->checkbox()
                            ?>
                            <?php
                            // $model->parent = 1;
                            echo $form->field($model, 'parent')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktAkun::find()->where(['header' => 1])->all(),
                                    'id_akun',
                                    'nama_akun'
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Klasifikasi'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ])->label('Parent')
                            ?>
                        </div>
                        <div class="col-lg-6">


                            <?= $form->field($model, 'jenis')->widget(Select2::classname(), [
                                'data' =>  array(
                                    1 => 'Aset Lancar',
                                    2 => 'Aset Tetap',
                                    3 => 'Aset Tetap Tidak Berwujud',
                                    4 => 'Pendapatan',
                                    // 2 => 'Kewajiban',
                                    5 => 'Liabilitas Jangka Pendek',
                                    6 => 'Liabilitas Jangka Panjang',
                                    // 3 => 'Modal',
                                    7 => 'Ekuitas',
                                    // 5 => 'Pendapatan Lain',
                                    8 => 'Beban',
                                    9 => 'Pengeluaran Lain',
                                    10 => 'Pendapatan Lain',
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Jenis'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>


                            <?= $form->field($model, 'klasifikasi')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktKlasifikasi::find()->all(),
                                    'id_klasifikasi',
                                    'klasifikasi'
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Klasifikasi'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Klasifikasi') ?>
                            <?= $form->field($model, 'saldo_normal')->dropDownList(array(1 => "Debet", 2 => "Kredit")) ?>
                            <?= $form->field($model, 'status_aktif')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>
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