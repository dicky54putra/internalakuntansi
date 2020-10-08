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
/* @var $model backend\models\ItemPembelian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-pembelian-form">

    <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
                        'data' => $array_item,
                        'language' => 'en',
                        'options' => ['placeholder' => 'Pilih Barang'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('Nama Barang');
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

    <?= $form->field($model, 'harga')->textInput() ?>

    <?= $form->field($model, 'diskon')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
