<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStokDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penyesuaian-stok-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><i class="fa fa-box"></i> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                                    'data' => $data_item_stok,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang','id' => 'id_item_stok'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Barang');
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'qty')->textInput() ?>
                                <?= $form->field($model, 'hpp')->hiddenInput()->label(false) ?>
                                <?= $form->field($model, 'id_penyesuaian_stok')->hiddenInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-penyesuaian-stok/view', 'id' => $model->id_penyesuaian_stok], ['class' => 'btn btn-warning']) ?>
                                </div>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
$(document).ready(function(){
    $('#id_item_stok').change(function(){
    var id = $(this).val();
    $.ajax({
            url:'index.php?r=akt-penyesuaian-stok/get-hpp',
            data: {id : id},
            dataType:'json',
            success:function(data){
                // console.log(data);
                $('#aktpenyesuaianstokdetail-hpp').val(data.hpp);
                // $('#aktpenyesuaianstokdetail-qty').val(data.qty);
            }
        })
    })
});    
JS;
$this->registerJs($script);
?>