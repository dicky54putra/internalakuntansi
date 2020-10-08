<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStok */

$this->title = 'Ubah Data Penyesuaian Stok : ' . $model->no_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penyesuaian Stoks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penyesuaian_stok, 'url' => ['view', 'id' => $model->id_penyesuaian_stok]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penyesuaian-stok-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penyesuaian Stok', ['index']) ?></li>
        <li><?= Html::a('Detail Data Penyesuaian Stok : ' . $model->no_transaksi, ['view', 'id' => $model->id_penyesuaian_stok]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>