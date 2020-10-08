<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalStokDetail */

$this->title = 'Ubah Data Barang ';
?>
<div class="akt-saldo-awal-stok-detail-update">
<h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Saldo Awal Stok', ['akt-saldo-awal-stok/index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>


    <?= $this->render('_form', [
        'model' => $model,
        'data_item' => $data_item,
        'data_level' => $data_level
    ]) ?>

</div>
