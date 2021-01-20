<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualan */
/* @var $form yii\widgets\ActiveForm */
?>


<style>
    .kas-bank {
        display: none;
    }
</style>

<div class="akt-retur-penjualan-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-repeat"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'no_retur_penjualan')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                            <?= $form->field($model, 'tanggal_retur_penjualan')->widget(\yii\jui\DatePicker::classname(), [
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => ['class' => 'form-control']
                            ]) ?>

                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'id_penjualan')->widget(Select2::classname(), [
                                'data' => $data_penjualan,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Penjualan', 'id' => 'id_penjualan'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>

                            <?php
                            if ($model->isNewRecord) {
                                # code...
                            ?>
                                <div class="kas-bank kas-bank-get">
                                    <div>

                                        <span style="position: absolute;left:15%; color:red;">Jika jenis bayar cash, harus diisi.</span>
                                        <?= $form->field($model, 'id_kas_bank')->widget(Select2::classname(), [
                                            'data' => $data_kas_bank,
                                            'language' => 'en',
                                            'options' => ['placeholder' => 'Pilih Kas Bank', 'id' => 'id_kas_bank'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label('Kas Bank')
                                        ?>
                                    </div>


                                </div>
                                <?= $form->field($model, 'status_retur')->dropDownList(array(0 => "Pengajuan")) ?>
                            <?php } else { ?>
                                <?php if ($model->id_kas_bank != null) { ?>

                                    <div>

                                        <span style="position: absolute;left:15%; color:red;">Jika jenis bayar cash, harus diisi.</span>
                                        <?= $form->field($model, 'id_kas_bank')->widget(Select2::classname(), [
                                            'data' => $data_kas_bank,
                                            'language' => 'en',
                                            'options' => ['placeholder' => 'Pilih Kas Bank', 'id' => 'id_kas_bank'],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ])->label('Kas Bank')
                                        ?>
                                    </div>

                                <?php } ?>
                            <?php } ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_retur_penjualan];
                        }

                        ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>


<?php

$script = <<< JS

    $('#id_penjualan').on("select2:select", function (e) {
        let value = $(this).val();
        console.log(value);
        let url = 'index.php?r=akt-retur-penjualan/get-jenis-pembayaran&id=' + value;

        fetch(url)
        .then(res => res.json())
        .then(result =>{

            if(result == 1) {
                $('.kas-bank-get').removeClass("kas-bank");
                $("#id_kas_bank").prop('required',true);
            } else {
                $('.kas-bank-get').addClass("kas-bank");
                $("#id_kas_bank").prop('required',false);

            }
        });
    })
JS;

$this->registerJs($script);

?>