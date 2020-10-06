<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Arrayhelper;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktKota;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penjualan-pengiriman-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'options' => [
            'data-pjax' => 1,
            'id' => 'create-product-form',
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'no_pengiriman')->textInput(['readonly' => true]) ?>

            <?= $form->field($model, 'tanggal_pengiriman')->widget(\yii\jui\DatePicker::classname(), [
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>

            <?= $form->field($model, 'foto_resi')->fileInput() ?>

            <?php
            if ($model->foto_resi != "") {
                echo "<img src='upload/$model->foto_resi' width='150'><br>";
            }
            ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'pengantar')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'id_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

            <?= $form->field($model, 'id_mitra_bisnis_alamat')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(
                    AktMitraBisnisAlamat::find()
                        ->where(['id_mitra_bisnis' => $model_penjualan->id_customer])
                        ->andWhere(['!=', 'alamat_pengiriman_penagihan', 2])
                        ->orderBy("akt_mitra_bisnis_alamat.keterangan_alamat")
                        ->all(),
                    'id_mitra_bisnis_alamat',
                    'keterangan_alamat'
                ),
                'language' => 'en',
                'options' => ['placeholder' => 'Pilih Alamat Pengantaran'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'addon' => [
                    'prepend' => [
                        'content' => '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-tambah-data-alamat-pengiriman" data-dismiss="modal"><span class="glyphicon glyphicon-plus"></span></button>',
                        'asButton' => true,
                    ],
                ],
            ])
            ?>

            <?= $form->field($model, 'keterangan_pengantar')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <br>

    <div class="form-group">
        <?php
        $nama_button = "Simpan";
        $span = '<span class="glyphicon glyphicon-floppy-saved"></span>';
        if ($model->isNewRecord) {
            # code...
            $nama_button = "Tambah";
            $span = '<span class="glyphicon glyphicon-plus"></span>';
        }
        ?>
        <?= Html::submitButton('' . $span . ' ' . $nama_button . '', ['class' => 'btn btn-success', 'style' => ['float' => 'right']]) ?>
        &nbsp;
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>