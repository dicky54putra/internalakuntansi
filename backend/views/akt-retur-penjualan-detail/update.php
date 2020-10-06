<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualanDetail */

$this->title = 'Ubah Data Barang Retur Penjualan';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Retur Penjualan Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_retur_penjualan_detail, 'url' => ['view', 'id' => $model->id_retur_penjualan_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-retur-penjualan-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Penjualan', ['akt-retur-penjualan/index']) ?></li>
        <li><?= Html::a('Detail Data Retur Penjualan : ' . $akt_retur_penjualan->no_retur_penjualan, ['akt-retur-penjualan/view', 'id' => $akt_retur_penjualan->id_retur_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_penjualan_pengiriman_detail' => $data_penjualan_pengiriman_detail,
    ]) ?>

</div>