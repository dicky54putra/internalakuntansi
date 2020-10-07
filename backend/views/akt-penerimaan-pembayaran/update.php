<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaran */

$this->title = 'Ubah Data Penerimaan Pembayaran : ' . $retVal = ($model->jenis_penerimaan) ? 'Penjualan Barang' : 'Penjualan Harta Tetap';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembayarans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penerimaan_pembayaran_penjualan, 'url' => ['view', 'id' => $model->id_penerimaan_pembayaran_penjualan]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penerimaan-pembayaran-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penerimaan Pembayaran', ['index']) ?></li>
        <li><?= Html::a('Detail Data Penerimaan Pembayaran : ' . $retVal = ($model->jenis_penerimaan) ? 'Penjualan Barang' : 'Penjualan Harta Tetap', ['view', 'id' => $model->id_penerimaan_pembayaran_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>