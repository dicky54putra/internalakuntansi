<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPembelian */

$this->title = 'Ubah Data Retur Pembelian: ' . $model->no_retur_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Retur Pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_retur_pembelian, 'url' => ['view', 'id' => $model->id_retur_pembelian]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-retur-pembelian-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Pembelian', ['index']) ?></li>
        <li><?= Html::a('Detail Data Retur Pembelian : ' . $model->no_retur_pembelian, ['view', 'id' => $model->id_retur_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_penerimaan' => $data_penerimaan,
    ]) ?>

</div>