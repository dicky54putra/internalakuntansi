<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualanDetail */

$this->title = $model->id_retur_penjualan_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Retur Penjualan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-retur-penjualan-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_retur_penjualan_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_retur_penjualan_detail], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_retur_penjualan_detail',
            'id_retur_penjualan',
            'id_penjualan_detail',
            'qty',
            'retur',
        ],
    ]) ?>

</div>
