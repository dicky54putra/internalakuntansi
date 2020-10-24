<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKota */

$this->title = 'Tambah Daftar Kota';
?>
<div class="akt-kota-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kota', ['akt-kota/index']) ?></li>
        <li class="active">Tambah Kota</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>
