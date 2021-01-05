<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktBom */

$this->title = 'Tambah Bill of Material';
?>
<div class="akt-bom-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Bill of Material', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'model_item' => $model_item
    ]) ?>

</div>