<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferStok */

$this->title = 'Ubah Data Transfer Stok : ' . $model->no_transfer;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Transfer Stoks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_transfer_stok, 'url' => ['view', 'id' => $model->id_transfer_stok]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-transfer-stok-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Transfer Stok', ['index']) ?></li>
        <li><?= Html::a('Detail Data Transfer Stok : ' . $model->no_transfer, ['view', 'id' => $model->id_transfer_stok]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_gudang' => $data_gudang,
        'disabled' => $disabled,
    ]) ?>

</div>