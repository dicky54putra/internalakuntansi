<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetapDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-harta-tetap-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_penjualan_harta_tetap')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

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

                            <?= $form->field($model, 'qty')->textInput() ?>

                            <?= $form->field($model, 'harga')->textInput(['id' => 'harga']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'diskon')->textInput() ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 5]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-penjualan-harta-tetap/view', 'id' => $model->id_penjualan_harta_tetap], ['class' => 'btn btn-warning']) ?>
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