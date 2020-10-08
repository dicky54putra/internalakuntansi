<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokKeluar */

$this->title = 'Ubah Data Stok Keluar : ' . $model->nomor_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Keluars', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_stok_keluar, 'url' => ['view', 'id' => $model->id_stok_keluar]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-stok-keluar-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Keluar', ['index']) ?></li>
        <li><?= Html::a('Detail Data Stok Keluar : ' . $model->nomor_transaksi, ['view', 'id' => $model->id_stok_keluar]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
    ]) ?>

</div>