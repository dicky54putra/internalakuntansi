<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */

$this->title = 'Tambah Setting';
// $this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Setting', ['index']) ?></li>
        <li class="active">Tambah Setting</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_kota' => $data_kota,
    ]) ?>

</div>