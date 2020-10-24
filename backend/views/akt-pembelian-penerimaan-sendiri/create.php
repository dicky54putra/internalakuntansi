<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */

$this->title = 'Tambah Data Penjualan Pengiriman';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengirimen', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-pengiriman-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penjualan Pengiriman', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_penjualan' => $data_penjualan,
    ]) ?>

</div>