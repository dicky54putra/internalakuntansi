<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktItemStok;
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

                        </div>
                        <style>
                            .nominal_diskon {
                                display: none;
                            }
                        </style>

                        <div class="col-md-6">
                            <?= $form->field($model, 'jenis_diskon')->dropDownList(
                                array(1 => "Persen %", 2 => "Rupiah Rp."),
                                [
                                    'prompt' => 'Pilih Jenis Diskon',
                                ]
                            ) ?>
                            <div class="nominal_diskon" id="nominal_diskon">
                                <?= $form->field($model, 'diskon')->textInput(['autocomplete' => 'off', 'id' => 'diskon-floating', 'pattern' => '[+-]?([0-9]*[.])?[0-9]+']) ?>
                            </div>
                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 5]) ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-penjualan/view', 'id' => $model->id_penjualan], ['class' => 'btn btn-warning']) ?>
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
const nominalDiskon = document.querySelector("#nominal_diskon");
const jenisDiskon = document.querySelector("#aktpenjualandetail-jenis_diskon");
console.log(jenisDiskon.value);
if(jenisDiskon.value == '' ) {
    nominalDiskon.classList.add('nominal_diskon');
} else {
    nominalDiskon.classList.remove('nominal_diskon');
}

jenisDiskon.addEventListener('change', function(e) {
    if (e.target.value == 1 || e.target.value == 2) {
        nominalDiskon.classList.remove('nominal_diskon');
    } else {
        nominalDiskon.classList.add('nominal_diskon');
    }
})

const elements = document.querySelectorAll('#diskon-floating');
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

let harga = document.querySelector('#harga');
harga.addEventListener('keyup', function(e){
    harga.value = formatRupiah(this.value);
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
        }
    })
})
 
JS;
$this->registerJs($script);
?>