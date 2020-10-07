<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPajak */

$this->title = 'Ubah Pajak : ' . $model->nama_pajak;
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Pajak', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_pajak, 'url' => ['view', 'id' => $model->id_pajak]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pajak-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pajak', ['akt-pajak/index']) ?></li>
        <li class="active">Ubah Pajak</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>