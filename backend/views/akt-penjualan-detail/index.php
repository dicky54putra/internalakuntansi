<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenjualanDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Penjualan Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Penjualan Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_penjualan_detail',
            'id_penjualan',
            'id_item_stok',
            'qty',
            'harga',
            //'diskon',
            //'total',
            //'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
