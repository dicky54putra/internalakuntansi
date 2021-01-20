<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturpembelianDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-retur-pembelian-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_retur_pembelian')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                    <?= $form->field($model, 'id_pembelian_detail')->widget(Select2::classname(), [
                        'data' => $data_pembelian_detail,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Barang'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Pembelian Detail')
                    ?>

                    <?= $form->field($model, 'qty')->textInput(['readonly' => true]) ?>

                    <?= $form->field($model, 'retur')->textInput() ?>

                    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-retur-pembelian/view', 'id' => $model->id_retur_pembelian], ['class' => 'btn btn-warning']) ?>
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

    $('#aktreturpembeliandetail-id_pembelian_detail').change(function(){
    var id = $(this).val();

    $.get('index.php?r=akt-retur-pembelian-detail/get-qty-pembelian-detail',{ id : id },function(data){
        var data = $.parseJSON(data);
        // console.log(data);
        if(data.qty_retur === null ) {
             $('#aktreturpembeliandetail-qty').attr('value',data.qty_pembelian.qty);
        } else {
             $('#aktreturpembeliandetail-qty').attr('value',data.qty_retur);
        }
       
    });
    });

JS;
$this->registerJs($script);
?>