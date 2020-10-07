<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarangDetail */

$this->title = 'Ubah Item';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Permintaan Barang Details', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_permintaan_barang_detail, 'url' => ['view', 'id' => $model->id_permintaan_barang_detail]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-permintaan-barang-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Permintaan Barang', ['akt-permintaan-barang/index']) ?></li>
        <li><?= Html::a('Detail Data Permintaan Barang', ['akt-permintaan-barang/view', 'id' => $model->id_permintaan_barang]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_item' => $data_item,
    ]) ?>

</div>
