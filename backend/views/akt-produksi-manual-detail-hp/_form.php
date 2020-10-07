<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\AktItemStok;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManualDetailHp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-produksi-manual-detail-hp-form">
<div class="panel panel-primary">
        <div class="panel-heading"></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_produksi_manual')->hiddenInput(['value' => $id_produksi_manual])->label(false) ?>

    <?=
        $form->field($model, 'id_item_stok')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(AktItemStok::find()->all(), 'id_item_stok', function($model_item){
                $nama_item = Yii::$app->db->createCommand("SELECT nama_item FROM akt_item WHERE id_item = '$model_item->id_item'")->queryScalar();
                $gudang = Yii::$app->db->createCommand("SELECT nama_gudang FROM akt_gudang WHERE id_gudang = '$model_item->id_gudang'")->queryScalar();
                return $nama_item .' - '. $gudang .' - '. $model_item->qty;
            }),
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih Item'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Pilih Item');
    ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group" style="margin-top:50px;">
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-produksi-manual/view', 'id' => $id_produksi_manual], ['class' => 'btn btn-warning']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
