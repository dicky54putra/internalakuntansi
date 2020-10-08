<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStok */

$this->title = 'Tambah Data Penyesuaian Stok';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penyesuaian Stoks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penyesuaian-stok-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penyesuaian Stok', ['akt-penyesuaian-stok/index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>