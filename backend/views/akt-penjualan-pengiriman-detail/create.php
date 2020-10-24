<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengirimanDetail */

$this->title = 'Create Akt Penjualan Pengiriman Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengiriman Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-pengiriman-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
