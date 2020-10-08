<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItem */

$this->title = 'Tambah Barang';
?>
<div class="akt-item-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Barang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'nomor_merk' => $nomor_merk,
        'model_merk' => $model_merk,
        'model_tipe' => $model_tipe,
        'model_satuan' => $model_satuan,
        'model_mitra_bisnis' => $model_mitra_bisnis,
        'nomor_mitra_bisnis' => $nomor_mitra_bisnis
    ]) ?>

</div>