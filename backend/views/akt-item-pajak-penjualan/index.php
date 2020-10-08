<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemPajakPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Item Pajak Penjualans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-item-pajak-penjualan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Item Pajak Penjualan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_pajak_penjualan',
            'id_item',
            'id_pajak',
            'perhitungan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
