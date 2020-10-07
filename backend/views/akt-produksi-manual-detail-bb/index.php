<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktProduksiManualDetailBbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Produksi Manual Detail Bbs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-produksi-manual-detail-bb-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Produksi Manual Detail Bb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_produksi_manual_detail_bb',
            'id_produksi_manual',
            'id_item_stok',
            'qty',
            'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
