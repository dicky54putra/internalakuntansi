<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktApprover;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangDetail */
/* @var $form yii\widgets\ActiveForm */
$approve = AktApprover::find()->where(['id_jenis_approver' => 8])->all();
$id_login =  Yii::$app->user->identity->id_login;
foreach ($approve as $key => $value) {
    if ($id_login == $value['id_login']) {
        $row = "col-12 col-md-12";
    } else {
        $row = "col-6 col-lg-6";
    }
}
?>

<div class="akt-permintaan-barang-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                    <div style="margin-top:-18px;">
                    <?= $form->field($model, 'id_permintaan_barang')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                    <?= $form->field($model, 'id_item')->widget(Select2::classname(), [
                            'data' => $data_item,
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Barang'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Barang');
                    ?>
                    <?= $form->field($model, 'qty')->textInput() ?>
                    <?php
                    foreach ($approve as $key => $value) {
                        if ($id_login == $value['id_login']) {
                    ?>

                    <?= $form->field($model, 'qty_ordered')->textInput() ?>
                    <?= $form->field($model, 'qty_rejected')->textInput() ?>
                    <?php } 
                    }
                    ?>
                    <?= $form->field($model, 'keterangan')->textarea(['rows' => 4]) ?>
                    </div>
                    

                   

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
