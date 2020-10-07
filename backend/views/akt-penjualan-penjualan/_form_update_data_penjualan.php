<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-copy"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-grop">
                                <?= $form->field($model, 'no_penjualan')->textInput(['readonly' => true, 'required' => 'on', 'autocomplete' => 'off']) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'tanggal_penjualan')->widget(
                                    \yii\jui\DatePicker::classname(),
                                    [
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'dateFormat' => 'yyyy-MM-dd',
                                        'options' => ['class' => 'form-control', 'required' => 'on', 'autocomplete' => 'off']
                                    ]
                                ) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'ongkir')->widget(\yii\widgets\MaskedInput::className(), ['options' => ['required' => 'on', 'autocomplete' => 'off'], 'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'diskon')->textInput(['type' => 'number', 'required' => 'on', 'autocomplete' => 'off']) ?>
                            </div>

                            <div class="form-group">
                                <table>
                                    <tr>
                                        <td style="height: 8px;"></td>
                                    </tr>
                                </table>
                                <?= $form->field($model, 'pajak')->checkbox() ?>
                                <table>
                                    <tr>
                                        <td style="height: 9px;"></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group">
                                <?php // $form->field($model, 'total')->textInput(['required' => 'on', 'autocomplete' => 'off', 'type' => 'number', 'readonly' => true]) 
                                ?>
                            </div>

                        </div>
                        <div class="col-md-6">


                            <div class="form-group">
                                <?= $form->field($model, 'jenis_bayar')->dropDownList(
                                    array(1 => "CASH", 2 => "CREDIT"),
                                    [
                                        'prompt' => 'Pilih Jenis Pembayaran',
                                        'required' => 'on',
                                    ]
                                ) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'jumlah_tempo', ['options' => ['id' => 'jumlah_tempo', 'hidden' => 'yes']])->dropDownList(array(
                                    15 => 15,
                                    30 => 30,
                                    45 => 45,
                                    60 => 60,
                                ), ['prompt' => 'Pilih Jumlah Tempo']) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'tanggal_tempo', ['options' => ['id' => 'tanggal_tempo', 'hidden' => 'yes']])->textInput(['readonly' => true]) ?>
                                <?= $form->field($model, 'id_penjualan')->textInput(['type' => 'hidden', 'readonly' => true, 'required' => 'on', 'autocomplete' => 'off', 'id' => 'id_penjualan'])->label(FALSE) ?>
                            </div>

                            <div class="form-group">
                                <?= $form->field($model, 'materai')->widget(\yii\widgets\MaskedInput::className(), ['options' => ['required' => 'on', 'autocomplete' => 'off'], 'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>
                            </div>

                            <div class="form-group">
                                <label for="total_penjualan_detail">Total Penjualan Barang</label>
                                <?= Html::input("text", "total_penjualan_detail", ribuan($model_penjualan_detail), ['class' => 'form-control', 'readonly' => true, 'id' => 'total_penjualan_detail']) ?>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['view', 'id' => $model->id_penjualan], ['class' => 'btn btn-warning']) ?>
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

    // $('#id_item_stok').change(function(){
	// var id = $(this).val();

	// $.get('index.php?r=akt-penjualan-detail/get-harga-item',{ id : id },function(data){
	// 	var data = $.parseJSON(data);
	// 	$('#aktpenjualandetail-harga').attr('value',data.hpp);
	// });
    // });

    $(document).ready(function(){ 

    if ($("#aktpenjualan-jenis_bayar").val() == "1")
    {
        $("#aktpenjualan-jumlah_tempo").hide();
        $('#jumlah_tempo').hide(); 
        $("#aktpenjualan-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualan-jenis_bayar").val() == "2")
    {
        $("#aktpenjualan-jumlah_tempo").show();
        $('#jumlah_tempo').show(); 
        $("#aktpenjualan-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }

    $("#aktpenjualan-jenis_bayar").change(function(){

    if ($("#aktpenjualan-jenis_bayar").val() == "1")
    {
        $("#aktpenjualan-jumlah_tempo").hide();
        $('#jumlah_tempo').hide(); 
        $("#aktpenjualan-tanggal_tempo").hide();
        $('#tanggal_tempo').hide(); 
            
    }
    
    if ($("#aktpenjualan-jenis_bayar").val() == "2")
    {
        $("#aktpenjualan-jumlah_tempo").show();
        $('#jumlah_tempo').show(); 
        $("#aktpenjualan-tanggal_tempo").show();
        $('#tanggal_tempo').show(); 
    }
    
    });
    });

    $('#jumlah_tempo').change(function(){
        var id = $('#id_penjualan').val();
        $.ajax({
            url:'index.php?r=akt-penjualan-penjualan/get-tanggal',
            data: {id : id},
            type:'GET',
            dataType:'json',
            success:function(data){
                if ($('#aktpenjualan-jumlah_tempo').val() == 15) {
                    var tgl = new Date(new Date(data.tanggal_penjualan).getTime() + (15*24*60*60*1000));
                    var t = new Date(tgl), month = '' + (t.getMonth() + 1), day = '' + t.getDate(), year = t.getFullYear();
                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                        day = '0' + day;

                    var g = [year, month, day].join('-');
                    
                    $("#aktpenjualan-tanggal_tempo").val(g);
                }
                if ($('#aktpenjualan-jumlah_tempo').val() == 30) {
                    var tgl = new Date(new Date(data.tanggal_penjualan).getTime() + (30*24*60*60*1000));
                    var t = new Date(tgl), month = '' + (t.getMonth() + 1), day = '' + t.getDate(), year = t.getFullYear();
                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                        day = '0' + day;

                    var g = [year, month, day].join('-');
                    
                    $("#aktpenjualan-tanggal_tempo").val(g);
                }
                if ($('#aktpenjualan-jumlah_tempo').val() == 45) {
                    var tgl = new Date(new Date(data.tanggal_penjualan).getTime() + (45*24*60*60*1000));
                    var t = new Date(tgl), month = '' + (t.getMonth() + 1), day = '' + t.getDate(), year = t.getFullYear();
                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                        day = '0' + day;

                    var g = [year, month, day].join('-');
                    
                    $("#aktpenjualan-tanggal_tempo").val(g);
                }
                if ($('#aktpenjualan-jumlah_tempo').val() == 60) {
                    var tgl = new Date(new Date(data.tanggal_penjualan).getTime() + (60*24*60*60*1000));
                    var t = new Date(tgl), month = '' + (t.getMonth() + 1), day = '' + t.getDate(), year = t.getFullYear();
                    if (month.length < 2) 
                        month = '0' + month;
                    if (day.length < 2) 
                        day = '0' + day;

                    var g = [year, month, day].join('-');
                    
                    $("#aktpenjualan-tanggal_tempo").val(g);
                }
            }
        })

    })

JS;
$this->registerJs($script);
?>

<script>
    // let grandTotal = document.querySelector('#aktpenjualan-total');
    // let subTotal = document.querySelector('#total_penjualan_detail')
    // let pajakHtml = document.querySelector('#aktpenjualan-pajak');
    // let subTotalInt = subTotal.value.replace(/[^\d,]/g, "");
    // let diskon = document.querySelector('#aktpenjualan-diskon');
    // let ongkir = document.querySelector('#aktpenjualan-ongkir');

    // function disk(pajakVal = 0, diskonVal = 0, ongkirVal = 0) {
    //     let diskonPersen = diskonVal / 100 * subTotalInt;
    //     grandTotal.value = `${subTotalInt - diskonPersen + pajakVal + ongkirVal}`;
    // }

    // function eventHandler(type, valDis = 0, valOng = 0, valPaj = 0) {
    //     if (type === 'ongkirDiskon') {
    //         disk(0, valDis, valOng);
    //     } else if (type === 'pajakOngkir') {
    //         disk(valPaj, 0, valOng)
    //     } else if (type === 'pajakDiskon') {
    //         disk(valPaj, valDis, 0)
    //     }
    // }

    // ongkir.addEventListener('input', function(e) {
    //     let valOngkir = parseInt(e.srcElement.value)
    //     disk(0, 0, valOngkir);
    //     diskon.addEventListener('input', function(e) {
    //         let valDiskon = parseInt(e.srcElement.value)
    //         eventHandler('ongkirDiskon', valDiskon, valOngkir, 0);
    //         pajakHtml.onchange = function() {
    //             if (pajakHtml.checked === true) {
    //                 let diskonPersen = valDiskon / 100 * subTotalInt;
    //                 let total = subTotalInt - diskonPersen;
    //                 let pajak = total * 10 / 100;
    //                 disk(pajak, valDiskon, valOngkir);
    //             } else if (pajakHtml.checked === false) {
    //                 disk(0, valDiskon, valOngkir);
    //             }
    //         }
    //     })
    // })

    // diskon.addEventListener('input', function(e) {
    //     let valDiskon = parseInt(e.srcElement.value)
    //     disk(0, valDiskon, 0);
    //     ongkir.addEventListener('input', function(e) {
    //         let valOngkir = parseInt(e.srcElement.value)
    //         eventHandler('ongkirDiskon', valDiskon, valOngkir, 0);
    //         pajakHtml.onchange = function() {
    //             if (pajakHtml.checked === true) {
    //                 let diskonPersen = valDiskon / 100 * subTotalInt;
    //                 let total = subTotalInt - diskonPersen;
    //                 let pajak = total * 10 / 100;
    //                 disk(pajak, valDiskon, valOngkir);
    //             } else if (pajakHtml.checked === false) {
    //                 disk(0, valDiskon, valOngkir);
    //             }
    //         }
    //     })
    // })


    // pajakHtml.onchange = function() {
    //     if (pajakHtml.checked === true) {
    //         let pajak = subTotalInt * 10 / 100;
    //         disk(pajak, 0, 0);
    //         ongkir.addEventListener('input', function(e) {
    //             let valOngkir = parseInt(e.srcElement.value)
    //             eventHandler('pajakOngkir', 0, valOngkir, pajak);
    //         })
    //         diskon.addEventListener('input', function(e) {
    //             let valDiskon = parseInt(e.srcElement.value)
    //             eventHandler('pajakDiskon', valDiskon, 0, pajak);
    //         })
    //     } else if (pajakHtml.checked === false) {
    //         disk(0, 0, 0)
    //     }
    // }

    // function setup() {
    //     // ongkirCek();
    //     // pajakCek();
    //     // diskonCek();
    // }

    // setup();
</script>