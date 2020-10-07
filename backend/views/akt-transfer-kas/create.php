<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferKas */

$this->title = 'Tambah Transfer Kas';
?>
<div class="akt-transfer-kas-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Transfer Kas', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'modal_kas' => $modal_kas
    ]) ?>

</div>
