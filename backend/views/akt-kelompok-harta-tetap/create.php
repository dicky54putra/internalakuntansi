<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKelompokHartaTetap */

$this->title = 'Tambah Kelompok Harta Tetap';
?>
<div class="akt-kelompok-harta-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kelompok Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>