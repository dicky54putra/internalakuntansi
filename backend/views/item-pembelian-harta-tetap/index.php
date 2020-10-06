<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemPembelianHartaTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Pembelian Harta Tetaps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-pembelian-harta-tetap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item Pembelian Harta Tetap', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_pembelian_harta_tetap',
            'id_pembelian_harta_tetap',
            'id_harta_tetap',
            'harga',
            'diskon',
            //'pajak',
            //'lokasi',
            //'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
