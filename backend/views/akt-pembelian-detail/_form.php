<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pembelian-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'id_pembelian')->textInput(['readonly' => true, 'type' => 'hidden'])->label((FALSE)) ?>

                            <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                                'data' => $data_item_stok,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Stok Barang')
                            ?>

                            <?= $form->field($model, 'qty')->textInput(['autocomplete' => 'off']) ?>

                            <?= $form->field($model, 'harga')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'type' => 'number']) ?>
                        </div>
                        <div class="col-md-6" style="margin-top: 15px;">
                            <?= $form->field($model, 'diskon')->textInput(['autocomplete' => 'off'])->label('Diskon %') ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 5]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-pembelian/view', 'id' => $model->id_pembelian], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
    $('#id_item_stok').change(function(){
    var id = $(this).val();

    $.get('index.php?r=akt-pembelian-detail/get-harga-item',{ id : id },function(data){
        var data = $.parseJSON(data);
        $('#aktpembeliandetail-harga').attr('value',data.hpp);
    });
    });

JS;
$this->registerJs($script);
?>