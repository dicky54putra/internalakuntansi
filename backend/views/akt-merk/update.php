<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMerk */

$this->title = 'Ubah Merk Barang: ' . $model->nama_merk;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Merks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_merk, 'url' => ['view', 'id' => $model->id_merk]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-merk-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Merk Barang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor
    ]) ?>

</div>