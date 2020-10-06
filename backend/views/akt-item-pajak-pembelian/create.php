<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemPajakPembelian */

$this->title = 'Tambah Item Pajak Pembelian';
?>
<div class="akt-item-pajak-pembelian-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Item', ['akt-item/index']) ?></li>
        <li><?= Html::a('Detail Item', ['akt-item/view', 'id' => $id_item]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'array_pajak' => $array_pajak,
        'selected_pajak' => $selected_pajak,
        'id_item' => $id_item,
    ]) ?>

</div>