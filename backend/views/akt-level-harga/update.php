<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktLevelHarga */

$this->title = 'Ubah Level Harga : ' . $model->keterangan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Level Hargas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_level_harga, 'url' => ['view', 'id' => $model->id_level_harga]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-level-harga-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Level Harga', ['akt-level-harga/index']) ?></li>
        <li class="active">Ubah Level Harga</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor
    ]) ?>

</div>