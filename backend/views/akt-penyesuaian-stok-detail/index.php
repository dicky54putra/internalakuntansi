<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenyesuaianStokDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Penyesuaian Stok Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penyesuaian-stok-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Penyesuaian Stok Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_penyesuaian_stok_detail',
            'id_penyesuaian_stok',
            'id_item',
            'qty',
            'hpp',
            //'id_gudang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
