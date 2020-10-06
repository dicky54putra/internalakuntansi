<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKelompokHartaTetap */

$this->title = 'Update Akt Kelompok Harta Tetap: ' . $model->kode;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Kelompok Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_kelompok_harta_tetap, 'url' => ['view', 'id' => $model->id_kelompok_harta_tetap]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-kelompok-harta-tetap-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kelompok Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>