<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItem */

$this->title = 'Ubah Daftar Barang : ' . $model->kode_item;
?>
<div class="akt-item-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Barang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'model_tipe' => $model_tipe,
        'model_merk' => $model_merk,
        'model_satuan' => $model_satuan,
        'model_mitra_bisnis' => $model_mitra_bisnis,
    ]) ?>

</div>