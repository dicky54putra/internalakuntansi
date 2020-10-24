<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPajak */

$this->title = 'Tambah Pajak';
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Pajak', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pajak-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pajak', ['akt-pajak/index']) ?></li>
        <li class="active">Tambah Pajak</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>