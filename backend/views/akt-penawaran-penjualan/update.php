<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualan */

$this->title = 'Ubah Daftar Penawaran Penjualan : ' . $model->no_penawaran_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penawaran Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penawaran_penjualan, 'url' => ['view', 'id' => $model->id_penawaran_penjualan]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penawaran-penjualan-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penawaran Penjualan', ['index']) ?></li>
        <li><?= Html::a('Detail Daftar Penawaran Penjualan : ' . $model->no_penawaran_penjualan, ['view', 'id' => $model->id_penawaran_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>