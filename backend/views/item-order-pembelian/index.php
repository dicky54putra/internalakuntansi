<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemOrderPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Order Pembelians';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-order-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item Order Pembelian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_order_pembelian',
            'id_order_pembelian',
            'id_item_stok',
            'quantity',
            'id_satuan',
            //'harga',
            //'diskon',
            //'qty_terkirim',
            //'qty_back_order',
            //'id_departement',
            //'id_proyek',
            //'keterangan:ntext',
            //'req_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
