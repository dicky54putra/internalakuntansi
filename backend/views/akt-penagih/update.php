<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenagih */

$this->title = 'Ubah Penagih : ' . $model->nama_penagih;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penagihs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penagih, 'url' => ['view', 'id' => $model->id_penagih]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penagih-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penagih', ['akt-penagih/index']) ?></li>
        <li class="active">Ubah Penagih</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>