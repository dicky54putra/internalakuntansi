<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangPegawai */

$this->title = 'Tambah Pegawai';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Permintaan Barang Pegawais', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-permintaan-barang-pegawai-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Permintaan Barang', ['akt-permintaan-barang/index']) ?></li>
        <li><?= Html::a('Detail Data Permintaan Barang', ['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_pegawai' => $data_pegawai,
    ]) ?>

</div>
