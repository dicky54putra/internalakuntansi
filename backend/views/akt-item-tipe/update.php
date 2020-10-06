<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktItemTipe */

$this->title = 'Ubah Daftar Tipe Barang';
?>
<div class="akt-item-tipe-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Ubah Daftar Tipe Barang', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>