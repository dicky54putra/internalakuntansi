<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */

$this->title = 'Create Akt Penjualan Pengiriman';
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengirimen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-pengiriman-create">

    <h1><?php // Html::encode($this->title) 
        ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_penjualan' => $model_penjualan,
        'model_mitra_bisnis_alamat' => $model_mitra_bisnis_alamat,
    ]) ?>

</div>