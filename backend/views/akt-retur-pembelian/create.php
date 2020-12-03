<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPembelian */

$this->title = 'Tambah Data Retur Pembelian';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Retur Pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-retur-pembelian-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'data_kas_bank' => $data_kas_bank,
        'model' => $model,

        'data_penerimaan' => $data_penerimaan,
    ]) ?>

</div>