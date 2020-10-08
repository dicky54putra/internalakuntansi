<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmumDetail */

$this->title = 'Tambah Jurnal Umum Detail';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Jurnal Umum Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-jurnal-umum-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Jurnal Umum', ['index']) ?></li>
        <li><?= Html::a('View Jurnal Umum', ['akt-jurnal-umum/view', 'id' => $model->id_jurnal_umum]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>