<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penerimaan-pembayaran-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-money-check-alt"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'tanggal_penerimaan_pembayaran')->widget(\yii\jui\DatePicker::classname(), [
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]) ?>

                    <?= $form->field($model, 'jenis_penerimaan')->dropDownList(
                        array(
                            1 => "Penjualan Barang",
                            2 => "Penjualan Harta Tetap"
                        ),
                        ['prompt' => 'Pilih Jenis Penerimaan']
                    ) ?>

                    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?php
                        if ($model->isNewRecord) {
                            # code...
                            $url = ['index'];
                        } else {
                            # code...
                            $url = ['view', 'id' => $model->id_penerimaan_pembayaran_penjualan];
                        }

                        ?>
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>