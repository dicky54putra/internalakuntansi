<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCekGiro */

$this->title = 'Tambah Cek/Giro';
?>
<div class="akt-cek-giro-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Cek/Giro', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor
    ]) ?>

</div>
