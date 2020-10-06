<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengirimanDetail */

$this->title = 'Update Akt Penjualan Pengiriman Detail: ' . $model->id_penjualan_pengiriman_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengiriman Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_penjualan_pengiriman_detail, 'url' => ['view', 'id' => $model->id_penjualan_pengiriman_detail]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penjualan-pengiriman-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
