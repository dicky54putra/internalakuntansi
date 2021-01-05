<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSales */

$this->title = 'Ubah Sales : ' . $model->nama_sales;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Sales', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_sales, 'url' => ['view', 'id' => $model->id_sales]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-sales-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Sales', ['akt-sales/index']) ?></li>
        <li class="active">Ubah Sales</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'data_kota' => $data_kota,
        'model_kota' => $model_kota
    ]) ?>

</div>