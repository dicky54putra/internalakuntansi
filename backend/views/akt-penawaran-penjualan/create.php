<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualan */

$this->title = 'Tambah Daftar Penawaran Penjualan';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penawaran Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penawaran-penjualan-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penawaran Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title; ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>