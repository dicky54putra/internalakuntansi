<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualanDetail */

$this->title = 'Ubah Data Barang Penawaran Penjualan';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penawaran Penjualan Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penawaran_penjualan_detail, 'url' => ['view', 'id' => $model->id_penawaran_penjualan_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penawaran-penjualan-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penawaran Penjualan', ['akt-penawaran-penjualan/index']) ?></li>
        <li><?= Html::a('Detail Daftar Penawaran Penjualan : ' . $akt_penawaran_penjualan->no_penawaran_penjualan, ['akt-penawaran-penjualan/view', 'id' => $model->id_penawaran_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_item_stok' => $data_item_stok,
        'data_level' => $data_level
    ]) ?>

</div>