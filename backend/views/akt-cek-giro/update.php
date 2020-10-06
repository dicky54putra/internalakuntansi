<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCekGiro */

$this->title = 'Ubah Cek/Giro : ' . $model->no_cek_giro;
?>
<div class="akt-cek-giro-update">

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
