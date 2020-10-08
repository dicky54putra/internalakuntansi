<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnis */

$this->title = 'Ubah Mitra Bisnis: ' . $model->kode_mitra_bisnis;
?>
<div class="akt-mitra-bisnis-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Mitra Bisnis', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor
    ]) ?>

</div>
