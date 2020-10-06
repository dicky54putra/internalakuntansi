<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPembelian */

$this->title = $model->id_item_pembelian;
$this->params['breadcrumbs'][] = ['label' => 'Item Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_item_pembelian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_item_pembelian], [
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
            'id_item_pembelian',
            'id_pembelian',
            'id_item_stok',
            'quantity',
            'id_satuan',
            'harga',
            'diskon',
            'id_departement',
            'id_gudang',
            'id_proyek',
            'keterangan:ntext',
            'no_order_pembelian',
            'no_penerimaan_pembelian',
        ],
    ]) ?>

</div>
