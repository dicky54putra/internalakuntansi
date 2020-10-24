<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualanDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-retur-penjualan-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_retur_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                    <?= $form->field($model, 'id_penjualan_pengiriman_detail')->widget(Select2::classname(), [
                        'data' => $data_penjualan_pengiriman_detail,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Barang'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>

                    <?= $form->field($model, 'retur')->textInput() ?>

                    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-retur-penjualan/view', 'id' => $model->id_retur_penjualan], ['class' => 'btn btn-warning']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('#aktreturpenjualandetail-id_penjualan_detail').change(function(){
	var id = $(this).val();

	$.get('index.php?r=akt-retur-penjualan-detail/get-qty-penjualan-detail',{ id : id },function(data){
		var data = $.parseJSON(data);
		$('#aktreturpenjualandetail-qty').attr('value',data.qty);
	});
    });

JS;
$this->registerJs($script);
?>