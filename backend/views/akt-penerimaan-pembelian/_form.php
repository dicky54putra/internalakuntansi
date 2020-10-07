<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\AktCabang;
use backend\models\AktMitraBisnis;


/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penerimaan-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-check"></span> Penerimaan Pembelian</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'no_penerimaan')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

    <?= $form->field($model, 'no_ref')->textInput(['maxlength' => true])->label('No. Ref.') ?>


    <?php if ($model->tanggal == "0000-00-00" || $model->tanggal == "")
                {
                    $model->tanggal =  Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');

                }  ?>

    <?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
            'clientOptions' => [
                        'changeMonth'=>true, 
                        'changeYear'=>true,
            ],
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control']
    ]) ?>

    <?= $form->field($model, 'id_supplier')->dropDownList(
        ArrayHelper::map(
            AktMitraBisnis::find()->all(),
            'id_mitra_bisnis',
            function ($model) {
                return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
            }
        ),
        [
            'prompt' => 'Pilih Supplier ',
        ]
    )->label('Supplier'); ?>

    <?= $form->field($model, 'id_penerima')->textInput() ?>

    <?php if ($model->status_invoiced == "0" || $model->status_invoiced == "")
            {
                $model->status_invoiced =  0;

                if ($model->status_invoiced > 0 ) {

                    $stat = "ON";

                } else {

                    $stat = "OFF";

                }
            }
        ?>

    <?= $form->field($model, 'status_invoiced')->textInput(['value' => $stat, 'readonly' => true]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_cabang')->dropDownList(
        ArrayHelper::map(
            AktCabang::find()->all(),
            'id_cabang',
            function ($model) {
                return $model['kode_cabang'] . ' - ' . $model['nama_cabang'];
            }
        ),
        [
            'prompt' => 'Pilih Cabang ',
        ]
    )->label('Cabang'); ?>

    <?= $form->field($model, 'draft')->dropDownList(array(1 => 'Aktif', 2 => 'Nonaktif'))->label('Draft') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
