<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarang */

$this->title = 'Ubah Permintaan Barang : ' . $model->nomor_permintaan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Permintaan Barang', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->nomor_permintaan, 'url' => ['view', 'id' => $model->id_permintaan_barang]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-permintaan-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Permintaan Barang', ['akt-permintaan-barang/index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
