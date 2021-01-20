<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPembelianHartaTetap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-pembelian-harta-tetap-form">
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-shopping-cart"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'id_harta_tetap')->widget(Select2::classname(), [
                        'data' => $array_item,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Jenis Harta Tetap'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Harta Tetap');
                    ?>

                    <?= $form->field($model, 'harga')->textInput() ?>

                    <?= $form->field($model, 'diskon')->textInput() ?>

                    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali',  ['akt-pembelian-harta-tetap/view', 'id' => $model->id_pembelian_harta_tetap], ['class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>