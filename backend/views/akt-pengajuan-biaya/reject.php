<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiaya */

$this->title = 'Reject Data Pengajuan Biaya : ' . $model->nomor_pengajuan_biaya;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Pengajuan Biayas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_pengajuan_biaya, 'url' => ['view', 'id' => $model->id_pengajuan_biaya]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pengajuan-biaya-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pengajuan Biaya', ['index']) ?></li>
        <li><?= Html::a('Detail Data Pengajuan Biaya : ' . $model->nomor_pengajuan_biaya, ['view', 'id' => $model->id_pengajuan_biaya]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form_reject', [
        'model' => $model,
    ]) ?>

</div>