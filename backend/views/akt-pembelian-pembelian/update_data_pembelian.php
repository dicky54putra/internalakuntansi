<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Aktpembelian */

$this->title = 'Ubah Data Pembelian : ' . $model->no_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_pembelian, 'url' => ['view', 'id' => $model->id_pembelian]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembelian-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pembelian', ['index']) ?></li>
        <li><?= Html::a('Detail Data Pembelian : ' . $model->no_pembelian, ['view', 'id' => $model->id_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form_update_data_pembelian', [
        'model' => $model,
        'data_penagih' => $data_penagih,
        'model_pembelian_detail' => $model_pembelian_detail,
    ]) ?>

</div>