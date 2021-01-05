<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AktKota;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktSales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-sales-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-street-view"></span> Sales</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'kode_sales')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                            <?= $form->field($model, 'nama_sales')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'alamat')->textarea(['rows' => 5]) ?>

                            <?=
                                $form->field($model, 'id_kota')->widget(Select2::classname(), [
                                    'data' => $model->isNewRecord ? '' :  $data_kota,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Kota'],
                                    'addon' => [
                                        'prepend' => [
                                            'content' => Html::button(Html::icon('plus'), [
                                                'style' => 'height:34px',
                                                'class' => 'btn btn-success',
                                                'data-toggle' => 'modal',
                                                'data-target' => "#modalCreateKota"
                                            ]),
                                            'asButton' => true
                                        ],
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Kota');
                            ?>

                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'kode_pos')->textInput() ?>

                            <?= $form->field($model, 'telepon')->textInput() ?>

                            <?= $form->field($model, 'handphone')->textInput() ?>

                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'status_aktif')->dropDownList(array(1 => "Aktif", 2 => "Tidak Aktif")) ?>

                        </div>
                    </div>



                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-sales/index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>

            <!-- Kota -->
            <div class="modal fade" id="modalCreateKota" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Tambah Kota</h4>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body-kota"> </div>
                            <form class="form-kota">
                                <?= $form->field($model_kota, 'kode_kota')->textInput(['maxlength' => true, 'readonly' => true, 'id' => 'kode_kota', 'name' => 'Kode Kota']) ?>

                                <?= $form->field($model_kota, 'nama_kota')->textInput(['maxlength' => true, 'id' => 'nama_kota', 'name' => 'Nama Kota']) ?>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" id="btn-simpan-kota">
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
                const btn_simpan = document.querySelector('#btn-simpan-kota');
                const form_kota = document.querySelector('.form-kota');
                
                const inner_loading = '<i class="fa fa-circle-o-notch fa-spin" style="margin-right:5px;"></i>Loading';
                const inner_saved = '<i class="glyphicon glyphicon-floppy-saved"></i> Simpan';
                

                if (window.location.href.indexOf("update") < 1) {
                    callback('#aktsales-id_kota', 'akt-kota/get-kota&sort=0');
                } else {
                    setKode();
                }

                async function setKode () {
                    const kodeKota = await fetchData("akt-kota/get-kode-kota"); 
                    const kode = document.querySelector('#kode_kota');
                    kode.value = kodeKota;
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

                    function submitKota(e) {
                        e.preventDefault();
                        setLoading(true, btn_simpan);
                        const tempData = [];
                        for(let i = 0 ; i < e.target.length-1 ; i++) {
                            const input = e.target[i];
                            const { errors, valid } =  validation(input);
                            if (!valid ) {
                                createElement(errors, input);
                                setLoading(false, btn_simpan);
                            } else {    
                                tempData.push({
                                    data : input.value
                                });
                            }
                        }

                        const [kode_kota, nama_kota] = tempData.map(item => item.data);
                        const objData = {
                            kode_kota : kode_kota,
                            nama_kota : nama_kota
                        };

                        const params = {
                            "linkCreate" : "akt-kota/create-kota",
                            "linkFetch" : "akt-kota/get-kota&sort=1",
                            "idModal" : "#modalCreateKota",
                            "idSelect" :'#aktsales-id_kota',
                            "idNama" : "#nama_kota",
                            'form' : '.modal-body-kota', 
                            'button' : btn_simpan,

                        }

                        fetchCreate(objData, params);

                    }


                    form_kota.addEventListener("submit", function(e) {
                        submitKota(e);
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
                            
                            await setKode();

                            const data = await fetchData(link);
                            const select = document.querySelector(idSelect);

                            for (let i in data) {
                                $(select).append('<option value=' + data[i].id_kota + '>' + data[i].kode_kota  + ' - ' + data[i].nama_kota + '</option>');
                                
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