<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemStok */

$this->title = 'Ubah Item Stok';
?>
<div class="akt-item-stok-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Item', ['akt-item/index']) ?></li>
        <li><?= Html::a('Detail Item', ['akt-item/view', 'id' => $model->id_item]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'data_gudang' => $data_gudang,
            'model_gudang' => $model_gudang,
            'nomor_gudang' => $nomor_gudang
    ]) ?>

</div>