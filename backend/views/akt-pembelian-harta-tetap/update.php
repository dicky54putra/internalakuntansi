<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianHartaTetap */

$this->title = 'Ubah Data Pembelian Harta Tetap ';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_pembelian_harta_tetap, 'url' => ['view', 'id' => $model->id_pembelian_harta_tetap]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembelian-harta-tetap-update">


    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pembelian Harta Tetap', ['akt-pembelian-harta-tetap/index']) ?></li>
        <li class="active">Ubah Data Pembelian Harta Tetap</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        // 'nomor' => $nomor,
    ]) ?>

</div>