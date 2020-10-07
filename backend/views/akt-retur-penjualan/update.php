<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualan */

$this->title = 'Ubah Data Retur Penjualan : ' . $model->no_retur_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Retur Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_retur_penjualan, 'url' => ['view', 'id' => $model->id_retur_penjualan]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-retur-penjualan-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Penjualan', ['index']) ?></li>
        <li><?= Html::a('Detail Data Retur Penjualan : ' . $model->no_retur_penjualan, ['view', 'id' => $model->id_retur_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_penjualan_pengiriman' => $data_penjualan_pengiriman,
    ]) ?>

</div>