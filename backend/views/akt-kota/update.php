<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKota */

$this->title = 'Ubah Daftar Kota: ' . $model->kode_kota;
?>
<div class="akt-kota-update">

<h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kota', ['akt-kota/index']) ?></li>
        <li class="active">Ubah Daftar Kota</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>
