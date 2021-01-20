<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokMasukDetail */

$this->title = 'Tambah Data Barang Stok Masuk';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Masuk Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-masuk-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Masuk', ['akt-stok-masuk/index']) ?></li>
        <li><?= Html::a('Detail Data Stok Masuk : ' . $akt_stok_masuk->nomor_transaksi, ['akt-stok-masuk/view', 'id' => $model->id_stok_masuk]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_item_stok' => $data_item_stok,
    ]) ?>

</div>