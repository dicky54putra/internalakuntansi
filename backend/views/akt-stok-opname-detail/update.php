<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokOpnameDetail */

$this->title = 'Ubah Data Barang Stok Opname';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Opname Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_stok_opname_detail, 'url' => ['view', 'id' => $model->id_stok_opname_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-stok-opname-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Opname', ['akt-stok-opname/index']) ?></li>
        <li><?= Html::a('Detail Data Stok Opname : ' . $akt_stok_opname->no_transaksi, ['akt-stok-opname/view', 'id' => $model->id_stok_opname]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_item_stok' => $data_item_stok,
    ]) ?>

</div>