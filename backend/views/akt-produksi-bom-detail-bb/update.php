<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktProduksiBomDetailBb */

$this->title = 'Ubah Bahan Baku ';
?>
<div class="akt-produksi-bom-detail-bb-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Produksi B.o.M', ['akt-produksi-bom/index']) ?></li>
        <li><?= Html::a('Detail Produksi B.o.M', ['akt-produksi-bom/view', 'id' => $model->id_produksi_bom]) ?></li>
        <li class="active"><?= Html::encode($this->title) ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'model_item' => $model_item
    ]) ?>

</div>
