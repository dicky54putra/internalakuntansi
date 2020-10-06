<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktPegawai;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-permintaan-barang-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                            <?= $form->field($model, 'nomor_permintaan')->textInput(['readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_permintaan')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>
                             <?=
                                $form->field($model, 'id_pegawai')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(AktPegawai::find()->all(), 'id_pegawai', 'nama_pegawai'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Pegawai'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Pegawai');
                            ?>
                            <?= $form->field($model, 'status_aktif')->hiddenInput(['value' => 0 ])->label(false) ?>
                            <br>
                                <?php
                                if ($model->isNewRecord) {
                                    # code...
                                ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-permintaan-barang/index'], ['class' => 'btn btn-warning']) ?>
                                <?php
                                } else {
                                    # code...
                                ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang], ['class' => 'btn btn-warning']) ?>
                                <?php
                                }

                                ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                               
                        
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>