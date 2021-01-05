<?php

// use yii\helpers\Html;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemStok */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-item-stok-form">
    <div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?=
                                $form->field($model, 'id_gudang')->widget(Select2::classname(), [
                                    'data' => $model->isNewRecord ? '' :  $data_gudang,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Gudang'],
                                    'addon' => [
                                        'prepend' => [
                                            'content' => Html::button(Html::icon('plus'), [
                                                'style' => 'height:34px',
                                                'class' => 'btn btn-success',
                                                'data-toggle' => 'modal',
                                                'data-target' => "#modalCreateGudang"
                                            ]),
                                            'asButton' => true
                                        ],
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Gudang');
                            ?>


                            <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'qty')->textInput(['readonly' => true]) ?>
                        </div>
                        <div class="col-md-6">

                            <?= $form->field($model, 'hpp')->widget(\yii\widgets\MaskedInput::className(), [
                                'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                'options' => ['required' => true]
                            ]); ?>

                            <?= $form->field($model, 'min')->widget(\yii\widgets\MaskedInput::className(), [
                                'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0,],
                                'options' => ['required' => true]
                            ]); ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <?= $form->field($model, 'id_item')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-item/view', 'id' => $model->id_item], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

                <!-- gudang -->
                <div class="modal fade" id="modalCreateGudang" tabindex="-1" role="dialog" data aria-labelledby="modalLabelLarge" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Tambah Gudang</h4>
                            </div>
                            <div class="modal-body">
                                <div class="modal-body-gudang"> </div>
                                <form class="form-gudang">
                                    <?= $form->field($model_gudang, 'kode_gudang')->textInput(['readonly' => true, 'id' => 'kode_gudang']) ?>

                                    <?= $form->field($model_gudang, 'nama_gudang')->textInput(['maxlength' => true, 'id' => 'nama_gudang', 'name' => 'Nama Gudang']) ?>

                                    <?= $form->field($model_gudang, 'status_aktif_gudang')->dropDownList(array(1 => 'Aktif', 2 => 'Tidak Aktif'), ['id' => 'status_aktif_gudang']) ?>
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

                <?php
                $script = <<< JS
                const btn_simpan = document.querySelector('#btn-simpan');
                const form_gudang = document.querySelector('.form-gudang');
                
                const inner_loading = '<i class="fa fa-circle-o-notch fa-spin" style="margin-right:5px;"></i>Loading';
                const inner_saved = '<i class="glyphicon glyphicon-floppy-saved"></i> Simpan';
                

                if (window.location.href.indexOf("update") < 1) {
                    callback('#aktitemstok-id_gudang', 'akt-gudang/get-gudang&sort=0');
                } else {
                    setKode();
                }

                async function setKode () {
                    const kodeGudang = await fetchData("akt-gudang/get-kode-gudang"); 
                    const kode = document.querySelector('#kode_gudang');
                    kode.value = kodeGudang;
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

                        const [kode_gudang, nama_gudang,status_aktif_gudang ] = tempData.map(item => item.data);
                        const objData = {
                            kode_gudang : kode_gudang,
                            nama_gudang : nama_gudang,
                            status_aktif_gudang : status_aktif_gudang,
                        };

                        const params = {
                            "linkCreate" : "akt-gudang/create-gudang",
                            "linkFetch" : "akt-gudang/get-gudang&sort=1",
                            "idModal" : "#modalCreateGudang",
                            "idSelect" :'#aktitemstok-id_gudang',
                            "idNama" : "#nama_gudang",
                            'form' : '.modal-body-gudang', 
                            'button' : btn_simpan,

                        }

                        fetchCreate(objData, params);

                    }


                    form_gudang.addEventListener("submit", function(e) {
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
                                $(select).append('<option value=' + data[i].id_gudang + '>' + data[i].kode_gudang  + ' - ' + data[i].nama_gudang + '</option>');
                                
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