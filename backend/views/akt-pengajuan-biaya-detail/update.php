<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiayaDetail */

$this->title = 'Ubah Data List Pengajuan Biaya';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Pengajuan Biaya Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_pengajuan_biaya_detail, 'url' => ['view', 'id' => $model->id_pengajuan_biaya_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pengajuan-biaya-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pengajuan Biaya', ['akt-pengajuan-biaya/index']) ?></li>
        <li><?= Html::a('Detail Data Pengajuan Biaya : ' . $pengajuan_biaya->nomor_pengajuan_biaya, ['akt-pengajuan-biaya/view', 'id' => $pengajuan_biaya->id_pengajuan_biaya]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
    ]) ?>

</div>