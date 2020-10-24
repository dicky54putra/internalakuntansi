<?php

use backend\models\AktMataUang;
use backend\models\AktMitraBisnis;
use backend\models\AktPenagih;
use backend\models\AktSales;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="akt-penawaran-penjualan-form">
	<div class="panel panel-primary">
		<div class="panel-heading"><span class="fa fa-shopping-cart"></span> <?= $this->title ?></div>
		<div class="panel-body">
			<div class="col-md-12" style="padding: 0;">
				<div class="box-body">

					<?php $form = ActiveForm::begin(); ?>

					<div class="row">
						<div class="col-md-6">

							<?= $form->field($model, 'no_penawaran_penjualan')->textInput(['readonly' => true]) ?>

							<?= $form->field($model, 'tanggal')->widget(\yii\jui\DatePicker::classname(), [
								'clientOptions' => [
									'changeMonth' => true,
									'changeYear' => true,
								],
								'dateFormat' => 'yyyy-MM-dd',
								'options' => ['class' => 'form-control', 'autocomplete' => 'off']
							]) ?>

							<?= $form->field($model, 'id_customer')->widget(Select2::classname(), [
								'data' => ArrayHelper::map(
									AktMitraBisnis::find()->where(['!=', 'tipe_mitra_bisnis', 2])->all(),
									'id_mitra_bisnis',
									function ($model) {
										return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
									}
								),
								// 'prompt' => 'Pilih Mata Uang ',
								'language' => 'en',
								'options' => ['placeholder' => 'Pilih Customer'],
								'pluginOptions' => [
									// 'allowClear' => true,
									'tags' => true,
									'tokenSeparators' => [',', ' '],
									'maximumInputLength' => 10
								],
							]) ?>

							<?= $form->field($model, 'id_sales')->widget(Select2::classname(), [
								'data' => ArrayHelper::map(
									AktSales::find()->all(),
									'id_sales',
									function ($model) {
										return $model['kode_sales'] . ' - ' . $model['nama_sales'];
									}
								),
								// 'prompt' => 'Pilih Mata Uang ',
								'language' => 'en',
								'options' => ['placeholder' => 'Pilih Sales'],
								'pluginOptions' => [
									// 'allowClear' => true,
									'tags' => true,
									'tokenSeparators' => [',', ' '],
									'maximumInputLength' => 10
								],
							]) ?>

						</div>
						<div class="col-md-6">

							<?= $form->field($model, 'id_mata_uang')->widget(Select2::classname(), [
								'data' => ArrayHelper::map(
									AktMataUang::find()->where(['id_mata_uang' => 1])->all(),
									'id_mata_uang',
									function ($model) {
										return $model['kode_mata_uang'] . ' - ' . $model['mata_uang'];
									}
								),
								// 'prompt' => 'Pilih Mata Uang ',
								'language' => 'en',
								'options' => ['placeholder' => 'Pilih Mata Uang'],
								'pluginOptions' => [
									// 'allowClear' => true,
									'tags' => true,
									'tokenSeparators' => [',', ' '],
									'maximumInputLength' => 10
								],
							]) ?>

							<?php
							// $form->field($model, 'pajak')->checkbox() 
							?>

							<?= $form->field($model, 'id_penagih')->widget(Select2::classname(), [
								'data' => ArrayHelper::map(
									AktMitraBisnis::find()->all(),
									'id_mitra_bisnis',
									function ($model) {
										return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
									}
								),
								// 'prompt' => 'Pilih Mata Uang ',
								'language' => 'en',
								'options' => ['placeholder' => 'Pilih Penagih'],
								'pluginOptions' => [
									// 'allowClear' => true,
									'tags' => true,
									'tokenSeparators' => [',', ' '],
									'maximumInputLength' => 10
								],
							]) ?>

							<?= $form->field($model, 'id_pengirim')->widget(Select2::classname(), [
								'data' => ArrayHelper::map(
									AktMitraBisnis::find()->all(),
									'id_mitra_bisnis',
									function ($model) {
										return $model['kode_mitra_bisnis'] . ' - ' . $model['nama_mitra_bisnis'];
									}
								),
								// 'prompt' => 'Pilih Mata Uang ',
								'language' => 'en',
								'options' => ['placeholder' => 'Pilih Pengirim'],
								'pluginOptions' => [
									// 'allowClear' => true,
									'tags' => true,
									'tokenSeparators' => [',', ' '],
									'maximumInputLength' => 10
								],
							]) ?>

							<?php
							if ($model->isNewRecord) {
								# code...
							?>
								<?= $form->field($model, 'status')->dropDownList(array(1 => 'Belum Di Setujui')) ?>
							<?php
							} else {
								# code...
							?>
								<?= $form->field($model, 'status')->dropDownList(array(1 => 'Belum Di Setujui'), ['disabled' => true]) ?>
							<?php
							}

							?>

						</div>
					</div>

					<div class="form-group">
						<?php
						if ($model->isNewRecord) {
							# code...
							$url = ['index'];
						} else {
							# code...
							$url = ['view', 'id' => $model->id_penawaran_penjualan];
						}

						?>
						<?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
						<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-success']) ?>
					</div>

					<?php ActiveForm::end(); ?>


				</div>
			</div>
		</div>
	</div>
</div>