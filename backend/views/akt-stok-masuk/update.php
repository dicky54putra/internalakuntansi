<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokMasuk */

$this->title = 'Ubah Data Stok Masuk : ' . $model->nomor_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Masuks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_stok_masuk, 'url' => ['view', 'id' => $model->id_stok_masuk]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-stok-masuk-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Masuk', ['index']) ?></li>
        <li><?= Html::a('Detail Data Stok Masuk : ' . $model->nomor_transaksi, ['view', 'id' => $model->id_stok_masuk]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
    ]) ?>

</div>