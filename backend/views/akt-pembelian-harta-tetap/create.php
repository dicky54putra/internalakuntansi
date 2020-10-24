<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianHartaTetap */

$this->title = 'Buat Pembelian Harta Tetap';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembelian-harta-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pembelian Harta Tetap', ['akt-pembelian-harta-tetap/index']) ?></li>
        <li class="active">Buat Data Pembelian Harta Tetap</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        // 'nomor' => $nomor,
        'data_customer' => $data_customer,
    ]) ?>

</div>