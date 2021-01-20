<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProyek */

$this->title = 'Tambah Daftar Proyek';
?>
<div class="akt-proyek-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Proyek', ['akt-proyek/index']) ?></li>
        <li class="active">Tambah Daftar Proyek</li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>
