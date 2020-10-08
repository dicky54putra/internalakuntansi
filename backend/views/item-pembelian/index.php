<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Pembelians';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item Pembelian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_pembelian',
            'id_pembelian',
            'id_item_stok',
            'quantity',
            'id_satuan',
            //'harga',
            //'diskon',
            //'id_departement',
            //'id_gudang',
            //'id_proyek',
            //'keterangan:ntext',
            //'no_order_pembelian',
            //'no_penerimaan_pembelian',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
