<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokMasukDetail */

$this->title = 'Ubah Data Barang Stok Masuk';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Masuk Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_stok_masuk_detail, 'url' => ['view', 'id' => $model->id_stok_masuk_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-stok-masuk-detail-update">

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