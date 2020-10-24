<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalStokDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-saldo-awal-stok-detail-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-box"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?php $form = ActiveForm::begin(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'id_item')->widget(Select2::classname(), [
                                    'data' => $data_item,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_detail'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Pilih Barang')
                                ?>
                                <?= $form->field($model, 'id_item_stok')->widget(DepDrop::classname(), [
                                        'data' => $data_level,
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'options' => ['id'=>'id-item-stok', 'placeholder' => 'Pilih Gudang'],
                                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                        'pluginOptions' => [
                                            'depends' => ['id_item_detail'],
                                            'url'=>Url::to(['/akt-saldo-awal-stok/level-harga'])
                                        ]
                                    ])->label('Pilih Gudang');
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'qty')->textInput() ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-saldo-awal-stok/view', 'id' => $model->id_saldo_awal_stok], ['class' => 'btn btn-warning']) ?>
                            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
