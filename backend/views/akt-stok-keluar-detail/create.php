<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokKeluarDetail */

$this->title = 'Tambah Data Barang Stok Keluar';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Keluar Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-keluar-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Keluar', ['akt-stok-keluar/index']) ?></li>
        <li><?= Html::a('Detail Data Stok Keluar : ' . $akt_stok_keluar->nomor_transaksi, ['akt-stok-keluar/view', 'id' => $model->id_stok_keluar]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_item_stok' => $data_item_stok,
    ]) ?>

</div>