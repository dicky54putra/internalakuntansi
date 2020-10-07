<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualanDetail */

$this->title = 'Create Akt Penawaran Penjualan Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Penawaran Penjualan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penawaran-penjualan-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
