<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenawaranPenjualanDetail */

$this->title = $model->id_penawaran_penjualan_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penawaran Penjualan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penawaran-penjualan-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penawaran_penjualan_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penawaran_penjualan_detail], [
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
            'id_penawaran_penjualan_detail',
            'id_penawaran_penjualan',
            'id_item_stok',
            'qty',
            'harga',
            'diskon',
            'total',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
