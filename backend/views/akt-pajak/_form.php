<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;
use backend\models\AktAkun;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPajak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-pajak-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-hand-holding-usd"></span> Pajak</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
        <?= $form->field($model, 'kode_pajak')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

<?= $form->field($model, 'nama_pajak')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'id_akun_pembelian')->dropDownList(
    ArrayHelper::map(
        AktAkun::find()->all(),
        'id_akun',
        function ($model) {
            return $model->nama_akun;
        }
    ),
    ['prompt' => 'Pilih Akun']
) ?>
        </div>
        <div class="col-lg-6">
        <?= $form->field($model, 'id_akun_penjualan')->dropDownList(
                        ArrayHelper::map(
                            AktAkun::find()->all(),
                            'id_akun',
                            function ($model) {
                                return $model->nama_akun;
                            }
                        ),
                        ['prompt' => 'Pilih Akun']
                    ) ?>

                    <?= $form->field($model, 'presentasi_npwp')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'presentasi_non_npwp')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
                    

                   

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-pajak/index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>