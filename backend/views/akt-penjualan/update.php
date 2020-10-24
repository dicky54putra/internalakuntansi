<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualan */

$this->title = 'Ubah Data Order Penjualan : ' . $model->no_order_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penjualan, 'url' => ['view', 'id' => $model->id_penjualan]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penjualan-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Order Penjualan', ['index']) ?></li>
        <li><?= Html::a('Detail Data Order Penjualan : ' . $model->no_order_penjualan, ['view', 'id' => $model->id_penjualan]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_customer' => $data_customer,
        'data_sales' => $data_sales,
        'data_mata_uang' => $data_mata_uang,
        'model_new_customer' => $model_new_customer,
        'model_new_sales' => $model_new_sales,
    ]) ?>

</div>