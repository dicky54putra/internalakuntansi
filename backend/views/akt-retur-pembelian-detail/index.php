<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktReturPembelianDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Retur Pembelian Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-retur-pembelian-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Retur Pembelian Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_retur_pembelian_detail',
            'id_retur_pembelian',
            'id_pembelian_detail',
            'qty',
            'retur',
            //'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
