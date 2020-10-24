<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */

$this->title = 'Update Akt Penjualan Pengiriman: ' . $model->id_penjualan_pengiriman;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengirimen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_penjualan_pengiriman, 'url' => ['view', 'id' => $model->id_penjualan_pengiriman]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penjualan-pengiriman-update">

    <h1>
        <?php // Html::encode($this->title) 
        ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'model_penjualan' => $model_penjualan,
    ]) ?>

</div>