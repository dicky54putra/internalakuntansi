<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktSaldoAwalAkunDetail;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalAkunDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-saldo-awal-akun-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-check"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'id_akun')->widget(Select2::classname(), [
                                'data' => $data_akun,
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Akun','id' => 'id-akun'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Pilih Akun');
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'debet')->widget(\yii\widgets\MaskedInput::className(), [
                                'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0],'options' => ['id' => 'debet']
                            ]); ?>
                             <?= $form->field($model, 'kredit')->widget(\yii\widgets\MaskedInput::className(), [
                                'clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0],'options' => ['id' => 'kredit']
                            ]); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-saldo-awal-akun/view','id' => $model->id_saldo_awal_akun], ['class' => 'btn btn-warning']) ?>
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

    const debet = document.querySelector('.field-debet');
    const kredit = document.querySelector('.field-kredit');
    const inputDebet = document.querySelector('#debet');
    const inputKredit = document.querySelector('#kredit');
    if(inputDebet.value === '' ) {
        debet.style.display = 'none';
    } else if (inputKredit.value === '' ) {
        kredit.style.display = 'none';
    }

    $('#id-akun').on('change', function(){
        var id = $(this).val();
        $.ajax({
            url:'index.php?r=akt-saldo-awal-akun/get-saldo-normal',
            type : 'GET',
            data : 'id='+id,
            success : function(data){
                let dataJson = $.parseJSON(data);
                if(dataJson.saldo_normal === 1) {
                    debet.style.display = 'block';
                    kredit.style.display = 'none';
                } else if (dataJson.saldo_normal === 2 ) {
                    kredit.style.display = 'block';
                    debet.style.display = 'none';
                }
            }
        })
    })

     
JS;
$this->registerJs($script);
?>
