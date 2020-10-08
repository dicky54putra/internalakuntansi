<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */

$this->title = 'Terkirim';
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengirimen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-pengiriman-create">

    <h1><?php // Html::encode($this->title) 
        ?></h1>

    <?= $this->render('_terkirim', [
        'model' => $model,
    ]) ?>

</div>