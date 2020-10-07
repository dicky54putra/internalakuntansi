<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktStokKeluarDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Stok Keluar Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-keluar-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Stok Keluar Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_stok_keluar_detail',
            'id_stok_keluar',
            'id_item_stok',
            'qty',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
