<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JurnalTransaksiDetail */

$this->title = 'Tambah Jurnal Transaksi Detail';
?>
<div class="jurnal-transaksi-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Jurnal Transaksi', ['jurnal-transaksi/view', 'id' => $id_jurnal_transaksi]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'id_jurnal_transaksi' => $id_jurnal_transaksi
    ]) ?>

</div>
