<?php

use yii\helpers\Html;


$this->title = 'Ubah Data Pembelian Detail';
?>
<div class="akt-pembelian-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pembelian', ['akt-pembelian-pembelian/index']) ?></li>
        <li><?= Html::a('Detail Data Pembelian : ' . $akt_pembelian->no_pembelian, ['akt-pembelian-pembelian/view', 'id' => $model->id_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form_update_pembelian_langsung', [
        'model' => $model,
        'akt_pembelian' => $akt_pembelian,
        'data_item_stok' => $data_item_stok,
    ]) ?>

</div>