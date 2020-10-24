<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JurnalTransaksi */

$this->title = 'Tambah Jurnal Transaksi';
?>
<div class="jurnal-transaksi-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Jurnal Transaksi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'model_akun' => $model_akun
    ]) ?>

</div>