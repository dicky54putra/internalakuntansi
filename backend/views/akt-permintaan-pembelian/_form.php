<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktCabang;
use backend\models\AktPegawai;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-permintaan-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-file"></span> Permintaan Pembelian</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $form->field($model, 'no_permintaan')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'keterangan')->textarea(['rows' => 4]) ?>

                            </div>

                           
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                 <?php 
                                    if ($model->tanggal == "0000-00-00" || $model->tanggal == "") {
                                        $model->tanggal =  Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
                                    }  ?>

                                <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
                                    'clientOptions' => [
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    ],
                                    'dateFormat' => 'yyyy-MM-dd',
                                    'options' => ['class' => 'form-control']
                                ]) ?>
                            </div>
                            
                           <div class="form-group">
                               <?= $form->field($model, 'id_pegawai')->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(AktPegawai::find()->all(),'id_pegawai', function ($model) 
                                                        { 
                                                            return $model['kode_pegawai'] . ' - ' . $model['nama_pegawai'];
                                                        }
                                                    ),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Pilih Pegawai'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])->label('Pegawai')
                                            ?>
                           </div>
                            <div class="form-group">
                                <?php
                                    if ($model->isNewRecord) {
                                        echo $form->field($model, 'status')->dropDownList(
                                            array(
                                                '2' => 'Belum Disetujui'
                                            ), ['readonly' => true]
                                        );
                                    } else {
                                        echo $form->field($model, 'status')->dropDownList(
                                            array(
                                                '1' => 'Disetujui',
                                                '2' => 'Belum Disetujui'
                                            )
                                        );
                                    }
                                ?>
                            </div>
                            
                        </div>
                    </div>

                                
                        

                            

                           

                            <?= $form->field($model, 'draft')->textInput(['value' => 1, 'type' => 'hidden'])->label(false);
                            // dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif'))->label('Draft') 
                            ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>