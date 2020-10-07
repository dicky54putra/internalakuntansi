<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Aktpembelian */

$this->title = 'Ubah Data Penerimaan Pembelian : ' . $model->no_penerimaan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_pembelian, 'url' => ['view', 'id' => $model->id_pembelian]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembelian-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penerimaan pembelian', ['index']) ?></li>
        <li><?= Html::a('Detail Data Penerimaan pembelian : ' . $model->no_penerimaan, ['view', 'id' => $model->id_pembelian]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form_update_data_pembelian_penerimaan', [
        'model' => $model,
        // 'data_mitra_bisnis_alamat' => $data_mitra_bisnis_alamat,
    ]) ?>

</div>