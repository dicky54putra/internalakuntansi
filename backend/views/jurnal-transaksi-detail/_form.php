<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use backend\models\AktAkun;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\JurnalTransaksiDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jurnal-transaksi-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-chart-bars"></span> Jurnal Transaksi Detail</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_jurnal_transaksi')->hiddenInput(['value' => $id_jurnal_transaksi])->label(false) ?>

                    <?= $form->field($model, 'tipe')->dropDownList(array('D' => "D", 'K' => "K")) ?>

                    <?=
                        $form->field($model, 'id_akun')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktAkun::find()->all(), 'id_akun', function ($model_akun) {
                                return $model_akun->kode_akun . ' - ' . $model_akun->nama_akun;
                            }),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Akun'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Akun');
                    ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['jurnal-transaksi/view', 'id' => $id_jurnal_transaksi], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>