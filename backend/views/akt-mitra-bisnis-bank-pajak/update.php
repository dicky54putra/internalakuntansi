<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisBankPajak */

$this->title = 'Ubah Bank / Pajak '
?>
<div class="akt-mitra-bisnis-bank-pajak-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Mitra Bisnis', ['akt-mitra-bisnis/index']) ?></li>
        <li><?= Html::a('Detail Mitra Bisnis', ['akt-mitra-bisnis/view', 'id' => $model->id_mitra_bisnis]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
