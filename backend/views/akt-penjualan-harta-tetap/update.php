<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetap */

$this->title = 'Update Akt Penjualan Harta Tetap: ' . $model->id_penjualan_harta_tetap;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_penjualan_harta_tetap, 'url' => ['view', 'id' => $model->id_penjualan_harta_tetap]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penjualan-harta-tetap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
