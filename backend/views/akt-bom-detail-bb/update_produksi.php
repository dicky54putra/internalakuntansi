<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktBomDetailBb */

$this->title = 'Ubah Item';
?>
<div class="akt-bom-detail-bb-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Produksi Bill of Material', ['akt-produksi-bom/index']) ?></li>
        <li><?= Html::a('Produksi Detail Bill of Material', ['aktakt-produksi-bom/view', 'id' => $produksi->id_produksi_bom]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form_produksi', [
        'model' => $model,
        'id_bom' => $model->id_bom,
        'model_item' => $model_item,
        'produksi' => $produksi
    ]) ?>

</div>