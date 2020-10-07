<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\AktAkun;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmumDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-jurnal-umum-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-edit"></span> Jurnal Umum Detail</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_jurnal_umum')->textInput(['type' => 'hidden'])->label(false) ?>

                    <div class="row">
                        <div class="col-md-6">

                            <?= $form->field($model, 'id_akun')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(
                                    AktAkun::find()->all(),
                                    'id_akun',
                                    function ($model) {
                                        return $model['kode_akun'] . ' - ' . $model['nama_akun'];
                                    }
                                ),
                                // 'prompt' => 'Pilih Mata Uang ',
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Akun'],
                                'pluginOptions' => [
                                    // 'allowClear' => true,
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ])->label('Akun') ?>

                            <?= $form->field($model, 'debit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>

                            <?= $form->field($model, 'kredit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 9]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum], ['class' => 'btn btn-warning']) ?>
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
    $(document).ready(function () {
        if ($('#aktjurnalumumdetail-kredit').val() > '0') {
            $('#aktjurnalumumdetail-debit').attr('readonly', 'true');
            // console.log('okk');
        } else if ($('#aktjurnalumumdetail-debit').val() > '0') {
            $('#aktjurnalumumdetail-kredit').attr('readonly', 'true');
            // console.log('o');
        } 
    })
JS;

$this->registerJs($script);

?>