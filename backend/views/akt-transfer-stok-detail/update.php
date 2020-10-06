<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferStokDetail */

$this->title = 'Ubah Data Barang Transfer Stok';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Transfer Stok Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_transfer_stok_detail, 'url' => ['view', 'id' => $model->id_transfer_stok_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-transfer-stok-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Transfer Stok', ['akt-transfer-stok/index']) ?></li>
        <li><?= Html::a('Detail Data Transfer Stok : ' . $akt_transfer_stok->no_transfer, ['akt-transfer-stok/view', 'id' => $model->id_transfer_stok]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_item' => $data_item,
    ]) ?>

</div>