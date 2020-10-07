<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarang */

$this->title = 'Tambah Data Permintaan Barang';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Permintaan Barangs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-permintaan-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Permintaan Barang', ['akt-permintaan-barang/index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
