<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokOpname */

$this->title = 'Ubah Data Stok Opname : ' . $model->no_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Opnames', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_stok_opname, 'url' => ['view', 'id' => $model->id_stok_opname]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-stok-opname-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Opname', ['index']) ?></li>
        <li><?= Html::a('Detail Data Stok Opname : ' . $model->no_transaksi, ['view', 'id' => $model->id_stok_opname]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
        'data_pegawai' => $data_pegawai,
    ]) ?>

</div>