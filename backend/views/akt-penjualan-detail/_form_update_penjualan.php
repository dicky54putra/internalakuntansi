<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label((FALSE)) ?>

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                                'data' => $data_item_stok,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>
                            <?= $form->field($model, 'id_item_harga_jual')->widget(DepDrop::classname(), [
                                'data' => $data_level,
                                'type' => DepDrop::TYPE_SELECT2,
                                'options' => ['id' => 'id-harga-jual', 'placeholder' => 'Pilih Jenis...'],
                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                'pluginOptions' => [
                                    'depends' => ['id_item_stok'],
                                    'url' => Url::to(['/akt-penjualan/level-harga'])
                                ]
                            ])->label('Jenis');
                            ?>

                            <?= $form->field($model, 'qty')->textInput(['autocomplete' => 'off']) ?>

                            <?= $form->field($model, 'harga')->textInput(['maxlength' => true, 'autocomplete' => 'off', 'id' => 'harga']) ?>
                            <input type="hidden" id="harga_tetap" name="harga_tetap" value="<?= $model->harga_tetap; ?>" />
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'jenis_diskon')->dropDownList(
                                array(
                                    1 => 'Diskon (%)',
                                    2 => 'Diskon Bertingkat',
                                    3 => 'Diskon Nominal'
                                ),
                                ['prompt' => 'Pilih Jenis Diskon']
                            )->label('Jenis Diskon') ?>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="diskon-persen">
                                        <?= $form->field($model, 'diskon')->textInput(['type' => 'text', 'placeholder' => 'Diskon %', 'name' => 'diskon-persen', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'autocomplete' => 'off', 'id' => 'diskon-persen'])->label('Diskon %') ?>
                                    </div>

                                    <div class="diskon-nominal">
                                        <?= $form->field($model, 'diskon')->textInput(['type' => 'text', 'placeholder' => 'Diskon', 'name' => 'diskon-nominal', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-nominal', 'autocomplete' => 'off'])->label('Diskon Rp.') ?>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2 bertingkat1">
                                            <?= $form->field($model, 'diskon')->textInput(['type' => 'text', 'autocomplete' => 'off', 'name' => 'diskon1', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-1'])->label(false) ?>
                                        </div>
                                        <div class="col-md-2 bertingkat2">
                                            <?= $form->field($model, 'diskon2')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-2'])->label(false) ?>
                                        </div>
                                        <div class="col-md-2 bertingkat3">
                                            <?= $form->field($model, 'diskon3')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-3'])->label(false) ?>
                                        </div>
                                        <div class="col-md-2 bertingkat4">
                                            <?= $form->field($model, 'diskon4')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-4'])->label(false) ?>
                                        </div>
                                        <div class="col-md-2 bertingkat5">
                                            <?= $form->field($model, 'diskon5')->textInput(['type' => 'text', 'autocomplete' => 'off', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+', 'class' => 'diskon-floating form-control', 'id' => 'diskon-5'])->label(false) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 5]) ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-penjualan-penjualan/view', 'id' => $model->id_penjualan], ['class' => 'btn btn-warning']) ?>
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


    $(document).ready(function(){ 

        let jenis_diskon = $('#aktpenjualandetail-jenis_diskon').val();
        if(jenis_diskon == 1) {
            $('.diskon-nominal').hide(); 
            hide_bertingkat();
        } else if(jenis_diskon == 2) {
            $('.diskon-nominal').hide(); 
            $('.diskon-persen').hide(); 
        } else if(jenis_diskon == 3) {
            hide_bertingkat();
            $('.diskon-persen').hide();     
        }
        
    });

    function hilang_titik(string) {
        return string.split('.').join('');
    }

    function is_null_diskon(value, jenis) {
        if(value == null || value == 0 || value == '' ) {
            $(jenis).hide();
        } else {
            $(jenis).show();
        }
    }

    function hide_bertingkat() {
        $('.bertingkat1').hide(); 
        $('.bertingkat2').hide();
        $('.bertingkat3').hide(); 
        $('.bertingkat4').hide(); 
        $('.bertingkat5').hide(); 
    }

    // function hitung_harga_tetap(type, harga_tetap, value1, value2 = 0, value3 = 0, value4 = 0, value5 = 0){

    //     var diskon_in_nominal1 = harga_tetap * value1 / 100;
    //     var last_value1 = harga_tetap - diskon_in_nominal1;

    //     var diskon_in_nominal2 = last_value1 * value2 / 100;
    //     var last_value2 = last_value1 - diskon_in_nominal2;

    //     var diskon_in_nominal3 = last_value2 * value3 / 100;
    //     var last_value3 = last_value2 - diskon_in_nominal3;

    //     var diskon_in_nominal4 = last_value3 * value4 / 100;
    //     var last_value4 = last_value3 - diskon_in_nominal4;

    //     var diskon_in_nominal5 = last_value4 * value5 / 100;
    //     var last_value5 = last_value4 - diskon_in_nominal5;

    //     if(type == 'diskon1') {
    //         $("#harga").val(formatNumber(last_value1));
    //     } else if (type == 'diskon2') {
    //         $("#harga").val(formatNumber(last_value2));
    //     } else if (type == 'diskon3') {
    //         $("#harga").val(formatNumber(last_value3));
    //     } else if (type == 'diskon4') {
    //         $("#harga").val(formatNumber(last_value4));
    //     } else if (type == 'diskon5') {
    //         $("#harga").val(formatNumber(last_value5));
    //     }


    // }


    $("#aktpenjualandetail-jenis_diskon").change(function(){

        var value_harga = $("#harga").val();
        var harga_tetap = $("#harga_tetap").val();

        if ($("#aktpenjualandetail-jenis_diskon").val() == "1")
        {
            $(".diskon-persen").show();
            hide_bertingkat();
            $('.diskon-nominal').hide();  

            // $("#harga").val(formatNumber(harga_tetap));
            $("#diskon-nominal").val(0)
            $("#diskon-1").val(0)
            $("#diskon-2").val(0)
            $("#diskon-3").val(0)
            $("#diskon-4").val(0)
            $("#diskon-5").val(0)


            $("#diskon-persen").change(function() {
               var value = $(this).val();
               var value_not_titik = hilang_titik(harga_tetap);
               var diskon_in_nominal = value_not_titik * value / 100;
               var last_value = value_not_titik - diskon_in_nominal;
            //    $("#harga").val(formatNumber(last_value));
            })

        }
        
        if ($("#aktpenjualandetail-jenis_diskon").val() == "2")
        { 
            $("#diskon-1").val(0)
            // $("#harga").val(formatNumber(harga_tetap));

            $(".diskon-persen").hide();
            $(".diskon-nominal").hide();
            $('.bertingkat1').show(); 

            $("#diskon-nominal").val(0);
            $("#diskon-persen").val(0)

            
            $("#diskon-1").change(function() {
               var value1 = $(this).val();
               is_null_diskon(value1, '.bertingkat2');
            //    hitung_harga_tetap('diskon1', harga_tetap, value1)

               $("#diskon-2").change(function() {
                    var value2 = $(this).val();
                    is_null_diskon(value2, '.bertingkat3');
                    // hitung_harga_tetap('diskon2', harga_tetap, value1, value2);

                    $("#diskon-3").change(function() {
                        var value3 = $(this).val();
                        is_null_diskon(value3, '.bertingkat4');
                        // hitung_harga_tetap('diskon3', harga_tetap, value1, value2,value3);
                        
                        $("#diskon-4").change(function() {
                            var value4 = $(this).val();
                            is_null_diskon(value4, '.bertingkat5');
                            // hitung_harga_tetap('diskon4', harga_tetap, value1, value2, value3, value4);

                            $("#diskon-5").change(function() {
                                var value5 = $(this).val();
                                // hitung_harga_tetap('diskon5', harga_tetap, value1, value2, value3, value4, value5);

                            })

                        })

                    })
                })

            })



        }

        if ($("#aktpenjualandetail-jenis_diskon").val() == "3")
        {

            $('.diskon-nominal').show();
            hide_bertingkat();
            $(".diskon-persen").hide();

            // $("#harga").val(formatNumber(harga_tetap));
            $("#diskon-persen").val(0)
            $("#diskon-1").val(0)
            $("#diskon-2").val(0)
            $("#diskon-3").val(0)
            $("#diskon-4").val(0)
            $("#diskon-5").val(0)


            $("#diskon-nominal").change(function() {
               var value = $(this).val();
               var value_not_titik = hilang_titik(harga_tetap);
               var last_value = value_not_titik - value;
            //    $("#harga").val(formatNumber(last_value));
            })

        }
    
    });

    let harga = document.querySelector('#harga');
    let harga_tetap = document.querySelector('#harga_tetap');
    harga.addEventListener('keyup', function(e){
        harga.value = formatRupiah(this.value);
        harga_tetap.value = this.value;
    });
    
    function formatNumber (number) {
        const formatNumbering = new Intl.NumberFormat("id-ID");
        return formatNumbering.format(number);
    };
    
    function formatRupiah(angka){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }
    
    $('#id-harga-jual').on('change', function(){
        var id = $(this).val();
        $.ajax({
            url:'index.php?r=akt-penjualan-detail/get-harga-item',
            type : 'GET',
            data : 'id='+id,
            success : function(data){
                let dataJson = $.parseJSON(data);
                let hargaSatuan = formatNumber(dataJson.harga_satuan);
                harga.value = hargaSatuan;
                harga_tetap.value = dataJson.harga_satuan;
            }
        })
    })

JS;
$this->registerJs($script);
?>

<script>
    const elements = document.querySelectorAll('.diskon-floating');
    for (var i = 0; i < elements.length; i++) {
        elements[i].oninvalid = function(e) {
            e.target.setCustomValidity("");
            if (!e.target.validity.valid) {
                e.target.setCustomValidity("Diskon hanya menerima inputan angka dan titik");
            }
        };
        elements[i].oninput = function(e) {
            e.target.setCustomValidity("");
        };
    }
    const kasBank = document.querySelector('#kas-bank');
    const uangMuka = document.querySelector('#aktpenjualan-uang_muka');
    const idKasBank = document.querySelector('#id_kas_bank');

    if (uangMuka.value != 0) {
        kasBank.classList.remove('style-kas-bank')
    }

    uangMuka.addEventListener("input", function(e) {
        uangMuka.value = formatRupiah(this.value);
        let val = e.target.value;
        if (val == '' || val == 0) {
            kasBank.classList.add('style-kas-bank');
            idKasBank.removeAttribute('required');
        } else {
            kasBank.classList.remove('style-kas-bank');
            idKasBank.setAttribute('required', true);
        }
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>