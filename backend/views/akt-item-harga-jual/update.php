<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemHargaJual */

$this->title = 'Ubah Harga Jual Barang';
?>
<div class="akt-item-harga-jual-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Barang', ['akt-item/index']) ?></li>
        <li><?= Html::a('Detail Barang', ['akt-item/view', 'id' => $id_item]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'data_mata_uang' => $data_mata_uang,
        'data_level_harga' => $data_level_harga,
        'model_level_harga' => $model_level_harga,
        'id_item' => $id_item,
    ]) ?>

</div>