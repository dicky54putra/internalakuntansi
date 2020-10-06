<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiManualDetailBb */

$this->title = 'Ubah Bahan Baku';
?>
<div class="akt-produksi-manual-detail-bb-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Produksi Manual', ['akt-produksi-manual/index']) ?></li>
        <li><?= Html::a('Detail Produksi Manual', ['akt-produksi-manual/view', 'id' => $model->id_produksi_manual]) ?></li>
        <li class="active"><?= Html::encode($this->title) ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'model_item' => $model_item,
        'id_produksi_manual' => $id_produksi_manual,
    ]) ?>

</div>
