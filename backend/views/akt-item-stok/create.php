<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemStok */

$this->title = 'Tambah Stok Gudang';
?>
<div class="akt-item-stok-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Item', ['akt-item/index']) ?></li>
        <li><?= Html::a('Detail Item', ['akt-item/view', 'id' => $_GET['id']]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'model_gudang' => $model_gudang,
        'data_gudang' => $data_gudang
    ]) ?>

</div>