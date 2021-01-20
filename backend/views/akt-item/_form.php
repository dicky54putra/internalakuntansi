<?php

// use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use backend\models\AktItemTipe;
use backend\models\AktMerk;
use backend\models\AktSatuan;
use backend\models\AktMitraBisnis;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use backend\models\AktLevelHarga;
use backend\models\AktSales;
use yii\helpers\Utils;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItem */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    .btn-loading {
        background-color: #a0aec0;
        border: none;
        cursor: not-allowed;
    }

    .btn-loading:hover {
        background-color: #a0aec0;
    }

    .form-tipe.submitted input:invalid {
        border-bottom: 1px solid red;
    }

    .form-tipe.submitted input:valid {
        border-bottom: 1px solid green;
    }
</style>

<div class="akt-item-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> Barang</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'kode_item')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                            <?= $form->field($model, 'barcode_item')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'nama_item')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'nama_alias_item')->textInput(['maxlength' => true]) ?>
                            <?=
                                $form->field($model, 'id_tipe_item')->widget(Select2::classname(), [
                                    'data' => $model->isNewRecord ? '' : ArrayHelper::map(AktItemTipe::find()->all(), 'id_tipe_item', function ($model) {
                                        return  $model->nama_tipe_item;
                                    }),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Tipe Barang'],
                                    'addon' => [
                                        'prepend' => [
                                            'content' => Html::button(Html::icon('plus'), [
                                                'style' => 'height:34px',
                                                'class' => 'btn btn-success',
                                                'data-toggle' => 'modal',
                                                'data-target' => "#modalCreateTipe"
                                            ]),
                                            'asButton' => true
                                        ],
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Tipe Barang');
                            ?>
                            <?=
                                $form->field($model, 'id_merk')->widget(Select2::classname(), [
                                    'data' =>  $model->isNewRecord ? '' : ArrayHelper::map(AktMerk::find()->all(), 'id_merk', function ($model_merk) {
                                        return $model_merk->kode_merk . ' - ' . $model_merk->nama_merk;
                                    }),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Merk'],
                                    'addon' => [
                                        'prepend' => [
                                            'content' => Html::button(Html::icon('plus'), [
                                                'style' => 'height:34px',
                                                'class' => 'btn btn-success',
                                                'data-toggle' => 'modal',
                                                'data-target' => "#modalCreateMerk"
                                            ]),
                                            'asButton' => true
                                        ],
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Merk');
                            ?>
                        </div>
                        <div class="col-lg-6">


                            <?=
                                $form->field($model, 'id_satuan')->widget(Select2::classname(), [
                                    'data' => $model->isNewRecord ? '' :  ArrayHelper::map(AktSatuan::find()->all(), 'id_satuan', 'nama_satuan'),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Satuan'],
                                    'addon' => [
                                        'prepend' => [
                                            'content' => Html::button(Html::icon('plus'), [
                                                'style' => 'height:34px',
                                                'class' => 'btn btn-success',
                                                'data-toggle' => 'modal',
                                                'data-target' => "#modalCreateSatuan"
                                            ]),
                                            'asButton' => true
                                        ],
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Satuan');
                            ?>

                            <?=
                                $form->field($model, 'id_mitra_bisnis')->widget(Select2::classname(), [
                                    'data' =>  $model->isNewRecord ? '' :  ArrayHelper::map(AktMitraBisnis::find()->all(), 'id_mitra_bisnis', function ($model_mitra_bisnis) {
                                        return $model_mitra_bisnis->kode_mitra_bisnis . ' - ' . $model_mitra_bisnis->nama_mitra_bisnis;
                                    }),
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Mitra Bisnis'],
                                    'addon' => [
                                        'prepend' => [
                                            'content' => Html::button(Html::icon('plus'), [
                                                'style' => 'height:34px',
                                                'class' => 'btn btn-success',
                                                'data-toggle' => 'modal',
                                                'data-target' => "#modalCreateMitraBisnis"
                                            ]),
                                            'asButton' => true
                                        ],
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Mitra Bisnis');
                            ?>



                            <?= $form->field($model, 'keterangan_item')->textarea(['rows' => 5]) ?>

                            <?= $form->field($model, 'status_aktif_item')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

                <!-- Modal Create Tipe -->
                <div class="modal fade" id="modalCreateTipe" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Tambah Tipe Barang</h4>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-tipe"> </div>
                                <form class="form-tipe">
                                    <div class="form-group">
                                        <label for="nama_tipe_barang"> Nama Tipe Barang </label>
                                        <input type="text" id="nama_tipe_barang" class="form-control" name="Tipe Barang">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" id="btn-simpan">
                                            <i class="glyphicon glyphicon-floppy-saved"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- END Modal Create Tipe -->

                <!-- Merk -->
                <div class="modal fade" id="modalCreateMerk" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Tambah Merk Barang</h4>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-merk"> </div>
                                <form class="form-merk">
                                    <?= $form->field($model_merk, 'kode_merk')->textInput(['maxlength' => true, 'name' => 'Kode Merk', 'readonly' => true,  'id' => 'kode_merk']) ?>
                                    <div class="form-group">
                                        <label for="nama_merk"> Nama Merk </label>
                                        <input type="text" id="nama_merk" class="form-control" name="Merk">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" id="btn-merk">
                                            <i class="glyphicon glyphicon-floppy-saved"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Satuan -->
                <div class="modal fade" id="modalCreateSatuan" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Tambah Satuan</h4>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-satuan"> </div>
                                <form class="form-satuan">
                                    <?= $form->field($model_satuan, 'nama_satuan')->textInput(['maxlength' => true, 'id' => 'nama-satuan', 'name' => 'Satuan']) ?>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" id="btn-satuan">
                                            <i class="glyphicon glyphicon-floppy-saved"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Mitra Bisnis -->
                <div class="modal fade" id="modalCreateMitraBisnis" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Tambah Mitra Bisnis</h4>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-mitra-bisnis"> </div>
                                <form class="form-mitra-bisnis">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <?= $form->field($model_mitra_bisnis, 'kode_mitra_bisnis')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'kode_mitra_bisnis']) ?>

                                            <?= $form->field($model_mitra_bisnis, 'nama_mitra_bisnis')->textInput(['maxlength' => true, 'id' => 'nama_mitra_bisnis', 'name' => 'Nama Mitra Bisnis']) ?>

                                            <?= $form->field($model_mitra_bisnis, 'deskripsi_mitra_bisnis')->textarea(['rows' => 5, 'id' => 'deskripsi_mitra_bisnis', 'name' => 'Deskripsi Mitra Bisnis']) ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?= $form->field($model_mitra_bisnis, 'tipe_mitra_bisnis')->dropDownList(array(1 => "Customer", 2 => "Supplier", 3 => "Customer & Supplier")) ?>

                                            <?= $form->field($model_mitra_bisnis, 'status_mitra_bisnis')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" id="btn-mitra-bisnis">
                                            <i class="glyphicon glyphicon-floppy-saved"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <?php
                $script = <<< JS
                const btn_simpan = document.querySelector('#btn-simpan');
                const form_tipe = document.querySelector('.form-tipe');

                const btn_merk = document.querySelector('#btn-merk');
                const form_merk = document.querySelector('.form-merk');

                const btn_satuan = document.querySelector('#btn-satuan');
                const form_satuan = document.querySelector('.form-satuan');

                const btn_mitra_bisnis = document.querySelector('#btn-mitra-bisnis');
                const form_mitra_bisnis = document.querySelector('.form-mitra-bisnis');
                
                const inner_loading = '<i class="fa fa-circle-o-notch fa-spin" style="margin-right:5px;"></i>Loading';
                const inner_saved = '<i class="glyphicon glyphicon-floppy-saved"></i> Simpan';
                

                if (window.location.href.indexOf("update") < 1) {
                    callback('#aktitem-id_tipe_item', 'akt-item-tipe/get-tipe-barang&sort=0');
                    callback('#aktitem-id_merk', 'akt-merk/get-merk-barang&sort=0');
                    callback('#aktitem-id_satuan', 'akt-satuan/get-satuan-barang&sort=0');
                    callback('#aktitem-id_mitra_bisnis', 'akt-mitra-bisnis/get-mitra-bisnis&sort=0');
                } else {
                    setKode();
                }

                async function setKode () {
                    const kodeMerk = await fetchData("akt-merk/get-kode-merk"); 
                    const kode = document.querySelector('#kode_merk');
                    kode.value = kodeMerk;

                    const kodeMitraBisnis = await fetchData("akt-mitra-bisnis/get-kode-mitra-bisnis"); 
                    const kodeMB = document.querySelector('#kode_mitra_bisnis');
                    kodeMB.value = kodeMitraBisnis;
                }
               
              
                    function setLoading(state, btn) { 
                        if(state == true ) {
                            btn.classList.remove('btn-success');
                            btn.classList.add('btn-loading');
                            btn.innerHTML = inner_loading;
                        } else {
                            btn.classList.add('btn-success');
                            btn.classList.remove('btn-loading');
                            btn.innerHTML = inner_saved;
                        }
                    }

                    function fetchCreate(objData, params ) 
                    {
                            const {idSelect, linkFetch, idModal, idNama, linkCreate, form, button} = params;

                        $.ajax({
                            url: "index.php?r=" + linkCreate,
                            method: "POST",
                            data: objData, 
                            success: function (data) {
                                createElementAlert(form, data);
                                $(idSelect).empty();
                                callback(idSelect,linkFetch);
                                setLoading(false, button);
                                hideModal(idModal, [idNama]);
                            }
                        });
                    }

                    function createElement(errors, input){
                        const el = document.createElement("span");
                        el.innerHTML = errors.error;
                        el.style.padding = '20px 0 0 0';
                        el.classList.add('text-danger');
                        el.classList.add('text-sm');
                        el.classList.add('span-error');
                        const div = document.getElementById(input.id);
                        insertBefore(div, el);
                    }

                    function createElementAlert(formClass, msg){
                        const el = document.createElement("div");
                        el.innerHTML = msg;
                        el.classList.add('alert');
                        el.classList.add('alert-success');
                        el.classList.add('display-alert');
                        const div = document.querySelector(formClass);
                        insertBefore(div, el);
                    }

                    function validation(input){
                        const nama = input.name;
                        const val = input.value;
                        const errors = {};
                        if(val == '' || val == null ) {
                            errors.error = nama + ' tidak boleh kosong.';
                        }
                        return {
                            errors,
                            valid: Object.keys(errors).length < 1,
                        };
                    }

                    function submitMerk(e) {
                        e.preventDefault();
                        setLoading(true, btn_merk);
                        const tempData = [];
                        for(let i = 0 ; i < e.target.length-1 ; i++) {
                            const input = e.target[i];
                            const { errors, valid } =  validation(input);
                            if (!valid ) {
                                createElement(errors, input);
                                setLoading(false, btn_merk);
                            } else {    
                                tempData.push({
                                    data : input.value
                                });
                            }
                        }

                        const [kode_merk, nama_merk] = tempData.map(item => item.data);
                        const objData = {
                            kode_merk : kode_merk,
                            nama_merk : nama_merk
                        };

                        const params = {
                            "linkCreate" : "akt-merk/create-merk",
                            "linkFetch" : "akt-merk/get-merk-barang&sort=1",
                            "idModal" : "#modalCreateMerk",
                            "idSelect" :'#aktitem-id_merk',
                            "idNama" : "#nama_merk",
                            'form' : '.modal-body-merk', 
                            'button' : btn_merk,

                        }

                        fetchCreate(objData, params);

                    }

                    function submitMitraBisnis(e) {
                        e.preventDefault();
                        setLoading(true, btn_mitra_bisnis);
                        const tempData = [];
                        for(let i = 0 ; i < e.target.length-1 ; i++) {
                            const input = e.target[i];
                            const { errors, valid } =  validation(input);
                            if (!valid ) {
                                createElement(errors, input);
                                setLoading(false, btn_mitra_bisnis);
                            } else {    
                                tempData.push({
                                    data : input.value
                                });
                            }
                        }

                        const [kode_mitra_bisnis, nama_mitra_bisnis, deskripsi_mitra_bisnis, tipe_mitra_bisnis, status_mitra_bisnis] = tempData.map(item => item.data);
                        const objData = {
                            kode_mitra_bisnis : kode_mitra_bisnis,
                            nama_mitra_bisnis : nama_mitra_bisnis,
                            deskripsi_mitra_bisnis : deskripsi_mitra_bisnis,
                            tipe_mitra_bisnis : tipe_mitra_bisnis,
                            status_mitra_bisnis : status_mitra_bisnis,
                        };

                        const params = {
                            "linkCreate" : "akt-mitra-bisnis/create-mitra-bisnis",
                            "linkFetch" : "akt-mitra-bisnis/get-mitra-bisnis&sort=1",
                            "idModal" : "#modalCreateMitraBisnis",
                            "idSelect" :'#aktitem-id_mitra_bisnis',
                            "idNama" : [ "#nama_mitra_bisnis", "#deskripsi_mitra_bisnis" ],
                            'form' : '.modal-body-mitra-bisnis', 
                            'button' : btn_mitra_bisnis,
                        }

                        fetchCreate(objData, params);

                    }
                   
                    function submitTipe(e) {
                        e.preventDefault();
                        setLoading(true, btn_simpan);

                        $(e.target).each(function(index){
                            const input = $(this).find('input')
                            const {errors, valid } =  validation(input[index]);
                            if (!valid ) {
                                createElement(errors, input[index]);
                                setLoading(false, btn_simpan);
                            } 
                            const objData = {
                                nama_tipe_item : input[index].value
                            };

                            const params = {
                                "linkCreate" : "akt-item-tipe/create-tipe",
                                "linkFetch" : "akt-item-tipe/get-tipe-barang&sort=1",
                                "idModal" : "#modalCreateTipe",
                                'form' : '.modal-body-tipe', 
                                "idSelect" :'#aktitem-id_tipe_item',
                                "idNama" : "#nama_tipe_barang",
                                'button' : btn_simpan,
                            }

                            fetchCreate(objData, params);
                        });
                    }

                    function submitSatuan(e) {
                        e.preventDefault();
                        setLoading(true, btn_satuan);

                        $(e.target).each(function(index){
                            const input = $(this).find('input')
                            const {errors, valid } =  validation(input[index]);
                            if (!valid ) {
                                createElement(errors, input[index]);
                                setLoading(false, btn_satuan);
                            } 
                            const objData = {
                                nama_satuan : input[index].value
                            };

                            const params = {
                                "linkCreate" : "akt-satuan/create-satuan",
                                "linkFetch" : "akt-satuan/get-satuan-barang&sort=1",
                                "idModal" : "#modalCreateSatuan",
                                'form' : '.modal-body-satuan', 
                                "idSelect" :'#aktitem-id_satuan',
                                "idNama" : "#nama-satuan",
                                'button' : btn_satuan,
                            }

                            fetchCreate(objData, params);
                        });
                    }

                    form_tipe.addEventListener("submit", function(e) {
                        submitTipe(e);
                    });

                    form_merk.addEventListener("submit", function(e) {
                        submitMerk(e);
                    });
                    form_satuan.addEventListener("submit", function(e) {
                        submitSatuan(e);
                    });
                    form_mitra_bisnis.addEventListener("submit", function(e) {
                        submitMitraBisnis(e);
                    });

                    function hideModal(idModal,idNama = []) {
                        deleteElement('.span-error');
                        setLoading(false, btn_simpan);
                
                        if( idNama.length == 1 ) {
                            let nama_tipe_barang = document.querySelector(idNama);
                            setTimeout(() => {
                                $(idModal).modal('hide');
                                nama_tipe_barang.value = '';
                                deleteElement('.display-alert');
                            }, 1500);

                        } 
                        
                    }

                    function deleteElement(classEl) {
                        let el = document.querySelector(classEl);
                        if(el != null ) {
                            el.remove();
                        }
                    }


                    function insertBefore(referenceNode, newNode) {
                        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
                    }
                   
                    
                   async function callback(idSelect, link)
                    {
                            
                            const kodeMerk = await fetchData("akt-merk/get-kode-merk"); 
                            const kode = document.querySelector('#kode_merk');
                            kode.value = kodeMerk;

                            const kodeMitraBisnis = await fetchData("akt-mitra-bisnis/get-kode-mitra-bisnis"); 
                            const kodeMB = document.querySelector('#kode_mitra_bisnis');
                            kodeMB.value = kodeMitraBisnis;
                            // $(idSelect).empty();
                            const data = await fetchData(link);
                            const select = document.querySelector(idSelect);
                            // $(idSelect).empty();
                            for (let i in data) {

                                if(idSelect == '#aktitem-id_tipe_item' ) {
                                    $(select).append('<option value=' + data[i].id_tipe_item + '>' + data[i].nama_tipe_item + '</option>');
                                } else if(idSelect == '#aktitem-id_merk' ) {
                                    $(select).append('<option value=' + data[i].id_merk + '>' + data[i].kode_merk  + ' - ' + data[i].nama_merk + '</option>');
                                } else if(idSelect == '#aktitem-id_satuan' ) {
                                    $(select).append('<option value=' + data[i].id_satuan + '>' + data[i].nama_satuan + '</option>');
                                } else if(idSelect == '#aktitem-id_mitra_bisnis' ) {
                                    // console.log(data);
                                    $(select).append('<option value=' + data[i].id_mitra_bisnis + '>' + data[i].kode_mitra_bisnis + ' - ' + data[i].nama_mitra_bisnis + '</option>');
                                } 
                            }
                            $(select).val(data[1]);
                    }


                    async function fetchData(link)
                    {
                        let data;
                        const get = await fetch("index.php?r=" + link)
                        .then(res => res.json())
                        .then(response => {
                            data = response;
                        })
                        .catch(err => console.log(err));
                        return data;
                    }


                   

JS;
                $this->registerJs($script);
                ?>

                <script>
                    console.log("HAI");
                    fetch(`index.php?r=akt-mitra-bisnis/get-mitra-bisnis&sort=0`)
                        .then(res => res.json())
                        .then(result => console.log(result));
                </script>