<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManual */

$this->title = 'Ubah Daftar Produksi Manual: ' . $model->no_produksi_manual;
?>
<div class="akt-produksi-manual-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Produksi Manual', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'data_akun' => $data_akun
    ]) ?>

</div>