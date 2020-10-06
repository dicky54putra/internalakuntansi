<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokOpnameDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-stok-opname-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin([
                        'options' => ['oninput' => 'qty_selisih.value=(parseInt(qty_opname.value)-parseInt(qty_program.value))'],
                    ]); ?>
                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                                'data' => $data_item_stok,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ]);
                            ?>
                            <?= $form->field($model, 'qty_opname')->textInput(['id' => 'qty_opname']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'qty_program')->textInput(['readonly' => true, 'id' => 'qty_program']) ?>

                            <?= $form->field($model, 'qty_selisih')->textInput(['id' => 'qty_selisih']) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-stok-opname/view', 'id' => $model->id_stok_opname], ['class' => 'btn btn-warning']) ?>
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
 
	$.get('index.php?r=akt-stok-opname-detail/get-qty-item',{ id : id },function(data){
		var data = $.parseJSON(data);
		$('#qty_program').attr('value',data.qty);
	});
});
 
JS;
$this->registerJs($script);
?>