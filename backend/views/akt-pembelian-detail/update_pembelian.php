<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktpembelianDetail */

$this->title = 'Ubah Barang';
// $this->params['breadcrumbs'][] = ['label' => 'Akt pembelian Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_pembelian_detail, 'url' => ['view', 'id' => $model->id_pembelian_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembelian-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pembelian', ['akt-pembelian-pembelian/index']) ?></li>
        <li><?= Html::a('Detail Data Pembelian : ' . $akt_pembelian->no_pembelian, ['akt-pembelian-pembelian/view', 'id' => $model->id_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form_update_pembelian', [
        'model' => $model,
        'data_item_stok' => $data_item_stok,
    ]) ?>

</div>