<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokMasuk */

$this->title = 'Tambah Data Stok Masuk';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Masuks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-masuk-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Masuk', ['akt-stok-masuk/index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
    ]) ?>

</div>