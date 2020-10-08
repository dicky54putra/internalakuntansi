<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktStokMasukDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Stok Masuk Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-masuk-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Stok Masuk Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_stok_masuk_detail',
            'id_stok_masuk',
            'id_item',
            'qty',
            'id_gudang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
