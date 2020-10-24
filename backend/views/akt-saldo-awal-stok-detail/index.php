<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktSaldoAwalStokDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Saldo Awal Stok Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-saldo-awal-stok-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Saldo Awal Stok Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_saldo_awal_stok_detail',
            'id_saldo_awal_stok',
            'id_item',
            'id_item_stok',
            'qty',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
