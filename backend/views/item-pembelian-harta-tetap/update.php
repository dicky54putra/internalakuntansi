<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPembelianHartaTetap */

$this->title = 'Ubah Data Item Pembelian Harta Tetap ';
// $this->params['breadcrumbs'][] = ['label' => 'Item Pembelian Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_item_pembelian_harta_tetap, 'url' => ['view', 'id' => $model->id_item_pembelian_harta_tetap]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-pembelian-harta-tetap-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pembelian Harta Tetap', ['akt-pembelian-harta-tetap/index']) ?></li>
        <li><?= Html::a('Detail Pembelian Harta Tetap', ['akt-pembelian-harta-tetap/view', 'id' => $model->id_pembelian_harta_tetap]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'array_item' => $array_item,
    ]) ?>

</div>