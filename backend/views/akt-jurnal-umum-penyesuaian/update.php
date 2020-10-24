<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJurnalUmum */

$this->title = 'Ubah Data Jurnal Penyesuaian : ' . $model->no_jurnal_umum;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Jurnal Umums', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_jurnal_umum, 'url' => ['view', 'id' => $model->id_jurnal_umum]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-jurnal-umum-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Jurnal Penyesuaian', ['index']) ?></li>
        <li><?= Html::a('Detail Data Jurnal Penyesuaian : ' . $model->no_jurnal_umum, ['view', 'id' => $model->id_jurnal_umum]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>