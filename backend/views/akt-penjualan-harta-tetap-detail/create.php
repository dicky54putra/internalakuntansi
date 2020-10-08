<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetapDetail */

$this->title = 'Create Akt Penjualan Harta Tetap Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Harta Tetap Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-harta-tetap-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
