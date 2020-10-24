<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferStok */

$this->title = 'Tambah Data Transfer Stok';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Transfer Stoks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-transfer-stok-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Transfer Stok', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_gudang' => $data_gudang,
        'disabled' => $disabled,
    ]) ?>

</div>