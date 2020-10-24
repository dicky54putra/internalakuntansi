<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktStokOpnameDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Stok Opname Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-opname-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Stok Opname Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_stok_opname_detail',
            'id_stok_opname',
            'id_item_stok',
            'qty',
            'qty_program',
            //'qty_selisih',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
