<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokKeluar */

$this->title = 'Tambah Data Stok Keluar';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Keluars', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-keluar-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Keluar', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
    ]) ?>

</div>