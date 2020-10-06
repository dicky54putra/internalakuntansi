<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPermintaanPembelian */

$this->title = 'Ubah Data Stok Barang Permintaan Pembelian ';
// $this->params['breadcrumbs'][] = ['label' => 'Item Permintaan Pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_item_permintaan_pembelian, 'url' => ['view', 'id' => $model->id_item_permintaan_pembelian]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-permintaan-pembelian-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Detail Permintaan Pembelian ', ['akt-permintaan-pembelian/view', 'id' => $model->id_item_permintaan_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'array_item' => $array_item,
    ]) ?>

</div>