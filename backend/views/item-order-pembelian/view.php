<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemOrderPembelian */

$this->title = $model->id_item_order_pembelian;
$this->params['breadcrumbs'][] = ['label' => 'Item Order Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-order-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_item_order_pembelian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_item_order_pembelian], [
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
            'id_item_order_pembelian',
            'id_order_pembelian',
            'id_item_stok',
            'quantity',
            'id_satuan',
            'harga',
            'diskon',
            'qty_terkirim',
            'qty_back_order',
            'id_departement',
            'id_proyek',
            'keterangan:ntext',
            'req_date',
        ],
    ]) ?>

</div>
