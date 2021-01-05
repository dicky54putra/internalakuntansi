<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktLabaRugi */

$this->title = 'Ubah Laba Rugi';
?>
<div class="akt-laba-rugi-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Laporan Akuntansi', ['akt-laporan-akuntansi']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
