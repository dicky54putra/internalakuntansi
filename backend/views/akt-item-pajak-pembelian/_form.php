<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemPajakPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-pajak-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_item')->textInput(['readonly' => true, 'type' => 'hidden', 'value' => $id_item])->label(FALSE) ?>

                    <?php

                    $the_pajak = "";
                    if ($selected_pajak != "") {
                        $the_pajak = $selected_pajak->nama_pajak;
                    }

                    echo '<label class="control-label">Nama Pajak</label><br>';
                    echo AutoComplete::widget([
                        'clientOptions' => [
                            'source' => $array_pajak,
                            'minLength' => '1',
                            'autoFill' => true,
                            'select' => new JsExpression("function( event, ui ) {
                            $('#aktitempajakpembelian-id_pajak').val(ui.item.id);                            
                        }")
                        ],
                        'options' => ['class' => 'form-control', 'placeholder' => 'Ketikan Nama Pajak'],
                        'name' => 'AktItemPajakPembelian[id_pajak]',
                        'value' => $the_pajak,
                    ]);


                    echo $form->field($model, 'id_pajak')
                        ->textInput(["value" => $model->id_pajak, 'readonly' => true])
                        ->label(false);
                    ?>

                    <?= $form->field($model, 'perhitungan')->dropDownList(array(1 => "Normal", 2 => "Progressive")) ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-item/view', 'id' => $id_item], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>