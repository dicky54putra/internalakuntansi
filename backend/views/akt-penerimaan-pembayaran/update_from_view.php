<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaran */

$this->title = 'Ubah Data Detail Penerimaan Pembayaran : ' . $akt_penjualan->no_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembayarans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penerimaan_pembayaran_penjualan, 'url' => ['view', 'id' => $model->id_penerimaan_pembayaran_penjualan]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penerimaan-pembayaran-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pembayaran', ['index']) ?></li>
        <li><?= Html::a('Detail Data Pembayaran : ' . $akt_penjualan->no_penjualan, ['view-penerimaan-pembayaran', 'id' => $model->id_penerimaan_pembayaran_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form_update_from_view', [
        'model' => $model,
        'data_kas_bank' => $data_kas_bank,
    ]) ?>

</div>