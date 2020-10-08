<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianDetail */

$this->title = 'Ubah Data Pembelian Detail';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_pembelian_detail, 'url' => ['view', 'id' => $model->id_pembelian_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembelian-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
	<ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Order Pembelian', ['akt-pembelian/index']) ?></li>
        <li><?= Html::a('Detail Data Order Pembelian : ' . $akt_pembelian->no_order_pembelian, ['akt-pembelian/view', 'id' => $model->id_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
            'akt_pembelian' => $akt_pembelian,
            'data_item_stok' => $data_item_stok,
    ]) ?>

</div>
