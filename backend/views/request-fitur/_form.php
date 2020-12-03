<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Arrayhelper;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\RequestFitur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-fitur-form">
<div class="box">
<div class="box-header">
<div class="col-md-12" style="padding: 0;">
<div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?php
	if ($model->isNewRecord)
	{
		$model->tanggal = date("Y-m-d H:i:s");
	}
	
	
    echo '<label>Tanggal</label>';
    echo DateTimePicker::widget([
        'name' 			=> 'RequestFitur[tanggal]',
        'value' 		=> $model->tanggal,
        'options' 		=> ['placeholder' => 'Pilih tanggal dan jam...'],
        'layout' 		=> '{input}{remove}{picker}',
        'removeButton' 	=> ['position' => 'append'],
        'pluginOptions' => [
            'autoclose'	=>true,      
            'format' 	=> 'yyyy-mm-dd hh:ii',
            'todayHighlight' => true
        ]
    ]);
    echo "<br>";
    ?>

    <?= $form->field($model, 'id_login')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(array(1=>"Submission",2=>"On Progress",3=>"Completed")) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
