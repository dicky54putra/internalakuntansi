<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktItem;
use backend\models\AktProyek;
use backend\models\AktDepartement;
use backend\models\AktSatuan;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPermintaanPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-permintaan-pembelian-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> Barang</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                        'data' => $array_item,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Barang'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Stok Barang');
                    ?>

                    <?= $form->field($model, 'quantity')->textInput() ?>

                    <?=
                        $form->field($model, 'satuan')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(AktSatuan::find()->all(), 'id_satuan', 'nama_satuan'),
                            'language' => 'en',
                            'options' => ['placeholder' => 'Pilih Satuan'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('Pilih Satuan');
                    ?>




                    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>



                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-permintaan-pembelian/view', 'id' => $_GET['id']], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                <!-- 
<style >
    span.select2.select2-container.select2-container--krajee {
    display: none;
}
</style> -->