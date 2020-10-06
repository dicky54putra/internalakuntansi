<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */

$this->title = 'Ubah Data Perusahaan: ' . $model->nama;
// $this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_setting, 'url' => ['view', 'id' => $model->id_setting]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="setting-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Perusahaan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>


    <?= $this->render('_form', [
        'model' => $model,
        'data_kota' => $data_kota,
    ]) ?>

</div>