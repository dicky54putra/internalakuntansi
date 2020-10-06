<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetap */

$this->title = 'Tambah Data Penjualan Harta Tetap';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-harta-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penjualan Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_mata_uang' => $data_mata_uang,
        'data_customer' => $data_customer,
        'data_sales' => $data_sales,
        'new_customer' => $new_customer,
        'new_sales' => $new_sales,
    ]) ?>

</div>