<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktKasBank;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferKas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-transfer-kas-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-book"></span> Transfer Kas</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'no_transfer_kas')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                    <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]) ?>

                    <?php
                    if ($model->isNewRecord) {
                        $dis = false;
                    } else {
                        $dis = true;
                    }
                    ?>

                    <?=
                        $form->field($model, 'id_asal_kas')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktKasBank::find()->all(), 'id_kas_bank', function ($modal_kas) {
                                $kas = Yii::$app->db->createCommand("SELECT akt_mata_uang.mata_uang FROM akt_kas_bank LEFT JOIN akt_mata_uang ON akt_mata_uang.id_mata_uang = akt_kas_bank.id_mata_uang WHERE id_kas_bank = '$modal_kas->id_kas_bank'")->queryScalar();
                                return $modal_kas->keterangan . ' - ' . $kas;
                            }),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Kas Asal', 'id' => 'id_asal_kas', 'disabled' => $dis],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Kas Asal');
                    ?>



                    <?=
                        $form->field($model, 'id_tujuan_kas')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktKasBank::find()->all(), 'id_kas_bank', function ($modal_kas) {
                                $kas = Yii::$app->db->createCommand("SELECT akt_mata_uang.mata_uang FROM akt_kas_bank LEFT JOIN akt_mata_uang ON akt_mata_uang.id_mata_uang = akt_kas_bank.id_mata_uang WHERE id_kas_bank = '$modal_kas->id_kas_bank'")->queryScalar();
                                return $modal_kas->keterangan . ' - ' . $kas;
                            }),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Kas Tujuan', 'id' => 'id_tujuan_kas', 'disabled' => $dis],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Kas Tujuan');
                    ?>

                    <!-- <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="control-label" for="kurs_asal">Kurs Asal</label>
                    <input type="text" id="kurs_asal" class="form-control" aria-required="true" readonly>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="control-label" for="kurs_tujuan">Kurs Tujuan</label>
                    <input type="text" id="kurs_tujuan" class="form-control" aria-required="true" readonly>
                </div>
            </div>
        </div> -->


                    <?= $form->field($model, 'jumlah1')->textInput()->widget(\yii\widgets\MaskedInput::className(), [
                        'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0],
                        'options' => ['required' => true]
                    ]); ?>

                    <?= $form->field($model, 'jumlah2')->hiddenInput(['readonly' => true, 'value' => 0])->label(FALSE) ?>

                    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

                    <div class="form-group" style="margin-top:50px;">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

                <?php
                $script = <<< JS

// function setup(){
//     finish();
// }

// function finish() {
//     setTimeout(() => {
//         update();
//         finish()
//     }, 200);
// }
// function update(){
//     $("#id_asal_kas").on("change",function(){
//     $.ajax({
//         url:"index.php?r=akt-transfer-kas/kas",
//         type: "GET",
//         data:"id="+$(this).val(),
//         success:function(data){
//             var data = $.parseJSON(data);
//             console.log(data);
//             $("#kurs_asal").attr('value', data.kurs);
//         }
//     });
// });
// }

// setup();


// $("#id_tujuan_kas").on("change",function(){
//     $.ajax({
//         url:"index.php?r=akt-transfer-kas/kas",
//         type: "GET",
//         data:"id="+$(this).val(),
//         success:function(data){
//             var data = $.parseJSON(data);
//             console.log(data);
//             $("#kurs_tujuan").attr('value', data.kurs);
//         }
//     });
// });



JS;
                $this->registerJs($script);
                ?>