<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Item Stoks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-item-stok-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Item Stok', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_stok',
            'id_item',
            'id_gudang',
            'location',
            'qty',
            //'hpp',
            //'min',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
