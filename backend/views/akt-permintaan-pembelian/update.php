<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanPembelian */

$this->title = 'Ubah Data Permintaan Pembelian: ' . $model->no_permintaan;
?>
<div class="akt-permintaan-pembelian-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Permintaan Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
