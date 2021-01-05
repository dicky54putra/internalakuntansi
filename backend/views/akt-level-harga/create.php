<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktLevelHarga */

$this->title = 'Tambah Level Harga';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Level Hargas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-level-harga-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Level Harga', ['akt-level-harga/index']) ?></li>
        <li class="active">Tambah Level Harga</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>