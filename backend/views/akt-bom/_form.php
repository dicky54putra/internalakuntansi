<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktItem;
use backend\models\AktItemStok;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\AktBom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-bom-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-credit-card"></span> Bill of Material</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'no_bom')->textInput(['maxlength' => true, 'readonly' => true, 'value' => $nomor]) ?>

                            <?= $form->field($model, 'keterangan')->textarea(['rows' => 5, 'style' => 'margin-top: 0px; margin-bottom: 0px; height: 108px;']) ?>

                            <?= $form->field($model, 'tipe')->dropDownList(array(1 => "De-Produksi", 2 => "Produksi")) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(AktItemStok::find()->all(), 'id_item_stok', function ($model_item) {
                                    $nama_item = Yii::$app->db->createCommand("SELECT nama_item FROM akt_item WHERE id_item = '$model_item->id_item'")->queryScalar();
                                    $gudang = Yii::$app->db->createCommand("SELECT nama_gudang FROM akt_gudang WHERE id_gudang = '$model_item->id_gudang'")->queryScalar();
                                    return $nama_item . ' - nama gudang: ' . $gudang . ' - sisa stok: ' . $model_item->qty;
                                }),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Pilih Item'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])->label('Pilih Barang');
                            ?>

                            <?= $form->field($model, 'qty')->textInput() ?>

                            <?= $form->field($model, 'total')->textInput() ?>

                            <?= $form->field($model, 'status_bom')->dropDownList(array(2 => "Belum Disetujui"))
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>