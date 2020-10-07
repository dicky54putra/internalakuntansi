<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */

$this->title = 'Ubah Data Pengiriman Penjualan : ' . $model->no_pengiriman;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengirimen', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penjualan_pengiriman, 'url' => ['view', 'id' => $model->id_penjualan_pengiriman]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penjualan-pengiriman-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pengiriman Penjualan', ['index']) ?></li>
        <li><?= Html::a('Detail Data Pengiriman Penjualan : ' . $model->no_pengiriman, ['view', 'id' => $model->id_penjualan_pengiriman]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_penjualan' => $data_penjualan,
    ]) ?>

</div>