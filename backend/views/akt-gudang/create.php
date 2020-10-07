<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktGudang */

$this->title = 'Tambah Gudang';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Gudangs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-gudang-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Gudang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>