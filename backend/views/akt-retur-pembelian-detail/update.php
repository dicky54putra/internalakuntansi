<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPembelianDetail */

$this->title = 'Ubah Data Retur Pembelian Detail ';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Retur Pembelian Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_retur_pembelian_detail, 'url' => ['view', 'id' => $model->id_retur_pembelian_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-retur-pembelian-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Pembelian', ['akt-retur-pembelian/index']) ?></li>
        <li><?= Html::a('Detail Data Retur Pembelian : ' . $akt_retur_pembelian->no_retur_pembelian, ['akt-retur-pembelian/view', 'id' => $akt_retur_pembelian->id_retur_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,

            // 'akt_retur_pembelian' => $akt_retur_pembelian,
            'data_pembelian_detail' => $data_pembelian_detail,
    ]) ?>

</div>
