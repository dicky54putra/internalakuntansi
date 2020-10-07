<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktPegawai;
use backend\models\AktAkun;
use backend\models\AktMitraBisnis;
use backend\models\AktBom;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiBom */
/* @var $form yii\widgets\ActiveForm */

?>

<?php
$disabled = true;
if ($model->isNewRecord) {
    $disabled = false;
}
?>


<div class="akt-produksi-bom-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-area-chart"></span> Produksi B.o.M</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'no_produksi_bom')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                            <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
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
                                    'options' => ['placeholder' => 'Semua'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Pegawai');
                            ?>
                            <?=
                                $form->field($model, 'id_customer')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(AktMitraBisnis::find()->where(['!=', 'tipe_mitra_bisnis', '2'])->all(), 'id_mitra_bisnis', 'nama_mitra_bisnis'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Customer'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],

                                ])->label('Pilih Customer');
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'id_bom')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktBom::find()->where(['status_bom' => 1])->all(),
                                    'id_bom',
                                    'no_bom'
                                ),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih B.o.M'],
                                'pluginOptions' => [
                                    'disabled' => $disabled,
                                    'allowClear' => true,
                                ],

                            ])->label('Pilih B.o.M');
                            ?>
                            <?= $form->field($model, 'tipe')->dropDownList(array(1 => "De-Produksi", 2 => "Produksi")) ?>
                            <?=
                                $form->field($model, 'id_akun')->widget(Select2::classname(), [
                                    'data' => $data_akun,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Akun'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Akun');
                            ?>
                            <div class="form-group" style="margin-top:40px;">
                                <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>