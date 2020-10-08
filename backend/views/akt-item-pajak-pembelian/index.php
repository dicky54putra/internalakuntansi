<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemPajakPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Item Pajak Pembelians';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-item-pajak-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Item Pajak Pembelian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_pajak_pembelian',
            'id_item',
            'id_pajak',
            'perhitungan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
