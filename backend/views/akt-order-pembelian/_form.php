<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktMataUang;
use backend\models\AktCabang;
use backend\models\AktMitraBisnis;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktOrderPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-order-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-check"></span> Order Pembelian</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'no_order')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                    <?php if ($model->tanggal_order == "0000-00-00" || $model->tanggal_order == "") {
                        $model->tanggal_order =  Yii::$app->formatter->asDate('now', 'yyyy-MM-dd');
                    }  ?>

                    <?= $form->field($model, 'tanggal_order')->widget(\yii\jui\DatePicker::classname(), [
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]) ?>

                    <?php if ($model->status_order == "0" || $model->status_order == "") {
                        $model->status_order =  1;

                        if ($model->status_order ==  1) {

                            $stat = "Aktif & Belum Terkirim";
                        } else {

                            $stat = "Nonaktif";
                        }

                    ?>

                        <?= $form->field($model, 'status_order')->textInput(['value' => $stat, 'readonly' => true]) ?>

                    <?php } else { ?>

                        <?= $form->field($model, 'status_order')->textInput(['readonly' => true]) ?>

                    <?php } ?>

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

                    <?= $form->field($model, 'id_mata_uang')->dropDownList(
                        ArrayHelper::map(
                            AktMataUang::find()->all(),
                            'id_mata_uang',
                            function ($model) {
                                return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
                            }
                        ),
                        [
                            'prompt' => 'Pilih Mata Uang ',
                        ]
                    )->label('Mata Uang'); ?>

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

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>