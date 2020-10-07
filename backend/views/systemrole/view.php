<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Systemrole */

if (Yii::$app->user->isGuest) {
	header("Location: index.php");
	exit;
}
$this->title = "Detail Hak Akses: " . $model->nama_role;
// $this->params['breadcrumbs'][] = ['label' => 'Data Hak Akses', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="systemrole-view">

	<h1><?= Html::encode($this->title) ?></h1>
	<ul class="breadcrumb">
		<li><a href="/">Home</a></li>
		<li><?= Html::a('Daftar Menu Navigasi', ['index']) ?></li>
		<li class="active"><?= $this->title ?></li>
	</ul>

	<p>
		<?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_system_role], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_system_role], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
	</p>
	<div class="box">
		<div class="box-header">
			<div class="col-md-12" style="padding: 0;">
				<div class="box-body">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							// 'id_system_role',
							'nama_role',
						],
					]) ?>

					<br>
					<label>Daftar User:</label><br>
					<table class="table">
						<tr>
							<th>No.
							<th>
							<th>Nama
							<th>
						</tr>
						<?php
						$i = 0;
						foreach ($userrole as $data) {
							$i++;
							$nama = Yii::$app->db->createCommand("SELECT nama FROM login WHERE id_login = '$data[id_login]'")->queryScalar();
						?>
							<tr>
								<td align='center'><?= $i ?>.
								<td>
								<td><?= $nama ?>
								<td>
							</tr>

						<?php
						}
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>