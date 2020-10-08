<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktReturPenjualanDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Retur Penjualan Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-retur-penjualan-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Retur Penjualan Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_retur_penjualan_detail',
            'id_retur_penjualan',
            'id_penjualan_detail',
            'qty',
            'retur',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
