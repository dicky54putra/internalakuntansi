<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktOrderPembelian */

$this->title = 'Tambah Data Order Pembelian';
?>
<div class="akt-order-pembelian-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Order Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        
        'nomor' => $nomor,
    ]) ?>

</div>
