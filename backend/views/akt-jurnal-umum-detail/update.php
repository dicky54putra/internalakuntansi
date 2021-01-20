<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmumDetail */

$this->title = 'Ubah Data Detail Jurnal Umum : ' . $akt_jurnal_umum->no_jurnal_umum;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Jurnal Umum Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_jurnal_umum_detail, 'url' => ['view', 'id' => $model->id_jurnal_umum_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-jurnal-umum-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Jurnal Umum', ['akt-jurnal-umum/index']) ?></li>
        <li><?= Html::a('Detail Data Jurnal Umum : ' . $akt_jurnal_umum->no_jurnal_umum, ['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>