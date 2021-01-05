<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanDetail */

$this->title = 'Create Akt Penjualan Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
