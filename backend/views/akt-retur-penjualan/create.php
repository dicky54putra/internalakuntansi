<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualan */

$this->title = 'Tambah Data Retur Penjualan';
?>
<div class="akt-retur-penjualan-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_penjualan' => $data_penjualan,
        'data_kas_bank' => $data_kas_bank,
    ]) ?>

</div>