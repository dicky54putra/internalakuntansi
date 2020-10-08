<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPegawai */

$this->title = 'Tambah Pegawai';
//$this->params['breadcrumbs'][] = ['label' => 'Akt Pegawais', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pegawai-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pegawai', ['akt-pegawai/index']) ?></li>
        <li class="active">Tambah Pegawai</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'data_kota' => $data_kota,
        'nomor_kota' => $nomor_kota,
        'model_kota' => $model_kota 
    ]) ?>

</div>