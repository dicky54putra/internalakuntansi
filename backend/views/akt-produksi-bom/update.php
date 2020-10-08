<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiBom */

$this->title = 'Ubah Daftar Produksi B.o.M : ' . $model->no_produksi_bom;
?>
<div class="akt-produksi-bom-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Produksi B.o.M', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'data_akun' => $data_akun
    ]) ?>

</div>