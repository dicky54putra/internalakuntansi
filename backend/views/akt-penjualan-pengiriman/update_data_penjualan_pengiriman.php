<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */

$this->title = 'Ubah Data Pengiriman Penjualan : ' . $model->no_pengiriman;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penjualan, 'url' => ['view', 'id' => $model->id_penjualan]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penjualan-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pengiriman Penjualan', ['index']) ?></li>
        <li><?= Html::a('Detail Data Pengiriman Penjualan : ' . $model->no_pengiriman, ['view', 'id' => $model->id_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form_update_data_penjualan_pengiriman', [
        'model' => $model,
        'data_mitra_bisnis_alamat' => $data_mitra_bisnis_alamat,
    ]) ?>

</div>