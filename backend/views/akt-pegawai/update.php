<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPegawai */

$this->title = 'Ubah Pegawai : ' . $model->nama_pegawai;
//$this->params['breadcrumbs'][] = ['label' => 'Akt Pegawais', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pegawai, 'url' => ['view', 'id' => $model->id_pegawai]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pegawai-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pegawai', ['akt-pegawai/index']) ?></li>
        <li class="active">Ubah Pegawai</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'data_kota' => $data_kota,
        'model_kota' => $model_kota
    ]) ?>

</div>