<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStokDetail */

$this->title = 'Tambah Barang Penyesuaian Stok';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penyesuaian Stok Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penyesuaian-stok-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penyesuaian Stok', ['akt-penyesuaian-stok/index']) ?></li>
        <li><?= Html::a('Detail Data Penyesuaian Stok : ' . $akt_penyesuaian_stok->no_transaksi, ['akt-penyesuaian-stok/view', 'id' => $akt_penyesuaian_stok->id_penyesuaian_stok]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_item_stok' => $data_item_stok,
    ]) ?>

</div>