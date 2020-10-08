<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKlasifikasi */

$this->title = 'Ubah Klasifikasi: ' . $model->klasifikasi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Klasifikasis', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_klasifikasi, 'url' => ['view', 'id' => $model->id_klasifikasi]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-klasifikasi-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Klasifikasi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>