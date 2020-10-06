<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisAlamat */

$this->title = 'Tambah Alamat';
?>
<div class="akt-mitra-bisnis-alamat-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Mitra Bisnis', ['akt-mitra-bisnis/index']) ?></li>
        <li><?= Html::a('Detail Mitra Bisnis', ['akt-mitra-bisnis/view', 'id' => $_GET['id']]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'model_kota' => $model_kota,
        'nomor_kota' => $nomor_kota
    ]) ?>

</div>
