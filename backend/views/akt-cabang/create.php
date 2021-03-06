<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCabang */

$this->title = 'Tambah Daftar Cabang';
?>
<div class="akt-Cabang-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Cabang', ['akt-cabang/index']) ?></li>
        <li class="active">Tambah Cabang</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>